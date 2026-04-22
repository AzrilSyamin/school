<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['role', 'classroom.course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where(\Illuminate\Support\Facades\DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('course_id')) {
            $courseId = $request->course_id;
            $query->where(function($q) use ($courseId) {
                // 1. Users who are Classreps in classrooms of this course
                $q->whereHas('classroom', function($sq) use ($courseId) {
                    $sq->where('course_id', $courseId);
                })
                // 2. Users who are the manager of this course
                ->orWhereHas('managedCourses', function($sq) use ($courseId) {
                    $sq->where('id', $courseId);
                })
                // 3. Users who are teaching subjects in classrooms of this course
                ->orWhereHas('teachingClassrooms', function($sq) use ($courseId) {
                    $sq->where('course_id', $courseId);
                });
            });
        }

        if ($request->filled('classroom_id')) {
            $classroomId = $request->classroom_id;
            $query->where(function($q) use ($classroomId) {
                // 1. Classrep
                $q->where('classroom_id', $classroomId)
                // 2. Teachers teaching in this classroom
                ->orWhereHas('teachingClassrooms', function($sq) use ($classroomId) {
                    $sq->where('classrooms.id', $classroomId);
                });
            });
        }

        $authUser = $request->user();
        $users = $query->latest()->paginate(50)->withQueryString();
        $users->getCollection()->transform(function (User $user) use ($authUser) {
            $canManage = $authUser->can('manage', [User::class, $user, null]);

            return $user->setAttribute('can', [
                'update' => $canManage,
                'delete' => $canManage && $user->id !== $authUser->id,
            ]);
        });

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role_id', 'course_id', 'classroom_id']),
            'roles' => Role::all(),
            'courses' => \App\Models\Course::all(),
            'classrooms' => \App\Models\Classroom::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        
        // Filter roles for moderator
        if (Auth::user()->hasRole('moderator')) {
            $roles = $roles->filter(fn($role) => strtolower($role->name) !== 'admin')->values();
        }

        return Inertia::render('Users/Create', [
            'roles' => $roles,
            'classrooms' => \App\Models\Classroom::with('course')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('manage', [User::class, null, $request->role_id])) {
            return redirect()->back()->with('error', 'Anda tidak mempunyai kebenaran untuk melakukan tindakan ini.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'address' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'is_active' => 'required|boolean',
        ]);

        $picturePath = User::DEFAULT_PICTURE;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('users', 'public');
        }

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_number' => $validated['phone_number'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'picture' => $picturePath,
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'classroom_id' => $validated['classroom_id'] ?? null,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya ditambah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Request $request)
    {
        if (!$request->user()->can('manage', [User::class, $user, null])) {
            return redirect()->route('users.index')->with('error', 'Anda tidak mempunyai kebenaran untuk menyunting pengguna ini.');
        }

        $roles = Role::all();
        if (Auth::user()->hasRole('moderator')) {
            $roles = $roles->filter(fn($role) => strtolower($role->name) !== 'admin')->values();
        }

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'roles' => $roles,
            'classrooms' => \App\Models\Classroom::with('course')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!$request->user()->can('manage', [User::class, $user, $request->role_id])) {
            return redirect()->back()->with('error', 'Anda tidak mempunyai kebenaran untuk melakukan tindakan ini.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'address' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_number' => $validated['phone_number'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
            'role_id' => $validated['role_id'],
            'classroom_id' => $validated['classroom_id'] ?? null,
            'is_active' => $validated['is_active'],
        ];

        if ($request->hasFile('picture')) {
            if ($user->hasCustomPicture()) {
                Storage::disk('public')->delete($user->picture);
            }
            $data['picture'] = $request->file('picture')->store('users', 'public');
        }

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Maklumat pengguna berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
        if (!$request->user()->can('manage', [User::class, $user, null])) {
            return redirect()->back()->with('error', 'Anda tidak mempunyai kebenaran untuk memadam pengguna ini.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak boleh memadam akaun anda sendiri.');
        }

        if ($user->hasCustomPicture()) {
            Storage::disk('public')->delete($user->picture);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya dipadam.');
    }
}

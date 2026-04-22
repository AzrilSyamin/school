<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role_id', 3); // 3 = Lecturer

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where(\Illuminate\Support\Facades\DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $courseId = $request->course_id;
            $query->where(function($q) use ($courseId) {
                $q->whereHas('managedCourses', function($mq) use ($courseId) {
                    $mq->where('id', $courseId);
                })->orWhereHas('teachingClassrooms', function($tq) use ($courseId) {
                    $tq->where('course_id', $courseId);
                });
            });
        }

        if ($request->filled('classroom_id')) {
            $classroomId = $request->classroom_id;
            $query->whereHas('teachingClassrooms', function($q) use ($classroomId) {
                $q->where('classrooms.id', $classroomId);
            });
        }

        $lecturers = $query->with(['role', 'managedCourses', 'teachingClassrooms.course'])
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return Inertia::render('Lecturers/Index', [
            'lecturers' => $lecturers,
            'filters' => $request->only(['search', 'course_id', 'classroom_id']),
            'courses' => \App\Models\Course::all(),
            'classrooms' => \App\Models\Classroom::with('course')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Lecturers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        ]);

        $picturePath = User::DEFAULT_PICTURE;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('lecturers', 'public');
        }

        $lecturerRole = Role::where('name', 'Lecturer')->first();

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_number' => $validated['phone_number'] ?? null,
            'age' => $validated['age'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'picture' => $picturePath,
            'password' => Hash::make($validated['password']),
            'role_id' => $lecturerRole->id,
            'is_active' => true,
        ]);

        return redirect()->route('lecturers.index')->with('success', 'Pensyarah berjaya didaftarkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $lecturer)
    {
        return Inertia::render('Lecturers/Edit', [
            'lecturer' => $lecturer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $lecturer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $lecturer->id,
            'username' => 'required|string|max:255|unique:users,username,' . $lecturer->id,
            'phone_number' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'address' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_number' => $validated['phone_number'] ?? null,
            'age' => $validated['age'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        if ($request->hasFile('picture')) {
            if ($lecturer->hasCustomPicture()) {
                Storage::disk('public')->delete($lecturer->picture);
            }
            $data['picture'] = $request->file('picture')->store('lecturers', 'public');
        }

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $lecturer->update($data);

        return redirect()->route('lecturers.index')->with('success', 'Maklumat pensyarah berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $lecturer)
    {
        if ($lecturer->hasCustomPicture()) {
            Storage::disk('public')->delete($lecturer->picture);
        }
        
        $lecturer->delete();

        return redirect()->route('lecturers.index')->with('success', 'Pensyarah berjaya dipadam.');
    }
}

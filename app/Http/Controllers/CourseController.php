<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->roleName() ?? 'guest';

        $query = Course::with('manager')->withCount('classrooms');

        if ($role === 'lecturer') {
            $managedCourseIds = $user->managedCourseIds();
            $teachingCourseIds = $user->teachingCourseIds();
            
            $query->where(function ($q) use ($managedCourseIds, $teachingCourseIds) {
                $q->whereIn('id', $managedCourseIds)
                  ->orWhereIn('id', $teachingCourseIds);
            });
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()->paginate(10)->withQueryString();
        
        $courses->getCollection()->transform(function ($course) use ($user) {
            return array_merge($course->toArray(), [
                'can' => [
                    'view' => $user->can('view', $course),
                    'update' => $user->can('update', $course),
                    'delete' => $user->can('delete', $course),
                ]
            ]);
        });

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'filters' => ['search' => $request->input('search', '')],
            'can' => [
                'create' => $user->can('create', Course::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('create', Course::class)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak mempunyai kebenaran untuk mengakses halaman tersebut.');
        }

        $lecturers = User::whereRoleName('lecturer')->get();
        return Inertia::render('Courses/Create', [
            'lecturers' => $lecturers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create', Course::class)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak mempunyai kebenaran untuk mengakses halaman tersebut.');
        }

        $validated = $request->validate([
            'code' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Kursus berjaya dicipta.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Course $course)
    {
        if (!$request->user()->can('update', $course)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak mempunyai kebenaran untuk mengakses halaman tersebut.');
        }

        $lecturers = User::whereRoleName('lecturer')->get();
        return Inertia::render('Courses/Edit', [
            'course' => $course,
            'lecturers' => $lecturers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        if (!$request->user()->can('update', $course)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak mempunyai kebenaran untuk mengakses halaman tersebut.');
        }

        $validated = $request->validate([
            'code' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Kursus berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        if (!$request->user()->can('delete', $course)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak mempunyai kebenaran untuk mengakses halaman tersebut.');
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Kursus berjaya dipadam.');
    }
}

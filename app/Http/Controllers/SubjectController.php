<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Subject::class);
        $user = $request->user();
        $role = $user->roleName();

        $query = Subject::with('course');

        if ($role === 'lecturer') {
            $allCourseIds = $user->accessibleCourseIds();
            
            $query->whereIn('course_id', $allCourseIds);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $subjects = $query->latest()->paginate(10)->withQueryString();

        $subjects->getCollection()->transform(function ($subject) use ($user) {
            return array_merge($subject->toArray(), [
                'can' => [
                    'update' => $user->can('update', $subject),
                    'delete' => $user->can('delete', $subject),
                ]
            ]);
        });

        return Inertia::render('Subjects/Index', [
            'subjects' => $subjects,
            'filters' => $request->only(['search']),
            'can' => [
                'create' => $user->can('create', Subject::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Subject::class);
        $user = auth()->user();
        $courses = Course::query();
        if ($user->isLecturer()) {
            $courses->where('manager_id', $user->id);
        }
        $courses = $courses->get();

        return Inertia::render('Subjects/Create', [
            'courses' => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Subject::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = auth()->user();
        if ($user->isLecturer()) {
            $course = Course::find($validated['course_id']);
            if (!$course || !$user->managesCourse($course)) {
                abort(403, 'Anda tidak dibenarkan menambah mata pelajaran untuk kursus ini.');
            }
        }

        Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berjaya ditambah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);
        $user = auth()->user();
        $courses = Course::query();
        if ($user->isLecturer()) {
            $courses->where('manager_id', $user->id);
        }
        $courses = $courses->get();

        return Inertia::render('Subjects/Edit', [
            'subject' => $subject,
            'courses' => $courses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = auth()->user();
        if ($user->isLecturer()) {
            $course = Course::find($validated['course_id']);
            if (!$course || !$user->managesCourse($course)) {
                abort(403, 'Anda tidak dibenarkan mengemaskini mata pelajaran untuk kursus ini.');
            }
        }

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Maklumat mata pelajaran berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berjaya dipadam.');
    }
}

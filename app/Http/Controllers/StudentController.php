<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Student::class);

        $user = $request->user();
        $role = $user->roleName();
        
        $query = Student::with('classroom.course');

        // Initial Filter logic for Role-based access
        if ($role === 'lecturer') {
            $allCourseIds = $user->accessibleCourseIds();
            
            $query->whereHas('classroom', function ($cq) use ($allCourseIds) {
                $cq->whereIn('course_id', $allCourseIds);
            });
        } elseif ($role === 'classrep') {
            $query->where('classroom_id', $user->classroom_id);
        }

        // Search and Filter logic from Request
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        if ($request->filled('course_id')) {
            $query->whereHas('classroom', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        // Data for Filters
        $courses = \App\Models\Course::query();
        $classrooms = Classroom::query();

        if ($role === 'lecturer') {
            $managedCourseIds = $user->managedCourseIds();
            $teachingClassroomIds = $user->teachingClassroomIds();
            
            $courses->whereIn('id', $managedCourseIds)
                    ->orWhereHas('classrooms', function($q) use ($teachingClassroomIds) {
                        $q->whereIn('id', $teachingClassroomIds);
                    });
            
            $classrooms->whereIn('id', $teachingClassroomIds)
                       ->orWhereIn('course_id', $managedCourseIds);
        } elseif ($role === 'classrep') {
            $classrooms->where('id', $user->classroom_id);
            $courses->whereHas('classrooms', function($q) use ($user) {
                $q->where('id', $user->classroom_id);
            });
        }

        $students->getCollection()->transform(function ($student) use ($user) {
            return array_merge($student->toArray(), [
                'can' => [
                    'update' => $user->can('update', $student),
                    'delete' => $user->can('delete', $student),
                ]
            ]);
        });

        return Inertia::render('Students/Index', [
            'students' => $students,
            'filters' => $request->only(['search', 'classroom_id', 'course_id']),
            'classrooms' => $classrooms->with('course')->get(),
            'courses' => $courses->get(),
            'can' => [
                'create' => $user->can('create', Student::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Student::class);
        $user = auth()->user();
        $classrooms = Classroom::query();
        if ($user->isLecturer()) {
            $managedCourseIds = $user->managedCourseIds();
            $classrooms->whereIn('course_id', $managedCourseIds);
        }
        
        return Inertia::render('Students/Create', [
            'classrooms' => $classrooms->with('course')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Student::class);

        $request->merge([
            'student_id' => $this->normalizeStudentId($request->input('student_id')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|regex:/^\S+$/|unique:students',
            'email' => 'nullable|email|max:255|unique:students',
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $user = auth()->user();
        if ($user->isLecturer() && $validated['classroom_id']) {
            $classroom = Classroom::find($validated['classroom_id']);
            if (!$classroom || !$user->managesCourse($classroom->course)) {
                abort(403, 'Anda tidak dibenarkan menambah pelajar ke kelas ini.');
            }
        }

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Pelajar berjaya ditambah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $this->authorize('update', $student);
        $user = auth()->user();
        $classrooms = Classroom::query();
        if ($user->isLecturer()) {
            $managedCourseIds = $user->managedCourseIds();
            $classrooms->whereIn('course_id', $managedCourseIds);
        }

        return Inertia::render('Students/Edit', [
            'student' => $student,
            'classrooms' => $classrooms->with('course')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $this->authorize('update', $student);

        $request->merge([
            'student_id' => $this->normalizeStudentId($request->input('student_id')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|regex:/^\S+$/|unique:students,student_id,' . $student->id,
            'email' => 'nullable|email|max:255|unique:students,email,' . $student->id,
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $user = auth()->user();
        if ($user->isLecturer() && $validated['classroom_id']) {
            $classroom = Classroom::find($validated['classroom_id']);
            if (!$classroom || !$user->managesCourse($classroom->course)) {
                abort(403, 'Anda tidak dibenarkan mengemaskini maklumat pelajar dalam kelas ini.');
            }
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Maklumat pelajar berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Pelajar berjaya dipadam.');
    }

    private function normalizeStudentId(?string $studentId): ?string
    {
        if ($studentId === null) {
            return null;
        }

        return strtoupper(preg_replace('/\s+/', '', $studentId));
    }
}

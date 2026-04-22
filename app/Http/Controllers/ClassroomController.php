<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Classroom::class);
        $user = $request->user();
        $role = $user->roleName();

        $query = Classroom::with(['course', 'teachers', 'classrep']);

        if ($role === 'lecturer') {
            $allCourseIds = $user->accessibleCourseIds();
            
            $query->whereIn('course_id', $allCourseIds);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $classrooms = $query->latest()->paginate(10)->withQueryString();

        $classrooms->getCollection()->transform(function ($classroom) use ($user) {
            return array_merge($classroom->toArray(), [
                'can' => [
                    'update' => $user->can('update', $classroom),
                    'delete' => $user->can('delete', $classroom),
                ]
            ]);
        });

        return Inertia::render('Classrooms/Index', [
            'classrooms' => $classrooms,
            'filters' => $request->only(['search']),
            'can' => [
                'create' => $user->can('create', Classroom::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Classroom::class);
        $lecturers = User::whereRoleName('lecturer')->get();

        $user = auth()->user();
        $courses = Course::query();
        if ($user->isLecturer()) {
            $courses->where('manager_id', $user->id);
        }
        $courses = $courses->get();

        return Inertia::render('Classrooms/Create', [
            'lecturers' => $lecturers,
            'courses' => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Classroom::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = auth()->user();
        if ($user->isLecturer()) {
            $course = Course::find($validated['course_id']);
            if (!$course || !$user->managesCourse($course)) {
                abort(403, 'Anda tidak dibenarkan menambah kelas untuk kursus ini.');
            }
        }

        $classroom = Classroom::create([
            'name' => $validated['name'],
            'course_id' => $validated['course_id']
        ]);

        return redirect()->route('classrooms.index')->with('success', 'Kelas berjaya ditambah. Sila kemaskini kelas untuk menetapkan pensyarah bagi setiap mata pelajaran.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $this->authorize('update', $classroom);
        
        $lecturers = User::whereRoleName('lecturer')->get();

        $user = auth()->user();
        $courses = Course::query();
        if ($user->isLecturer()) {
            $courses->where('manager_id', $user->id);
        }
        $courses = $courses->get();
        
        // Load subjects of the course this classroom belongs to
        $classroom->load(['course.subjects', 'subjects', 'classrep']);

        // Fetch ALL students in this classroom from the 'students' table
        $allStudents = \App\Models\Student::where('classroom_id', $classroom->id)->get(['id', 'name', 'email']);

        // Map existing subject assignments
        $subjectAssignments = $classroom->subjects->pluck('pivot.lecturer_id', 'id')->toArray();

        return Inertia::render('Classrooms/Edit', [
            'classroom' => $classroom,
            'lecturers' => $lecturers,
            'courses' => $courses,
            'subjects' => $classroom->course->subjects,
            'subjectAssignments' => (object)$subjectAssignments,
            'eligibleStudents' => $allStudents,
            'currentClassrepEmail' => $classroom->classrep?->email,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'subject_assignments' => 'nullable|array',
            'subject_assignments.*' => 'nullable|exists:users,id',
            'classrep_email' => 'nullable|string',
            'classrep_id' => 'nullable|exists:students,id', // Added to identify the student accurately
        ]);

        $user = auth()->user();
        if ($user->isLecturer()) {
            $course = Course::find($validated['course_id']);
            if (!$course || !$user->managesCourse($course)) {
                abort(403, 'Anda tidak dibenarkan mengemaskini kelas untuk kursus ini.');
            }
        }

        $classroom->update([
            'name' => $validated['name'],
            'course_id' => $validated['course_id']
        ]);

        // Handle Classrep appointment
        if ($request->filled('classrep_email') && $request->filled('classrep_id')) {
            // Update the student's email in the students table first
            $student = \App\Models\Student::find($validated['classrep_id']);
            if ($student && $student->classroom_id == $classroom->id) {
                $student->update(['email' => $validated['classrep_email']]);
                
                $status = $this->handleClassrepAppointment($classroom, $validated['classrep_email']);
                if (!$status) {
                    return redirect()->back()->with('error', 'Gagal melantik ketua kelas.');
                }
            }
        } elseif (!$request->filled('classrep_email')) {
            // Remove current classrep if selection is empty
            User::where('role_id', 5)
                ->where('classroom_id', $classroom->id)
                ->update([
                    'role_id' => 4,
                    'is_active' => 0
                ]);
        }

        // Sync subjects with their assigned lecturers
        $syncData = [];
        if (!empty($validated['subject_assignments'])) {
            foreach ($validated['subject_assignments'] as $subjectId => $lecturerId) {
                if ($lecturerId) {
                    $syncData[$subjectId] = ['lecturer_id' => $lecturerId];
                } else {
                    $syncData[$subjectId] = ['lecturer_id' => null];
                }
            }
        }
        
        $classroom->subjects()->sync($syncData);

        return redirect()->route('classrooms.index')->with('success', 'Maklumat kelas, tugasan pensyarah, dan ketua kelas berjaya dikemaskini.');
    }

    private function handleClassrepAppointment(Classroom $classroom, $email)
    {
        // 1. Find the Student record to get their full name
        $student = \App\Models\Student::where('email', $email)
            ->where('classroom_id', $classroom->id)
            ->first();

        // 2. Demote current classrep(s) of this classroom back to Student (role 4) AND deactivate
        User::where('role_id', 5)
            ->where('classroom_id', $classroom->id)
            ->update([
                'role_id' => 4,
                'is_active' => 0
            ]);

        // 3. Find or Create the User associated with this student email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Update existing user to Classrep and ensure they are active
            $user->update([
                'role_id' => 5,
                'is_active' => 1,
                'classroom_id' => $classroom->id
            ]);
        } else if ($student) {
            // Split name into first and last name
            $nameParts = explode(' ', $student->name, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            // Create new User account
            User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'username' => null, // Empty as requested
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role_id' => 5,
                'classroom_id' => $classroom->id,
                'is_active' => 1,
                'picture' => User::DEFAULT_PICTURE,
            ]);
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $this->authorize('delete', $classroom);
        // Check if classroom has students
        if ($classroom->students()->count() > 0) {
            return redirect()->back()->with('error', 'Kelas tidak boleh dipadam kerana mempunyai pelajar.');
        }

        $classroom->delete();

        return redirect()->route('classrooms.index')->with('success', 'Kelas berjaya dipadam.');
    }
}

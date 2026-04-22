<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance for lecturers.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $role = $user->roleName();

        // Group by subject, classroom, and date to show sessions
        $query = Attendance::query()
            ->select('subject_id', 'classroom_id', 'date', 'recorded_by')
            ->with(['subject', 'classroom.course', 'recorder'])
            ->groupBy('subject_id', 'classroom_id', 'date', 'recorded_by');

        if ($role === 'lecturer') {
            $managedCourseIds = $user->managedCourseIds();
            
            $query->where(function ($q) use ($managedCourseIds, $user) {
                // 1. Manager of the course sees all in that course
                $q->whereHas('classroom', function ($cq) use ($managedCourseIds) {
                    $cq->whereIn('course_id', $managedCourseIds);
                })
                // 2. OR teacher of the subject in the specific classroom
                ->orWhereExists(function ($ex) use ($user) {
                    $ex->select(\DB::raw(1))
                       ->from('classroom_subject')
                       ->whereColumn('classroom_subject.classroom_id', 'attendances.classroom_id')
                       ->whereColumn('classroom_subject.subject_id', 'attendances.subject_id')
                       ->where('classroom_subject.lecturer_id', $user->id);
                });
            });
        } elseif ($role === 'classrep') {
            $courseId = $user->classroom ? $user->classroom->course_id : 0;
            $query->whereHas('classroom', function($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($user->isAdminLike() && $request->filled('course_id')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        $sessions = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        $classrooms = [];
        $subjects = [];
        $courses = [];

        if (in_array($role, ['admin', 'moderator'])) {
            $classrooms = Classroom::with('course')->get();
            $subjects = Subject::all();
            $courses = Course::orderBy('name')->get();
        } elseif ($role === 'lecturer') {
            $managedCourseIds = $user->managedCourseIds();
            $classrooms = Classroom::whereIn('course_id', $managedCourseIds)
                ->orWhereHas('subjects', function($q) use ($user) {
                    $q->where('lecturer_id', $user->id);
                })
                ->with('course')
                ->get();
                
            $subjects = Subject::whereIn('course_id', $managedCourseIds)
                ->orWhereHas('classrooms', function($q) use ($user) {
                    $q->where('lecturer_id', $user->id);
                })
                ->get();
        } elseif ($role === 'classrep') {
            $courseId = $user->classroom ? $user->classroom->course_id : 0;
            $classrooms = Classroom::where('course_id', $courseId)->with('course')->get();
            $subjects = Subject::where('course_id', $courseId)->get();
        }

        $sessions->getCollection()->transform(function ($session) use ($user) {
            // Find one record to check permissions
            $attendance = Attendance::where('subject_id', $session->subject_id)
                ->where('classroom_id', $session->classroom_id)
                ->whereDate('date', $session->date)
                ->first();
                
            return array_merge($session->toArray(), [
                'can' => [
                    'update' => $attendance ? $user->can('update', $attendance) : false,
                ]
            ]);
        });

        return Inertia::render('Attendances/Index', [
            'sessions' => $sessions,
            'classrooms' => $classrooms,
            'subjects' => $subjects,
            'courses' => $courses,
            'filters' => $request->only(['date', 'classroom_id', 'subject_id', 'course_id']),
            'can' => [
                'create' => $user->can('create', Attendance::class),
            ]
        ]);
    }

    /**
     * Display the detailed student list for a specific attendance session.
     */
    public function show(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
        ]);

        $attendances = Attendance::with(['student', 'subject', 'classroom', 'recorder'])
            ->where('subject_id', $request->subject_id)
            ->where('classroom_id', $request->classroom_id)
            ->whereDate('date', $request->date)
            ->get();

        if ($attendances->isEmpty()) {
            return redirect()->route('attendances.index')->with('error', 'Sesi kehadiran tidak dijumpai.');
        }

        return Inertia::render('Attendances/Show', [
            'attendances' => $attendances,
            'session' => [
                'subject' => $attendances->first()->subject,
                'classroom' => $attendances->first()->classroom,
                'date' => $request->date,
                'recorder' => $attendances->first()->recorder,
            ],
            'can' => [
                'update' => auth()->user()->can('update', $attendances->first()),
            ]
        ]);
    }

    /**
     * Show the form for editing an existing attendance session.
     */
    public function edit(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
        ]);

        $attendances = Attendance::where('subject_id', $request->subject_id)
            ->where('classroom_id', $request->classroom_id)
            ->whereDate('date', $request->date)
            ->get();

        if ($attendances->isEmpty()) {
            return redirect()->route('attendances.index')->with('error', 'Sesi kehadiran tidak dijumpai.');
        }

        // Check permission on the first record
        $this->authorize('update', $attendances->first());

        $classroom = Classroom::with(['subjects', 'course'])->find($request->classroom_id);
        $students = Student::where('classroom_id', $request->classroom_id)->get();
        $subjects = $classroom->subjects;

        return Inertia::render('Attendances/Create', [
            'classrooms' => Classroom::all(),
            'selectedClassroom' => $classroom,
            'students' => $students,
            'subjects' => $subjects,
            'date' => $request->date,
            'existingAttendances' => $attendances,
            'isEditing' => true,
        ]);
    }

    /**
     * Show the form for taking attendance (for classrep/lecturer).
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $role = $user->roleName();

        if (!in_array($role, ['classrep', 'lecturer', 'admin', 'moderator'])) {
            abort(403);
        }

        $classroom_id = $request->classroom_id ?: $user->classroom_id;
        
        if (!$classroom_id && $role === 'classrep') {
             return redirect()->back()->with('error', 'Anda tidak mempunyai kelas yang ditetapkan.');
        }

        $classrooms = [];
        if ($role === 'admin' || $role === 'moderator') {
            $classrooms = Classroom::with('course')->get();
        } elseif ($role === 'lecturer') {
            $managedCourseIds = $user->managedCourseIds();
            $classrooms = Classroom::whereIn('course_id', $managedCourseIds)
                ->orWhereHas('subjects', function($q) use ($user) {
                    $q->where('lecturer_id', $user->id);
                })
                ->with('course')
                ->get();
        } elseif ($role === 'classrep') {
            $courseId = $user->classroom?->course_id ?: 0;
            $classrooms = Classroom::where('course_id', $courseId)->with('course')->get();
        }

        $classroom = Classroom::with(['subjects', 'course'])->find($classroom_id);
        $students = $classroom ? Student::where('classroom_id', $classroom->id)->get() : collect();
        $subjects = $classroom ? $classroom->subjects : collect();

        // If lecturer, only show subjects they teach in this classroom, 
        // UNLESS they are the course manager (who can see/edit all subjects in their course)
        if ($role === 'lecturer' && $classroom) {
            $isManager = $classroom->course && $user->managesCourse($classroom->course);
            if (!$isManager) {
                $teachingSubjectIds = $user->teachingSubjects()->pluck('subjects.id');
                $subjects = $subjects->whereIn('id', $teachingSubjectIds);
            }
        }

        return Inertia::render('Attendances/Create', [
            'classrooms' => $classrooms,
            'selectedClassroom' => $classroom,
            'students' => $students,
            'subjects' => $subjects->values(),
            'date' => now()->toDateString(),
        ]);
    }

    /**
     * Store attendance records.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $role = $user->roleName();

        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|string|in:Hadir,Ponteng,Sakit,Kecemasan',
            'attendances.*.remarks' => 'nullable|string|max:255',
        ]);

        $classroom = Classroom::find($validated['classroom_id']);
        
        if ($role === 'lecturer') {
            $isManager = $user->managesCourse($classroom->course);
            $isTeacher = $user->teachesSubjectInClassroom($validated['classroom_id'], $validated['subject_id']);
                
            if (!$isManager && !$isTeacher) {
                abort(403, 'Anda tidak dibenarkan merekod kehadiran untuk mata pelajaran/kelas ini.');
            }
        } elseif ($role === 'classrep') {
            if (!$user->classroom || $classroom->course_id !== $user->classroom->course_id) {
                abort(403, 'Anda tidak dibenarkan merekod kehadiran di luar kursus anda.');
            }
        }

        foreach ($validated['attendances'] as $record) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $record['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'classroom_id' => $validated['classroom_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $record['status'],
                    'remarks' => $record['remarks'] ?? null,
                    'recorded_by' => $user->id,
                ]
            );
        }

        return redirect()->route('attendances.index')->with('success', 'Kehadiran berjaya direkodkan.');
    }
}

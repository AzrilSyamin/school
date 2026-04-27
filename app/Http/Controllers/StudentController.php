<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $query = $this->filteredStudentQuery($request);

        $students = $query->latest()->paginate(10)->withQueryString();

        // Data for Filters
        $courses = Course::query();
        $classrooms = Classroom::query();

        if ($role === 'lecturer') {
            $managedCourseIds = $user->managedCourseIds();
            $teachingClassroomIds = $user->teachingClassroomIds();

            $courses->whereIn('id', $managedCourseIds)
                ->orWhereHas('classrooms', function ($q) use ($teachingClassroomIds) {
                    $q->whereIn('id', $teachingClassroomIds);
                });

            $classrooms->whereIn('id', $teachingClassroomIds)
                ->orWhereIn('course_id', $managedCourseIds);
        } elseif ($role === 'classrep') {
            $classrooms->where('id', $user->classroom_id);
            $courses->whereHas('classrooms', function ($q) use ($user) {
                $q->where('id', $user->classroom_id);
            });
        }

        $students->getCollection()->transform(function ($student) use ($user) {
            return array_merge($student->toArray(), [
                'can' => [
                    'update' => $user->can('update', $student),
                    'delete' => $user->can('delete', $student),
                ],
            ]);
        });

        return Inertia::render('Students/Index', [
            'students' => $students,
            'filters' => $request->only(['search', 'classroom_id', 'course_id']),
            'classrooms' => $classrooms->with('course')->get(),
            'courses' => $courses->get(),
            'can' => [
                'create' => $user->can('create', Student::class),
            ],
        ]);
    }

    public function export(Request $request, string $format)
    {
        $this->authorize('viewAny', Student::class);

        $format = strtolower($format);
        abort_unless(in_array($format, ['csv', 'pdf'], true), 404);

        $students = $this->filteredStudentQuery($request)
            ->orderBy('name')
            ->get();

        $filename = 'senarai-pelajar-'.now()->format('Y-m-d-His');

        if ($format === 'csv') {
            return response()->streamDownload(function () use ($students) {
                $handle = fopen('php://output', 'w');
                fwrite($handle, "\xEF\xBB\xBF");
                fputcsv($handle, ['Nama', 'Student ID', 'NRIC / No. IC', 'Emel', 'Jantina', 'Kelas', 'Kursus']);

                foreach ($students as $student) {
                    fputcsv($handle, [
                        $student->name,
                        $student->student_id,
                        $student->nric,
                        $student->email,
                        $student->gender,
                        $student->classroom?->name,
                        $student->classroom?->course?->name,
                    ]);
                }

                fclose($handle);
            }, $filename.'.csv', [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

        return Pdf::loadView('exports.students', [
            'students' => $students,
            'generatedAt' => now(),
            'filters' => $request->only(['search', 'classroom_id', 'course_id']),
        ])->setPaper('a4', 'portrait')->download($filename.'.pdf');
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
            'classrooms' => $classrooms->with('course')->get(),
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
            'nric' => $this->normalizeNric($request->input('nric')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|regex:/^\S+$/|unique:students',
            'nric' => 'nullable|string|max:20|regex:/^[0-9-]+$/|unique:students,nric',
            'email' => 'nullable|email|max:255|unique:students',
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ], [
            'nric.regex' => 'NRIC hanya boleh mengandungi nombor dan dash (-).',
        ]);

        $user = auth()->user();
        if ($user->isLecturer() && $validated['classroom_id']) {
            $classroom = Classroom::find($validated['classroom_id']);
            if (! $classroom || ! $user->managesCourse($classroom->course)) {
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
            'classrooms' => $classrooms->with('course')->get(),
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
            'nric' => $this->normalizeNric($request->input('nric')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|regex:/^\S+$/|unique:students,student_id,'.$student->id,
            'nric' => 'nullable|string|max:20|regex:/^[0-9-]+$/|unique:students,nric,'.$student->id,
            'email' => 'nullable|email|max:255|unique:students,email,'.$student->id,
            'age' => 'nullable|integer|min:1',
            'gender' => 'nullable|in:Lelaki,Perempuan',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ], [
            'nric.regex' => 'NRIC hanya boleh mengandungi nombor dan dash (-).',
        ]);

        $user = auth()->user();
        if ($user->isLecturer() && $validated['classroom_id']) {
            $classroom = Classroom::find($validated['classroom_id']);
            if (! $classroom || ! $user->managesCourse($classroom->course)) {
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

    private function normalizeNric(?string $nric): ?string
    {
        if ($nric === null) {
            return null;
        }

        $normalized = preg_replace('/\s+/', '', $nric);

        return $normalized === '' ? null : $normalized;
    }

    private function filteredStudentQuery(Request $request)
    {
        $user = $request->user();
        $role = $user->roleName();
        $query = Student::with('classroom.course');

        if ($role === 'lecturer') {
            $allCourseIds = $user->accessibleCourseIds();

            $query->whereHas('classroom', function ($cq) use ($allCourseIds) {
                $cq->whereIn('course_id', $allCourseIds);
            });
        } elseif ($role === 'classrep') {
            $query->where('classroom_id', $user->classroom_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('nric', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        if ($request->filled('course_id')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        return $query;
    }
}

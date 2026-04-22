<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected $classrep;
    protected $classroom;
    protected $subject;
    protected $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);
        $this->classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);
        $this->subject = Subject::create(['name' => 'Math', 'course_id' => $course->id]);
        $this->student = Student::factory()->create(['classroom_id' => $this->classroom->id]);
        
        $this->classrep = User::factory()->create([
            'role_id' => 5, // Classrep
            'classroom_id' => $this->classroom->id
        ]);
    }

    public function test_classrep_can_record_attendance(): void
    {
        $response = $this->actingAs($this->classrep)->post('/attendances', [
            'subject_id' => $this->subject->id,
            'classroom_id' => $this->classroom->id,
            'date' => now()->toDateString(),
            'attendances' => [
                [
                    'student_id' => $this->student->id,
                    'status' => 'Hadir',
                    'remarks' => 'Good'
                ]
            ]
        ]);

        $response->assertRedirect('/attendances');
        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'status' => 'Hadir',
            'remarks' => 'Good'
        ]);
    }

    public function test_lecturer_can_view_attendance_for_their_classroom(): void
    {
        $lecturer = User::factory()->create(['role_id' => 3]); // lecturer
        $this->classroom->subjects()->attach($this->subject->id, [
            'lecturer_id' => $lecturer->id
        ]);

        Attendance::create([
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
            'classroom_id' => $this->classroom->id,
            'date' => now()->toDateString(),
            'status' => 'Hadir',
            'recorded_by' => $this->classrep->id
        ]);

        $response = $this->actingAs($lecturer)->get('/attendances');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Attendances/Index')
            ->has('sessions')
        );
    }

    public function test_student_cannot_view_attendance(): void
    {
        $studentUser = User::factory()->create(['role_id' => 4]);

        $response = $this->actingAs($studentUser)->get('/attendances');

        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_filter_attendance_by_course(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $otherCourse = Course::create(['name' => 'Business', 'code' => 'BBM']);
        $otherClassroom = Classroom::create(['name' => 'Class B', 'course_id' => $otherCourse->id]);
        $otherSubject = Subject::create(['name' => 'Accounting', 'course_id' => $otherCourse->id]);
        $otherStudent = Student::factory()->create(['classroom_id' => $otherClassroom->id]);

        Attendance::create([
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
            'classroom_id' => $this->classroom->id,
            'date' => now()->toDateString(),
            'status' => 'Hadir',
            'recorded_by' => $this->classrep->id,
        ]);

        Attendance::create([
            'student_id' => $otherStudent->id,
            'subject_id' => $otherSubject->id,
            'classroom_id' => $otherClassroom->id,
            'date' => now()->toDateString(),
            'status' => 'Ponteng',
            'recorded_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/attendances?course_id=' . $otherCourse->id);

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Attendances/Index')
            ->has('sessions.data', 1)
            ->where('sessions.data.0.classroom_id', $otherClassroom->id)
            ->where('filters.course_id', (string) $otherCourse->id)
            ->has('courses', 2)
        );
    }

    public function test_course_filter_does_not_expand_lecturer_attendance_access(): void
    {
        $lecturer = User::factory()->create(['role_id' => 3]);
        $otherCourse = Course::create(['name' => 'Business', 'code' => 'BBM']);
        $otherClassroom = Classroom::create(['name' => 'Class B', 'course_id' => $otherCourse->id]);
        $otherSubject = Subject::create(['name' => 'Accounting', 'course_id' => $otherCourse->id]);
        $otherStudent = Student::factory()->create(['classroom_id' => $otherClassroom->id]);

        $this->classroom->subjects()->attach($this->subject->id, [
            'lecturer_id' => $lecturer->id,
        ]);

        Attendance::create([
            'student_id' => $this->student->id,
            'subject_id' => $this->subject->id,
            'classroom_id' => $this->classroom->id,
            'date' => now()->toDateString(),
            'status' => 'Hadir',
            'recorded_by' => $this->classrep->id,
        ]);

        Attendance::create([
            'student_id' => $otherStudent->id,
            'subject_id' => $otherSubject->id,
            'classroom_id' => $otherClassroom->id,
            'date' => now()->toDateString(),
            'status' => 'Ponteng',
            'recorded_by' => $this->classrep->id,
        ]);

        $response = $this->actingAs($lecturer)->get('/attendances?course_id=' . $otherCourse->id);

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Attendances/Index')
            ->has('sessions.data', 1)
            ->where('sessions.data.0.classroom_id', $this->classroom->id)
            ->where('filters.course_id', (string) $otherCourse->id)
        );
    }
}

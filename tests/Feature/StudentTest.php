<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_create_student(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);
        $classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);

        $response = $this->actingAs($admin)->post('/students', [
            'name' => 'John Doe',
            'student_id' => 'S123',
            'email' => 'john@example.com',
            'gender' => 'Lelaki',
            'age' => 20,
            'classroom_id' => $classroom->id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', ['name' => 'John Doe']);
    }

    public function test_student_id_is_normalized_when_created(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);
        $classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);

        $response = $this->actingAs($admin)->post('/students', [
            'name' => 'Normalized Student',
            'student_id' => 'std 123 ab',
            'classroom_id' => $classroom->id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'name' => 'Normalized Student',
            'student_id' => 'STD123AB',
        ]);
    }

    public function test_student_id_is_normalized_when_updated(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $student = Student::factory()->create(['student_id' => 'OLD123']);

        $response = $this->actingAs($admin)->put("/students/{$student->id}", [
            'name' => $student->name,
            'student_id' => 'new 456 cd',
            'email' => $student->email,
            'gender' => $student->gender,
            'age' => $student->age,
            'classroom_id' => $student->classroom_id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'student_id' => 'NEW456CD',
        ]);
    }

    public function test_course_manager_can_create_student_in_their_course(): void
    {
        $manager = User::factory()->create(['role_id' => 3]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT', 'manager_id' => $manager->id]);
        $classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);

        $response = $this->actingAs($manager)->post('/students', [
            'name' => 'Managed Student',
            'student_id' => 'S456',
            'email' => 'managed@example.com',
            'gender' => 'Perempuan',
            'age' => 21,
            'classroom_id' => $classroom->id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', ['student_id' => 'S456']);
    }

    public function test_unauthorized_lecturer_cannot_create_student(): void
    {
        $lecturer = User::factory()->create(['role_id' => 3]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);
        $classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);

        $response = $this->actingAs($lecturer)->post('/students', [
            'name' => 'Illegal Student',
            'student_id' => 'S789',
            'classroom_id' => $classroom->id,
        ]);

        $response->assertForbidden();
    }
}

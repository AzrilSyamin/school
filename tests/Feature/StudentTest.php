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
            'nric' => '010101-01-0101',
            'email' => 'john@example.com',
            'gender' => 'Lelaki',
            'age' => 20,
            'classroom_id' => $classroom->id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'name' => 'John Doe',
            'nric' => '010101-01-0101',
        ]);
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

    public function test_nric_is_normalized_when_created(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);
        $classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);

        $response = $this->actingAs($admin)->post('/students', [
            'name' => 'NRIC Student',
            'student_id' => 'S999',
            'nric' => '010101 01 0101',
            'classroom_id' => $classroom->id,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'name' => 'NRIC Student',
            'nric' => '010101010101',
        ]);
    }

    public function test_nric_rejects_characters_other_than_numbers_and_dash(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);
        $classroom = Classroom::create(['name' => 'Class A', 'course_id' => $course->id]);

        $response = $this->actingAs($admin)->from('/students/create')->post('/students', [
            'name' => 'Invalid NRIC Student',
            'student_id' => 'S998',
            'nric' => '010101-A1-0101',
            'classroom_id' => $classroom->id,
        ]);

        $response->assertRedirect('/students/create');
        $response->assertSessionHasErrors('nric');
        $this->assertDatabaseMissing('students', [
            'student_id' => 'S998',
        ]);
    }

    public function test_admin_can_export_students_csv_and_pdf(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        Student::factory()->create([
            'name' => 'Export Student',
            'student_id' => 'EXP001',
            'nric' => '020202-02-0202',
        ]);

        $csvResponse = $this->actingAs($admin)->get('/students/export/csv');
        $csvResponse->assertOk();
        $csvResponse->assertDownload();

        $pdfResponse = $this->actingAs($admin)->get('/students/export/pdf');
        $pdfResponse->assertOk();
        $pdfResponse->assertDownload();
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

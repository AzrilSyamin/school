<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_create_subject(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);

        $response = $this->actingAs($admin)->post('/subjects', [
            'name' => 'Algorithm',
            'code' => 'CS101',
            'course_id' => $course->id,
        ]);

        $response->assertRedirect('/subjects');
        $this->assertDatabaseHas('subjects', ['name' => 'Algorithm']);
    }

    public function test_course_manager_can_create_subject_in_their_course(): void
    {
        $manager = User::factory()->create(['role_id' => 3]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT', 'manager_id' => $manager->id]);

        $response = $this->actingAs($manager)->post('/subjects', [
            'name' => 'Manager Subject',
            'code' => 'MS101',
            'course_id' => $course->id,
        ]);

        $response->assertRedirect('/subjects');
        $this->assertDatabaseHas('subjects', ['name' => 'Manager Subject']);
    }

    public function test_unauthorized_lecturer_cannot_create_subject(): void
    {
        $lecturer = User::factory()->create(['role_id' => 3]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']); // No manager assigned

        $response = $this->actingAs($lecturer)->post('/subjects', [
            'name' => 'Illegal Subject',
            'code' => 'IS101',
            'course_id' => $course->id,
        ]);

        $response->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_create_classroom(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT']);

        $response = $this->actingAs($admin)->post('/classrooms', [
            'name' => 'Class X',
            'course_id' => $course->id,
        ]);

        $response->assertRedirect('/classrooms');
        $this->assertDatabaseHas('classrooms', ['name' => 'Class X']);
    }

    public function test_course_manager_can_create_classroom_in_their_course(): void
    {
        $manager = User::factory()->create(['role_id' => 3]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT', 'manager_id' => $manager->id]);

        $response = $this->actingAs($manager)->post('/classrooms', [
            'name' => 'Manager Class',
            'course_id' => $course->id,
        ]);

        $response->assertRedirect('/classrooms');
        $this->assertDatabaseHas('classrooms', ['name' => 'Manager Class']);
    }

    public function test_lecturer_cannot_create_classroom_in_other_course(): void
    {
        $lecturer = User::factory()->create(['role_id' => 3]);
        $otherManager = User::factory()->create(['role_id' => 3]);
        $course = Course::create(['name' => 'IT', 'code' => 'BIT', 'manager_id' => $otherManager->id]);

        $response = $this->actingAs($lecturer)->post('/classrooms', [
            'name' => 'Unauthorized Class',
            'course_id' => $course->id,
        ]);

        $response->assertForbidden();
    }
}

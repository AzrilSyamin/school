<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $lecturer;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $this->admin = User::factory()->create(['role_id' => 1]); // Admin
        $this->lecturer = User::factory()->create(['role_id' => 3]); // Lecturer
    }

    public function test_admin_can_view_courses(): void
    {
        $response = $this->actingAs($this->admin)->get('/courses');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_course(): void
    {
        $response = $this->actingAs($this->admin)->post('/courses', [
            'name' => 'New Course',
            'code' => 'NC101',
            'description' => 'A new test course'
        ]);

        $response->assertRedirect('/courses');
        $this->assertDatabaseHas('courses', ['code' => 'NC101']);
    }

    public function test_lecturer_cannot_create_course(): void
    {
        $response = $this->actingAs($this->lecturer)->post('/courses', [
            'name' => 'Hack Course',
            'code' => 'HC666'
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_lecturer_can_view_courses_index(): void
    {
        $response = $this->actingAs($this->lecturer)->get('/courses');
        $response->assertStatus(200);
    }
}

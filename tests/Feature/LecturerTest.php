<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LecturerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_view_lecturers_list(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($admin)->get('/lecturers');

        $response->assertStatus(200);
    }

    public function test_moderator_can_create_lecturer(): void
    {
        $moderator = User::factory()->create(['role_id' => 2]);

        $response = $this->actingAs($moderator)->post('/lecturers', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'username' => 'janesmith',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/lecturers');
        $this->assertDatabaseHas('users', ['username' => 'janesmith']);
    }

    public function test_lecturer_cannot_delete_other_lecturers(): void
    {
        $lecturer1 = User::factory()->create(['role_id' => 3]);
        $lecturer2 = User::factory()->create(['role_id' => 3]);

        $response = $this->actingAs($lecturer1)->delete("/lecturers/{$lecturer2->id}");

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['id' => $lecturer2->id]);
    }
}

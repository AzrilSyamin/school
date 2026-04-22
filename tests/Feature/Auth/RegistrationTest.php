<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'phone_number' => '0123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Should not be authenticated immediately
        $this->assertGuest();
        
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status', 'Akaun berjaya didaftar. Sila tunggu pengesahan daripada Admin sebelum boleh log masuk.');

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'is_active' => 0,
            'role_id' => 4,
        ]);
    }
}

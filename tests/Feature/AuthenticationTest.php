<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'accessToken',
            ]);
    }

    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertUnprocessable();
    }

    public function test_user_can_register_with_correct_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Passwd123!',
            'password_confirmation' => 'Passwd123!',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'accessToken',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_cannot_register_with_weak_password(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertJsonStructure(['errors'])
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field must be at least 10 characters.',
                    'The password field must contain at least one uppercase and one lowercase letter.',
                    'The password field must contain at least one symbol.',
                    'The password field must contain at least one number.',
                ],
            ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_cannot_register_with_incorrect_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ]);

        $response->assertUnprocessable();

        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}

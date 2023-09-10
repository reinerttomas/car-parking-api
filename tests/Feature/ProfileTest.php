<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_their_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/profile');

        $response->assertSuccessful()
            ->assertJsonStructure(['name', 'email'])
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    public function test_public_user_cannot_get_their_profile(): void
    {
        $response = $this->getJson('/api/v1/profile');

        $response->assertUnauthorized()
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_user_can_update_name_and_email(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
        ]);

        $response->assertAccepted()
            ->assertJsonStructure(['name', 'email'])
            ->assertJson([
                'name' => 'John Updated',
                'email' => 'john.updated@example.com',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
        ]);
    }

    public function test_user_can_update_only_name(): void
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
        ]);

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'John Updated',
            'email' => 'john.doe@example.com',
        ]);

        $response->assertAccepted()
            ->assertJsonStructure(['name', 'email'])
            ->assertJson([
                'name' => 'John Updated',
                'email' => 'john.doe@example.com',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Updated',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_user_cannot_update_with_empty_body(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile');

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'name' => [
                    'The name field is required.',
                ],
                'email' => [
                    'The email field is required.',
                ],
            ]);
    }

    public function test_user_cannot_update_with_not_valid_email(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'John Doe',
            'email' => 'john.doe',
        ]);

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'email' => [
                    'The email field must be a valid email address.',
                ],
            ]);
    }

    public function test_user_cannot_update_email_if_already_taken(): void
    {
        User::factory()->create(['email' => 'john.doe@example.com']);
        $userJohn = User::factory()->create();

        $response = $this->actingAs($userJohn)->putJson('/api/v1/profile', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'email' => [
                    'The email has already been taken.',
                ],
            ]);
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'currentPassword' => 'password',
            'password' => 'Passwd123!',
            'password_confirmation' => 'Passwd123!',
        ]);

        $response->assertAccepted();
    }

    public function test_user_cannot_change_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'currentPassword' => 'wrong-password',
            'password' => 'Passwd123!',
            'password_confirmation' => 'Passwd123!',
        ]);

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'currentPassword' => [
                    'The password is incorrect.',
                ],
            ]);
    }

    public function test_user_cannot_change_password_with_password_confirmation_not_matching(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'currentPassword' => 'password',
            'password' => 'Password123!',
            'password_confirmation' => 'HelloWorld123!',
        ]);

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field confirmation does not match.',
                ],
            ]);
    }

    public function test_user_cannot_change_password_which_is_weak(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'test',
            'password_confirmation' => 'test',
        ]);

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field must be at least 10 characters.',
                    'The password field must contain at least one uppercase and one lowercase letter.',
                    'The password field must contain at least one symbol.',
                    'The password field must contain at least one number.',
                ],
            ]);
    }
}

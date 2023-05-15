<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirProfile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/profile');

        $response->assertStatus(200)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'name' => $user->name,
                'email' => $user->email
            ]);
    }

    public function testNotAuthenticatedUserCannotGetProfile(): void
    {
        $response = $this->getJson('/api/v1/profile');

        $response->assertStatus(401)
            ->assertJsonStructure(['message'])
            ->assertJsonCount(1)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function testUserCanUpdateNameAndEmail(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com'
        ]);

        $response->assertStatus(202)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'name' => 'John Updated',
                'email' => 'john.updated@example.com',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
        ]);
    }

    public function testUserCannotUpdateWithEmptyBody(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile');

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                    'email' => [
                        'The email field is required.'
                    ],
                ]
            ]);
    }

    public function testUserCannotUpdateWithNotValidEmail(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'John Doe',
            'email' => 'john.doe'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'errors' => [
                    'email' => [
                        'The email field must be a valid email address.'
                    ],
                ]
            ]);
    }

    public function testUserCanChangePassword(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'password123!',
            'password_confirmation' => 'password123!',
        ]);

        $response->assertStatus(202);
    }

    public function testUserCannotChangePasswordWithWrongCurrentPassword(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'wrong-password',
            'password' => 'password123!',
            'password_confirmation' => 'password123!',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonCount(2)
            ->assertJsonValidationErrors([
                'current_password' => [
                    'password' => [
                        'The password is incorrect.'
                    ],
                ]
            ]);
    }

    public function testUserCannotChangePasswordWithPasswordConfirmationNotMatching(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'password123',
            'password_confirmation' => '123456789',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field confirmation does not match.'
                ],
            ]);
    }

    public function testUserCannotChangePasswordWhichContainsLessThanEightCharacters(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'test',
            'password_confirmation' => 'test',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors([
                'password' => [
                    'The password field must be at least 8 characters.'
                ],
            ]);
    }
}

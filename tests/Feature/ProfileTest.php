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
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_their_own_vehicles(): void
    {
        $john = User::factory()->create();
        $vehicleForJohn = Vehicle::factory()->create([
            'user_id' => $john->id
        ]);

        $adam = User::factory()->create();
        $vehicleForAdam = Vehicle::factory()->create([
            'user_id' => $adam->id
        ]);

        $response = $this->actingAs($john)->getJson('/api/v1/vehicles');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'plateNumber',
                    ]
                ]
            ])
            ->assertJson([
                'data' => [
                    [
                        'plateNumber' => $vehicleForJohn->plate_number,
                    ]
                ]
            ])
            ->assertJsonMissing($vehicleForAdam->toArray());
    }

    public function test_user_can_create_vehicle(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/vehicles', [
            'plateNumber' => 'AAA111',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'id',
                'plateNumber',
            ])
            ->assertJson([
                'plateNumber' => 'AAA111',
            ]);

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'AAA111',
        ]);
    }

    public function test_user_can_update_their_vehicle(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson('/api/v1/vehicles/' . $vehicle->id, [
            'plateNumber' => 'AAA123',
        ]);

        $response->assertAccepted()
            ->assertJsonStructure([
                'id',
                'plateNumber',
            ])
            ->assertJson([
                'plateNumber' => 'AAA123',
            ]);

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'AAA123',
        ]);
    }

    public function test_user_can_delete_their_vehicle(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson('/api/v1/vehicles/' . $vehicle->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('vehicles', [
            'id' => $vehicle->id,
            'deleted_at' => null,
        ])->assertDatabaseCount('vehicles', 1);
    }
}

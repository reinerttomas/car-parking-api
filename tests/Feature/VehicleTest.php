<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirOwnVehicles(): void
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

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) =>
                $json
                    ->has('data', 1)
                    ->has('data.0', fn(AssertableJson $json) =>
                        $json->where('plateNumber', $vehicleForJohn->plate_number)
                            ->etc()
                    )
            )
            ->assertJsonMissing($vehicleForAdam->toArray());
    }

    public function testUserCanCreateVehicle(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/vehicles', [
            'plateNumber' => 'AAA111',
        ]);

        $response->assertStatus(201)
            ->assertJson(fn(AssertableJson $json) =>
                $json->where('plateNumber', 'AAA111')
                    ->etc()
            );

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'AAA111',
        ]);
    }

    public function testUseCanUpdateTheirVehicle(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson('/api/v1/vehicles/' . $vehicle->id, [
            'plateNumber' => 'AAA123',
        ]);

        $response->assertStatus(202)
            ->assertJson(fn(AssertableJson $json) =>
                $json->where('plateNumber', 'AAA123')
                    ->etc()
            );

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'AAA123',
        ]);
    }

    public function testUserCanDeleteTheirVehicle(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson('/api/v1/vehicles/' . $vehicle->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('vehicles', [
            'id' => $vehicle->id,
            'deleted_at' => null,
        ])->assertDatabaseCount('vehicles', 1);
    }
}

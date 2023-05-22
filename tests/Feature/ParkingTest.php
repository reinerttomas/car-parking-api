<?php

namespace Tests\Feature;

use App\Models\Parking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParkingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_start_parking(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $zone = Zone::factory()->create(['price_per_hour' => 100]);

        $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicleId' => $vehicle->id,
            'zoneId' => $zone->id,
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'id',
                'zone' => [
                    'name',
                    'pricePerHour',
                ],
                'vehicle' => [
                    'plateNumber'
                ],
                'startAt',
                'stopAt',
                'totalPrice'
            ])
            ->assertJson([
                'startAt' => now()->toDateTimeString(),
                'stopAt' => null,
                'totalPrice' => 0,
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }

    public function test_user_can_get_ongoing_parking_with_correct_price(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $zone = Zone::factory()->create(['price_per_hour' => 100]);

        $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicleId' => $vehicle->id,
            'zoneId' => $zone->id,
        ]);

        $this->travel(2)->hours();

        $parking = Parking::first();
        $response = $this->actingAs($user)->getJson('/api/v1/parkings/' . $parking->id);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'zone' => [
                    'name',
                    'pricePerHour',
                ],
                'vehicle' => [
                    'plateNumber'
                ],
                'startAt',
                'stopAt',
                'totalPrice'
            ])
            ->assertJson([
                'startAt' => now()->subHours(2)->toDateTimeString(),
                'stopAt' => null,
                'totalPrice' => $zone->price_per_hour * 2,
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }

    public function test_user_can_stop_parking(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $zone = Zone::factory()->create(['price_per_hour' => 100]);

        $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicleId' => $vehicle->id,
            'zoneId' => $zone->id,
        ]);

        $this->travel(2)->hours();

        $parking = Parking::first();
        $response = $this->actingAs($user)->putJson('/api/v1/parkings/' . $parking->id);

        $updatedParking = Parking::find($parking->id);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'zone' => [
                    'name',
                    'pricePerHour',
                ],
                'vehicle' => [
                    'plateNumber'
                ],
                'startAt',
                'stopAt',
                'totalPrice'
            ])
            ->assertJson([
                'startAt' => $updatedParking->start_at->toDateTimeString(),
                'stopAt' => $updatedParking->stop_at->toDateTimeString(),
                'totalPrice' => $updatedParking->total_price,
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }
}

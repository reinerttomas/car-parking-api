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
        $zone = Zone::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()
            ->for($user)
            ->create();

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
                    'plateNumber',
                    'description',
                ],
                'startAt',
                'stopAt',
                'totalPrice',
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
        $zone = Zone::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()
            ->for($user)
            ->create();
        $parking = Parking::factory()
            ->for($user)
            ->for($vehicle)
            ->for($zone)
            ->create();

        $this->travel(2)->hours();

        $response = $this->actingAs($user)->getJson('/api/v1/parkings/' . $parking->id);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'zone' => [
                    'name',
                    'pricePerHour',
                ],
                'vehicle' => [
                    'plateNumber',
                    'description',
                ],
                'startAt',
                'stopAt',
                'totalPrice',
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
        $zone = Zone::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()
            ->for($user)
            ->create();
        $parking = Parking::factory()
            ->for($user)
            ->for($vehicle)
            ->for($zone)
            ->create();

        $this->travel(2)->hours();

        $response = $this->actingAs($user)->putJson('/api/v1/parkings/' . $parking->id);

        /** @var Parking $updatedParking */
        $updatedParking = Parking::find($parking->id);

        $this->assertNotNull($updatedParking->stop_at);
        $this->assertNotNull($updatedParking->total_price);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'zone' => [
                    'name',
                    'pricePerHour',
                ],
                'vehicle' => [
                    'plateNumber',
                    'description',
                ],
                'startAt',
                'stopAt',
                'totalPrice',
            ])
            ->assertJson([
                'startAt' => $updatedParking->start_at->toDateTimeString(),
                'stopAt' => $updatedParking->stop_at->toDateTimeString(),
                'totalPrice' => $updatedParking->total_price,
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }

    public function test_user_can_get_their_active_parkings(): void
    {
        $zone = Zone::factory()->create();

        $john = User::factory()->create();
        $vehicleForJohn = Vehicle::factory()
            ->for($john)
            ->create();
        $parkingForJohn = Parking::factory()
            ->for($john)
            ->for($vehicleForJohn)
            ->for($zone)
            ->create();

        $adam = User::factory()->create();
        $vehicleForAdam = Vehicle::factory()
            ->for($adam)
            ->create();
        $parkingForAdam = Parking::factory()
            ->for($adam)
            ->for($vehicleForAdam)
            ->for($zone)
            ->create();

        $response = $this->actingAs($john)->getJson('/api/v1/parkings');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'zone' => [
                            'name',
                            'pricePerHour',
                        ],
                        'vehicle' => [
                            'plateNumber',
                            'description',
                        ],
                        'startAt',
                        'stopAt',
                        'totalPrice',
                    ],
                ],
            ])
            ->assertJson([
                'data' => [
                    [
                        'zone' => [
                            'name' => $zone->name,
                            'pricePerHour' => $zone->price_per_hour,
                        ],
                        'vehicle' => [
                            'plateNumber' => $vehicleForJohn->plate_number,
                            'description' => $vehicleForJohn->description,
                        ],
                        'startAt' => $parkingForJohn->start_at->toDateTimeString(),
                        'stopAt' => $parkingForJohn->stop_at,
                        'totalPrice' => $parkingForJohn->total_price,
                    ],
                ],
            ])
            ->assertJsonMissing($parkingForAdam->toArray());
    }

    public function test_user_cannot_start_parking_twice_using_same_vehicle(): void
    {
        $zone = Zone::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()
            ->for($user)
            ->create();
        Parking::factory()
            ->for($user)
            ->for($vehicle)
            ->for($zone)
            ->create();

        $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicleId' => $vehicle->id,
            'zoneId' => $zone->id,
        ]);

        $response->assertUnprocessable()
            ->assertJsonStructure(['errors'])
            ->assertJsonValidationErrors([
                'general' => [
                    'Can\'t start parking twice using same vehicle. Please stop currently active parking.',
                ],
            ]);
    }

    public function test_user_can_get_their_parkings_history_with_deleted_vehicles(): void
    {
        $zone = Zone::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()
            ->trashed()
            ->for($user)
            ->create();
        $parking = Parking::factory()->stopped()
            ->for($user)
            ->for($vehicle)
            ->for($zone)
            ->create();

        $this->assertNotNull($parking->stop_at);
        $this->assertNotNull($parking->total_price);

        $response = $this->actingAs($user)->getJson('/api/v1/parkings/history');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'zone' => [
                            'name',
                            'pricePerHour',
                        ],
                        'vehicle' => [
                            'plateNumber',
                            'description',
                        ],
                        'startAt',
                        'stopAt',
                        'totalPrice',
                    ],
                ],
            ])
            ->assertJson([
                'data' => [
                    [
                        'zone' => [
                            'name' => $zone->name,
                            'pricePerHour' => $zone->price_per_hour,
                        ],
                        'vehicle' => [
                            'plateNumber' => $vehicle->plate_number,
                            'description' => $vehicle->description,
                        ],
                        'startAt' => $parking->start_at->toDateTimeString(),
                        'stopAt' => $parking->stop_at,
                        'totalPrice' => $parking->total_price,
                    ],
                ],
            ]);
    }

    public function test_user_can_get_stopped_parking_with_deleted_vehicle(): void
    {
        $zone = Zone::factory()->create();
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()
            ->trashed()
            ->for($user)
            ->create();
        $parking = Parking::factory()->stopped()
            ->for($user)
            ->for($vehicle)
            ->for($zone)
            ->create();

        $this->assertNotNull($parking->stop_at);
        $this->assertNotNull($parking->total_price);

        $response = $this->actingAs($user)->getJson('/api/v1/parkings/' . $parking->id);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'zone' => [
                    'name',
                    'pricePerHour',
                ],
                'vehicle' => [
                    'plateNumber',
                    'description',
                ],
                'startAt',
                'stopAt',
                'totalPrice',
            ])
            ->assertJson([
                'zone' => [
                    'name' => $zone->name,
                    'pricePerHour' => $zone->price_per_hour,
                ],
                'vehicle' => [
                    'plateNumber' => $vehicle->plate_number,
                    'description' => $vehicle->description,
                ],
                'startAt' => $parking->start_at->toDateTimeString(),
                'stopAt' => $parking->stop_at,
                'totalPrice' => $parking->total_price,
            ]);
    }
}

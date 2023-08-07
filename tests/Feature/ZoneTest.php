<?php

namespace Tests\Feature;

use Database\Seeders\ZoneSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_get_all_zones(): void
    {
        $this->seed(ZoneSeeder::class);

        $response = $this->getJson('/api/v1/zones');

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'pricePerHour',
                    ],
                ],
            ])
            ->assertJson([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Green Zone',
                        'pricePerHour' => 100,
                    ],
                    [
                        'id' => 2,
                        'name' => 'Yellow Zone',
                        'pricePerHour' => 200,
                    ],
                    [
                        'id' => 3,
                        'name' => 'Red Zone',
                        'pricePerHour' => 300,
                    ],
                ],
            ]);
    }
}

<?php

namespace Tests\Feature;

use Database\Seeders\ZoneSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    use RefreshDatabase;

    public function testPublicUserCanGetAllZones(): void
    {
        $this->seed(ZoneSeeder::class);

        $response = $this->getJson('/api/v1/zones');

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) =>
                $json
                    ->has('data', 3)
                    ->has('data.0', fn(AssertableJson $json) =>
                        $json
                            ->where('id', 1)
                            ->where('name', 'Green Zone')
                            ->where('pricePerHour', 100)
                    )
                    ->has('data.1', fn(AssertableJson $json) =>
                        $json
                            ->where('id', 2)
                            ->where('name', 'Yellow Zone')
                            ->where('pricePerHour', 200)
                    )
                    ->has('data.2', fn(AssertableJson $json) =>
                        $json
                            ->where('id', 3)
                            ->where('name', 'Red Zone')
                            ->where('pricePerHour', 300)
                    )
            );
    }
}

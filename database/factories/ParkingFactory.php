<?php

namespace Database\Factories;

use App\Models\Parking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Parking>
 */
class ParkingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'start_at' => now(),
        ];
    }

    /**
     * @return Factory<Parking>
     */
    public function stopped(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'stop_at' => now()->addHours(fake()->numberBetween(1, 10)),
            'total_price' => fake()->numberBetween(100, 1000),
        ]);
    }
}

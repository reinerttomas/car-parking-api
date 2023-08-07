<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'plate_number' => Str::upper(fake()->randomLetter().fake()->numberBetween(100, 999)),
            'description' => fake()->sentence(),
        ];
    }
}

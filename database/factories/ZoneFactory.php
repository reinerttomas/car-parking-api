<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Zone>
 */
class ZoneFactory extends Factory
{
    public function definition(): array
    {
        return [
           'name' => 'Zone ' . $this->faker->unique()->numberBetween(1, 100),
           'price_per_hour' => $this->faker->numberBetween(100, 1000),
        ];
    }
}

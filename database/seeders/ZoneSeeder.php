<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        Zone::factory()->create(['name' => 'Green Zone', 'price_per_hour' => 100]);
        Zone::factory()->create(['name' => 'Yellow Zone', 'price_per_hour' => 200]);
        Zone::factory()->create(['name' => 'Red Zone', 'price_per_hour' => 300]);
    }
}

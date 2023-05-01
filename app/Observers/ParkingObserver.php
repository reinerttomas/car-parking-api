<?php

namespace App\Observers;

use App\Models\Parking;

class ParkingObserver
{
    public function creating(Parking $parking): void
    {
        if (auth()->check()) {
            $parking->user_id = (int) auth()->id();
        }

        $parking->start_at = now();
    }
}

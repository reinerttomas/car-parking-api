<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Parking;

use App\Http\Bag\Api\Bag;

class StartParkingBag extends Bag
{
    protected function transform(): void
    {
        $this->vehicle();
        $this->zone();
    }

    private function vehicle(): void
    {
        $this->attributes['vehicle_id'] = $this->attributes['vehicleId'];
        unset($this->attributes['vehicleId']);
    }

    private function zone(): void
    {
        $this->attributes['zone_id'] = $this->attributes['zoneId'];
        unset($this->attributes['zoneId']);
    }
}

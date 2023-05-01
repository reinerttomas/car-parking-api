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
        $this->data['vehicle_id'] = $this->data['vehicleId'];
        unset($this->data['vehicleId']);
    }

    private function zone(): void
    {
        $this->data['zone_id'] = $this->data['zoneId'];
        unset($this->data['zoneId']);
    }
}

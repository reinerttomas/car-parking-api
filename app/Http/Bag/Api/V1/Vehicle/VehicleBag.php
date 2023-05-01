<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Vehicle;

use App\Http\Bag\Api\Bag;

class VehicleBag extends Bag
{
    protected function transform(): void
    {
        $this->attributes['plate_number'] = $this->attributes['plateNumber'];
        unset($this->attributes['plateNumber']);
    }
}

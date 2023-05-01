<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Vehicle;

use App\Http\Bag\Api\Bag;

class VehicleBag extends Bag
{
    protected function transform(): void
    {
        $this->data['plate_number'] = $this->data['plateNumber'];
        unset($this->data['plateNumber']);
    }
}

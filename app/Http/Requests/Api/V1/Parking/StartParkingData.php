<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Parking;

use App\Http\Requests\FormData;

readonly class StartParkingData extends FormData
{
    public function __construct(
        public string $vehicleId,
        public string $zoneId,
    ) {
    }

    public function all(): array
    {
        return [
            'vehicle_id' => $this->vehicleId,
            'zone_id' => $this->zoneId,
        ];
    }
}

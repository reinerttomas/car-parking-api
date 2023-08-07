<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Vehicle;

use App\Http\Requests\FormData;

readonly class StoreVehicleData extends FormData
{
    public function __construct(
        public string $plateNumber,
        public string $description,
    ) {
    }

    /**
     * @return array{plate_number: string, description: string}
     */
    public function all(): array
    {
        return [
            'plate_number' => $this->plateNumber,
            'description' => $this->description,
        ];
    }
}

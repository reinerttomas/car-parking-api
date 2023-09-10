<?php
declare(strict_types=1);

namespace App\Http\Data\Api\V1\Vehicle;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class StoreVehicleData extends Data
{
    public function __construct(
        public readonly string $plateNumber,
        public readonly string $description,
    ) {
    }
}

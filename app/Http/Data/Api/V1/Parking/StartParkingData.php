<?php
declare(strict_types=1);

namespace App\Http\Data\Api\V1\Parking;

use Illuminate\Database\Query\Builder;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class StartParkingData extends Data
{
    public function __construct(
        public int $vehicleId,
        public int $zoneId,
    ) {
    }

    public static function rules(): array
    {
        return [
            'vehicleId' => [
                new Required(),
                new IntegerType(),
                new Exists(
                    table: 'vehicles',
                    column: 'id',
                    withoutTrashed: true,
                    where: fn (Builder $query): Builder => $query->where('user_id', user()->id)
                ),
            ],
            'zoneId' => [
                new Required(),
                new IntegerType(),
                new Exists(
                    table: 'zones',
                    column: 'id',
                ),
            ],
        ];
    }
}

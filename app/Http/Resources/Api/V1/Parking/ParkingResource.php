<?php

namespace App\Http\Resources\Api\V1\Parking;

use App\Models\Vehicle;
use App\Models\Zone;
use App\Services\ParkingPriceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property Zone $zone
 * @property Vehicle $vehicle
 * @property Carbon $start_at
 * @property Carbon|null $stop_at
 * @property float|null $total_price
 */
class ParkingResource extends JsonResource
{
    public static $wrap = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalPrice = $this->total_price ?? ParkingPriceService::calculatePrice(
            $this->zone->price_per_hour,
            $this->start_at,
            $this->stop_at
        );

        return [
            'id' => $this->id,
            'zone' => [
                'name' => $this->zone->name,
                'pricePerHour' => $this->zone->price_per_hour,
            ],
            'vehicle' => [
                'plateNumber' => $this->vehicle->plate_number,
                'description' => $this->vehicle->description,
            ],
            'startAt' => $this->start_at->toDateTimeString(),
            'stopAt' => $this->stop_at?->toDateTimeString(),
            'totalPrice' => $totalPrice,
        ];
    }
}

<?php

namespace App\Http\Resources\Api\V1\Parking;

use App\Models\Vehicle;
use App\Models\Zone;
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
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'zone' => [
                'name' => $this->zone->name,
                'pricePerHour' => $this->zone->price_per_hour,
            ],
            'vehicle' => [
                'plateNumber' => $this->vehicle->plate_number
            ],
            'startAt' => $this->start_at->toDateTimeString(),
            'stopAt' => $this->stop_at?->toDateTimeString(),
            'totalPrice' => $this->total_price,
        ];
    }
}

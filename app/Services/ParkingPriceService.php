<?php
declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class ParkingPriceService
{
    public static function calculatePrice(int $pricePerHour, Carbon $startAt, ?Carbon $stopAt): float
    {
        if ($stopAt === null) {
            $stopAt = now();
        }

        $totalTimeByMinutes = $stopAt->diffInMinutes($startAt);
        $priceByMinutes = $pricePerHour / 60;

        return ceil($totalTimeByMinutes * $priceByMinutes);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Parking\StartParkingRequest;
use App\Http\Resources\Api\V1\Parking\ParkingResource;
use App\Models\Parking;
use App\Services\ParkingPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Parking')]
class ParkingController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $parkings = Parking::active()
            ->with(['vehicle', 'zone'])
            ->latest('start_at')
            ->get();

        return ParkingResource::collection($parkings);
    }

    public function history(): AnonymousResourceCollection
    {
        $parkings = Parking::stopped()
            ->with(['vehicle' => fn ($q) => $q->withTrashed()])
            ->with('zone')
            ->latest('stop_at')
            ->get();

        return ParkingResource::collection($parkings);
    }

    public function show(Parking $parking): JsonResource
    {
        $parking
            ->load(['vehicle' => fn ($q) => $q->withTrashed()])
            ->load('zone');

        return ParkingResource::make($parking);
    }

    public function start(StartParkingRequest $request): JsonResource|JsonResponse
    {
        if (Parking::active()->where('vehicle_id', $request->data()->vehicleId)->exists()) {
            return response()->json([
                'errors' => [
                    'general' => [
                        'Can\'t start parking twice using same vehicle. Please stop currently active parking.',
                    ],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($request->data()->all());

        return ParkingResource::make($parking->load('vehicle', 'zone'));
    }

    public function stop(Parking $parking): JsonResource
    {
        $parking->load('vehicle', 'zone');

        $parking->update([
            'stop_at' => now(),
            'total_price' => ParkingPriceService::calculatePrice(
                $parking->zone->price_per_hour,
                $parking->start_at,
                $parking->stop_at,
            ),
        ]);

        return ParkingResource::make($parking);
    }
}

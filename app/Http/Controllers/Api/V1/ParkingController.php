<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Parking\StartParkingRequest;
use App\Http\Resources\Api\V1\Parking\ParkingResource;
use App\Models\Parking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ParkingController extends Controller
{
    public function show(Parking $parking): JsonResource
    {
        return ParkingResource::make($parking);
    }

    public function start(StartParkingRequest $request): JsonResource|JsonResponse
    {
        $attributes = $request->getAttributes();

        if (Parking::active()->where('vehicle_id', $attributes['vehicle_id'])->exists()) {
            return response()->json([
                'errors' => [
                    'general' => [
                        'Can\'t start parking twice using same vehicle. Please stop currently active parking.',
                    ]
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($attributes);
        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    public function stop(Parking $parking): JsonResource
    {
        $parking->update([
            'stop_at' => now(),
        ]);

        return ParkingResource::make($parking);
    }
}

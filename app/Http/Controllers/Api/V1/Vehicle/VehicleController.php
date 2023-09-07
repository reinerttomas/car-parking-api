<?php

namespace App\Http\Controllers\Api\V1\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Data\Api\V1\Vehicle\StoreVehicleData;
use App\Http\Resources\Api\V1\Vehicle\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Vehicles')]
class VehicleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return VehicleResource::collection(Vehicle::all());
    }

    public function store(StoreVehicleData $data): JsonResponse
    {
        $vehicle = Vehicle::create($data->toArray());

        return response()->json(VehicleResource::make($vehicle), Response::HTTP_CREATED);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json(VehicleResource::make($vehicle));
    }

    public function update(StoreVehicleData $data, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update($data->toArray());

        return response()->json(VehicleResource::make($vehicle), Response::HTTP_ACCEPTED);
    }

    public function destroy(Vehicle $vehicle): Response
    {
        $vehicle->delete();

        return response()->noContent();
    }
}

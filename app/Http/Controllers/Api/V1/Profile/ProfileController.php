<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Data\Api\V1\Profile\ProfileUpdateData;
use App\Http\Resources\Api\V1\Profile\ProfileResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Auth')]
class ProfileController extends Controller
{
    /**
     * @throws Exception
     */
    public function show(): JsonResponse
    {
        return response()->json(ProfileResource::make(user()), Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    public function update(ProfileUpdateData $data): JsonResponse
    {
        user()->update($data->all());

        return response()->json(ProfileResource::make(user()), Response::HTTP_ACCEPTED);
    }
}

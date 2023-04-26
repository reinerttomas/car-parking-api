<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * @throws \Exception
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            throw new \Exception('User not found');
        }

        return response()->json($user->only('name', 'email'));
    }

    /**
     * @throws \Exception
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();

        if ($user === null) {
            throw new \Exception('User not found');
        }

        $user->update($request->toBag()->attributes());

        return response()->json($user->only('name', 'email'), Response::HTTP_ACCEPTED);
    }
}

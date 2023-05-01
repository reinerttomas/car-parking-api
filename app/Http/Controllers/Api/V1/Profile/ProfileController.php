<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Profile\ProfileUpdateRequest;
use App\Support\Traits\HasAuthenticated;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use HasAuthenticated;

    /**
     * @throws Exception
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            throw new Exception('User not found');
        }

        return response()->json($user->only('name', 'email'));
    }

    /**
     * @throws Exception
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = $this->getUser();

        $user->update($request->getData());

        return response()->json($user->only('name', 'email'), Response::HTTP_ACCEPTED);
    }
}

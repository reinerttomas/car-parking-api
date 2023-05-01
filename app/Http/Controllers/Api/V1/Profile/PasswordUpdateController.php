<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Profile\PasswordUpdateRequest;
use App\Support\Traits\HasAuthenticated;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PasswordUpdateController extends Controller
{
    use HasAuthenticated;

    /**
     * @throws Exception
     */
    public function __invoke(PasswordUpdateRequest $request): JsonResponse
    {
        $attributes = $request->getAttributes();

        $this->getUser()->update([
            'password' => Hash::make($attributes['password'])
        ]);

        return response()->json([
            'message' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}

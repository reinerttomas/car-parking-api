<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\PasswordUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordUpdateController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(PasswordUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();

        if ($user === null) {
            throw new \Exception('User not found');
        }

        $user->update($request->toBag()->attributes());

        return response()->json([
            'message' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}

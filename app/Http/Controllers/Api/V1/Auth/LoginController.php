<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $attributes = $request->getAttributes();

        $user = User::where('email', $attributes['email'])->first();

        if (!$user || Hash::check($attributes['password'], $user->password) === false) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $device = Str::substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken(name: $device)->plainTextToken,
        ], Response::HTTP_CREATED);
    }
}

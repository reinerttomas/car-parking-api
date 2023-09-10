<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Data\Api\V1\Auth\RegisterData;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\Auth\AccessTokenResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Auth')]
class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $registerData = RegisterData::from($request);

        $user = User::create([
            'name' => $registerData->name,
            'email' => $registerData->email,
            'password' => Hash::make($registerData->password),
        ]);

        event(new Registered($user));

        $device = Str::substr($request->userAgent() ?? '', 0, 255);

        return response()->json(
            new AccessTokenResource($user->createToken(name: $device)->plainTextToken),
            Response::HTTP_CREATED
        );
    }
}

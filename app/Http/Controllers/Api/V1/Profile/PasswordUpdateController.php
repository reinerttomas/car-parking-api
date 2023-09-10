<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Data\Api\V1\Profile\PasswordUpdateData;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Auth')]
class PasswordUpdateController extends Controller
{
    /**
     * @throws Exception
     */
    public function __invoke(PasswordUpdateData $data): JsonResponse
    {
        user()->update([
            'password' => Hash::make($data->password),
        ]);

        return response()->json([
            'message' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}

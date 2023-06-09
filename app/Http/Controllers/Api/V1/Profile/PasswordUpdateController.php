<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Profile\PasswordUpdateRequest;
use App\Support\Traits\HasAuthenticated;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Auth')]
class PasswordUpdateController extends Controller
{
    use HasAuthenticated;

    /**
     * @throws Exception
     */
    public function __invoke(PasswordUpdateRequest $request): JsonResponse
    {
        $data = $request->getData();

        $this->getUser()->update([
            'password' => Hash::make($data['password'])
        ]);

        return response()->json([
            'message' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}

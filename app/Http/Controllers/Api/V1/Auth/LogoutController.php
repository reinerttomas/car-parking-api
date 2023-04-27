<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $user = auth()->user();

        if ($user === null) {
            throw new \Exception('User not found');
        }

        $user->currentAccessToken()->delete();

        return response()->noContent();
    }
}

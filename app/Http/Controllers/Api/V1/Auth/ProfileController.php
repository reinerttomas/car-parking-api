<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        if ($request->user() === null) {
            throw new \Exception('User not found');
        }

        return response()->json($request->user()->only('name', 'email'));
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PingController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return response()->noContent();
    }
}

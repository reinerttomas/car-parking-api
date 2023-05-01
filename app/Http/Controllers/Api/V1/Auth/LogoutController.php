<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Support\Traits\HasAuthenticated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    use HasAuthenticated;

    /**
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $this->getUser()->currentAccessToken()->delete();

        return response()->noContent();
    }
}

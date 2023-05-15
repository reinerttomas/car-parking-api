<?php

use App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [V1\Profile\ProfileController::class, 'show']);
    Route::put('profile', [V1\Profile\ProfileController::class, 'update']);
    Route::put('password', V1\Profile\PasswordUpdateController::class);
    Route::post('auth/logout', V1\Auth\LogoutController::class);

    Route::apiResource('vehicles', V1\Vehicle\VehicleController::class);
    Route::post('parkings/start', [V1\ParkingController::class, 'start']);
    Route::get('parkings/{parking}', [V1\ParkingController::class, 'show']);
    Route::put('parkings/{parking}', [V1\ParkingController::class, 'stop']);
});

Route::post('auth/register', V1\Auth\RegisterController::class);
Route::post('auth/login', V1\Auth\LoginController::class);
Route::get('zones', [V1\Zone\ZoneController::class, 'index']);

<?php

namespace App\Http\Requests\Api\V1\Parking;

use Illuminate\Foundation\Http\FormRequest;

final class StartParkingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}

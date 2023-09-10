<?php

namespace App\Http\Requests\Api\V1\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

final class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}

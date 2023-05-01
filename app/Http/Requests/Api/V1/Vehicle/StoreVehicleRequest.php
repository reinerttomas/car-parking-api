<?php

namespace App\Http\Requests\Api\V1\Vehicle;

use App\Http\Bag\Api\V1\Vehicle\VehicleBag;
use App\Http\Requests\Api\HasAttributes;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    use HasAttributes;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plateNumber' => 'required',
        ];
    }

    public function getAttributes(): array
    {
        return VehicleBag::create($this->validated())->attributes();
    }
}

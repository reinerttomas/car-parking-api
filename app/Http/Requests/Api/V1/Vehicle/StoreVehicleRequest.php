<?php

namespace App\Http\Requests\Api\V1\Vehicle;

use App\Http\Bag\Api\V1\Vehicle\VehicleBag;
use App\Http\Requests\Api\HasBag;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    use HasBag;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plateNumber' => 'required',
            'description' => 'required',
        ];
    }

    public function getData(): array
    {
        return VehicleBag::create($this->validated())->toArray();
    }
}

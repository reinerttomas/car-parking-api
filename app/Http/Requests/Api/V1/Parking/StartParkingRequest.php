<?php

namespace App\Http\Requests\Api\V1\Parking;

use App\Http\Bag\Api\V1\Parking\StartParkingBag;
use App\Http\Requests\Api\HasAttributes;
use Illuminate\Foundation\Http\FormRequest;

class StartParkingRequest extends FormRequest
{
    use HasAttributes;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicleId' => [
                'required',
                'integer',
                'exists:vehicles,id,deleted_at,NULL,user_id,' . auth()->id(),
            ],
            'zoneId' => ['required', 'integer', 'exists:zones,id'],
        ];
    }

    public function getAttributes(): array
    {
        return StartParkingBag::create($this->validated())->attributes();
    }
}

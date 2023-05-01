<?php

namespace App\Http\Requests\Api\V1\Parking;

use App\Http\Bag\Api\V1\Parking\StartParkingBag;
use App\Http\Requests\Api\HasBag;
use Illuminate\Foundation\Http\FormRequest;

class StartParkingRequest extends FormRequest
{
    use HasBag;

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

    public function getData(): array
    {
        return StartParkingBag::create($this->validated())->toArray();
    }
}

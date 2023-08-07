<?php

namespace App\Http\Requests\Api\V1\Parking;

use App\Http\Requests\DataPassedValidation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method validated() array{vehicleId: int, zoneId: int}
 * @implements DataPassedValidation<StartParkingData>
 */
final class StartParkingRequest extends FormRequest implements DataPassedValidation
{
    private StartParkingData $data;

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

    protected function passedValidation(): void
    {
        $this->data = new StartParkingData(...$this->validated());
    }

    public function data(): StartParkingData
    {
        return $this->data;
    }
}

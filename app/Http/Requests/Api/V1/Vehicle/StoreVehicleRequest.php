<?php

namespace App\Http\Requests\Api\V1\Vehicle;

use App\Http\Requests\DataPassedValidation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method validated() array{plateNumber: string, description: string}
 *
 * @implements DataPassedValidation<StoreVehicleData>
 */
final class StoreVehicleRequest extends FormRequest implements DataPassedValidation
{
    private StoreVehicleData $data;

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

    protected function passedValidation(): void
    {
        $this->data = new StoreVehicleData(...$this->validated());
    }

    public function data(): StoreVehicleData
    {
        return $this->data;
    }
}

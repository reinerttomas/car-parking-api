<?php

namespace App\Http\Requests\Api\V1\Profile;

use App\Http\Requests\DataPassedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method validated() array{name: string, email: string}
 * @implements DataPassedValidation<ProfileUpdateData>
 */
final class ProfileUpdateRequest extends FormRequest implements DataPassedValidation
{
    private ProfileUpdateData $data;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->user())],
        ];
    }

    protected function passedValidation(): void
    {
        $this->data = new ProfileUpdateData(...$this->validated());
    }

    public function data(): ProfileUpdateData
    {
        return $this->data;
    }
}

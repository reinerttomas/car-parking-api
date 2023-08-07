<?php

namespace App\Http\Requests\Api\V1\Profile;

use App\Http\Requests\DataPassedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @implements DataPassedValidation<PasswordUpdateData>
 */
final class PasswordUpdateRequest extends FormRequest implements DataPassedValidation
{
    private PasswordUpdateData $data;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    protected function passedValidation(): void
    {
        /** @var string $password */
        $password = $this->validated('password');

        $this->data = new PasswordUpdateData($password);
    }

    public function data(): PasswordUpdateData
    {
        return $this->data;
    }
}

<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\DataPassedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @method validated() array{name: string, email: string, password: string}
 * @implements DataPassedValidation<RegisterData>
 */
final class RegisterRequest extends FormRequest implements DataPassedValidation
{
    private RegisterData $data;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    protected function passedValidation(): void
    {
        $this->data = new RegisterData(...$this->validated());
    }

    public function data(): RegisterData
    {
        return $this->data;
    }
}

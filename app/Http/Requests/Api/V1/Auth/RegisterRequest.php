<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Bag\Api\Baggable;
use App\Http\Bag\Api\V1\Auth\RegisterBag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest implements Baggable
{
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

    public function toBag(): RegisterBag
    {
        /** @var array{name: string, email: string, password: string} $data */
        $data = $this->validated();

        return new RegisterBag($data);
    }
}

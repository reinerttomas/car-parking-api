<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Bag\Api\Baggable;
use App\Http\Bag\Api\V1\Auth\LoginBag;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest implements Baggable
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function toBag(): LoginBag
    {
        /** @var array{email: string, password: string} $attributes */
        $attributes = $this->validated();

        return new LoginBag($attributes);
    }
}

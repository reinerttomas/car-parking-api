<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Bag\Api\Bag;
use App\Http\Bag\Api\Baggable;
use App\Http\Bag\Api\V1\Auth\PasswordUpdateBag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest implements Baggable
{
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

    public function toBag(): Bag
    {
        /** @var array{password: string} $attributes*/
        $attributes = $this->validated();

        return new PasswordUpdateBag($attributes);
    }
}

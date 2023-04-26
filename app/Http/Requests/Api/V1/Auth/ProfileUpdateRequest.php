<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Bag\Api\Baggable;
use App\Http\Bag\Api\V1\Auth\ProfileUpdateBag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest implements Baggable
{
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

    public function toBag(): ProfileUpdateBag
    {
        /** @var array{name: string, email: string} $attributes */
        $attributes = $this->validated();

        return new ProfileUpdateBag($attributes);
    }
}

<?php

namespace App\Http\Requests\Api\V1\Profile;

use App\Http\Requests\Api\HasBag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    use HasBag;

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
}

<?php

namespace App\Http\Requests\Api\V1\Profile;

use App\Http\Requests\Api\HasBag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    use HasBag;

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
}

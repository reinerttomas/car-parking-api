<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\HasBag;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use HasBag;

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
}

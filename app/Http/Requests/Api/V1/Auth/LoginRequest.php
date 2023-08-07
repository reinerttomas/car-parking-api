<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\DataPassedValidation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method validated() array{email: string, password: string}
 *
 * @implements DataPassedValidation<LoginData>
 */
final class LoginRequest extends FormRequest implements DataPassedValidation
{
    private LoginData $data;

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

    public function passedValidation(): void
    {
        $this->data = new LoginData(...$this->validated());
    }

    public function data(): LoginData
    {
        return $this->data;
    }
}

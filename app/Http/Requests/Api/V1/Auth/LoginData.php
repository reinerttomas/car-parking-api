<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\FormData;

readonly class LoginData extends FormData
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }

    /**
     * @return array{email: string, password: string}
     */
    public function all(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\FormData;

readonly class RegisterData extends FormData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }

    /**
     * @return array{name: string, email: string, password: string}
     */
    public function all(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

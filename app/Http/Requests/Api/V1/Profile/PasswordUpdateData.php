<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Profile;

use App\Http\Requests\FormData;

readonly class PasswordUpdateData extends FormData
{
    public function __construct(
        public string $password,
    ) {
    }

    /**
     * @return array{password: string}
     */
    public function all(): array
    {
        return [
            'password' => $this->password,
        ];
    }
}

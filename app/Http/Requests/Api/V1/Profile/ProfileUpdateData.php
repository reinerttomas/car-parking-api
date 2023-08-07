<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Profile;

use App\Http\Requests\FormData;

readonly class ProfileUpdateData extends FormData
{
    public function __construct(
        public string $name,
        public string $email,
    ) {
    }

    /**
     * @return array{name: string, email: string}
     */
    public function all(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}

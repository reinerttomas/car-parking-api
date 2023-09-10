<?php

namespace App\Http\Data\Api\V1\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class LoginData extends Data
{
    public function __construct(
        #[Email]
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}

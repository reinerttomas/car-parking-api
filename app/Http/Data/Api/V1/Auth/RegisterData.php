<?php
declare(strict_types=1);

namespace App\Http\Data\Api\V1\Auth;

use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public function __construct(
        #[Max(255)]
        public readonly string $name,
        #[Email]
        #[Unique('users')]
        public readonly string $email,
        #[Password(min: 10, letters: true, mixedCase: true, numbers: true, symbols: true)]
        #[Confirmed]
        public readonly string $password,
    ) {
    }
}

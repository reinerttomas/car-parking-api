<?php
declare(strict_types=1);

namespace App\Http\Data\Api\V1\Profile;

use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

class PasswordUpdateData extends Data
{
    public function __construct(
        #[CurrentPassword]
        public readonly string $currentPassword,
        #[Password(min: 10, letters: true, mixedCase: true, numbers: true, symbols: true)]
        #[Confirmed]
        public readonly string $password,
    ) {
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Data\Api\V1\Profile;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class ProfileUpdateData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(user())],
        ];
    }
}

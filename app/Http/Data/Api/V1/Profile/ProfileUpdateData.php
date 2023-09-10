<?php
declare(strict_types=1);

namespace App\Http\Data\Api\V1\Profile;

use Illuminate\Database\Query\Builder;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
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
            'name' => [
                new Required(),
                new StringType(),
                new Max(255),
            ],
            'email' => [
                new Required(),
                new Email(),
                new Unique(
                    table: 'users',
                    where: fn (Builder $query): Builder => $query->whereNot('id', user()->id)
                ),
            ],
        ];
    }
}

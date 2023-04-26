<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Auth;

use App\Http\Bag\Api\Bag;

class ProfileUpdateBag implements Bag
{
    /**
     * @param array{name: string, email: string} $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    public function attributes(): array
    {
        return $this->attributes;
    }
}

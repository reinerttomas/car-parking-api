<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Auth;

use App\Http\Bag\Api\Bag;

class LoginBag implements Bag
{
    /**
     * @param array{email: string, password: string} $attributes
     */
    public function __construct(private readonly array $attributes)
    {
    }

    public function attributes(): array
    {
        return $this->attributes;
    }
}

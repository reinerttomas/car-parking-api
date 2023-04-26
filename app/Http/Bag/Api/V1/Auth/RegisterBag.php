<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Auth;

use App\Http\Bag\Api\Bag;
use Illuminate\Support\Facades\Hash;

class RegisterBag implements Bag
{
    /**
     * @param array{name: string, email: string, password: string} $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    public function attributes(): array
    {
        $this->hashPassword();

        return $this->attributes;
    }

    private function hashPassword(): void
    {
        $this->attributes['password'] = Hash::make($this->attributes['password']);
    }
}

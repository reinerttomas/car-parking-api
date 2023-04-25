<?php
declare(strict_types=1);

namespace App\Http\Bag\Api\V1\Auth;

use App\Http\Bag\Api\Bag;

class RegisterBag implements Bag
{
    private string $name;
    private string $email;
    private string $password;

    /**
     * @param array{name: string, email: string, password: string} $attributes
     */
    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'];
        $this->email = $attributes['email'];
        $this->password = $attributes['password'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

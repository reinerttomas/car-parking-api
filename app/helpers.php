<?php
declare(strict_types=1);

use App\Models\User;

if (! function_exists('user')) {
    function user(string $guard = 'web'): User
    {
        $user = auth($guard)->user();

        if (! $user instanceof User) {
            throw new RuntimeException('No user authenticated.');
        }

        return $user;
    }
}

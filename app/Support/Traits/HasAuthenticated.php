<?php
declare(strict_types=1);

namespace App\Support\Traits;

use App\Models\User;
use Exception;

trait HasAuthenticated
{
    /**
     * @throws Exception
     */
    protected function getUser(): User
    {
        $user = auth()->user();

        if ($user === null) {
            throw new Exception('User not found');
        }

        return $user;
    }
}

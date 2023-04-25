<?php
declare(strict_types=1);

namespace App\Http\Bag\Api;

interface Bag
{
    public function __construct(array $attributes);
}

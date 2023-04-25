<?php
declare(strict_types=1);

namespace App\Http\Bag\Api;

interface Baggable
{
    public function toBag(): Bag;
}

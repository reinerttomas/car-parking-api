<?php
declare(strict_types=1);

namespace App\Http\Requests;

abstract readonly class FormData
{
    abstract public function all(): array;
}

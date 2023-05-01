<?php
declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Bag\Api\Bag;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin FormRequest
 */
trait HasAttributes
{
    public function getAttributes(): array
    {
        return Bag::create($this->validated())->attributes();
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Bag\Api;

class Bag
{
    final public function __construct(protected array $attributes)
    {
    }

    final public static function create(array $attributes): static
    {
        return new static($attributes);
    }

    public function attributes(): array
    {
        $this->transform();

        return $this->attributes;
    }

    protected function transform(): void
    {
    }
}

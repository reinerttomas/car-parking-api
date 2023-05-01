<?php
declare(strict_types=1);

namespace App\Http\Bag\Api;

class Bag
{
    final public function __construct(protected array $data)
    {
    }

    final public static function create(array $data): static
    {
        return new static($data);
    }

    final public function toArray(): array
    {
        $this->transform();

        return $this->data;
    }

    protected function transform(): void
    {
    }
}

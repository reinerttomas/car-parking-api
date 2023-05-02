<?php
declare(strict_types=1);

namespace App\Http\Resources\Api\V1\Auth;

use Illuminate\Contracts\Support\Arrayable;

class AccessTokenResource implements Arrayable
{
    public function __construct(private readonly string $accessToken)
    {
    }

    /**
     * @return array{accessToken: string}
     */
    public function toArray(): array
    {
        return [
            'accessToken' => $this->accessToken,
        ];
    }
}

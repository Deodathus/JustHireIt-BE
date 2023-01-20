<?php

declare(strict_types=1);

namespace App\Shared\Application\Api\DTO;

use App\Shared\Domain\ValueObject\Id;

final class ApiToken
{
    public function __construct(
        private readonly string $token,
        private readonly Id $id,
        private readonly string $salt
    ) {}

    public function value(): string
    {
        return hash_hmac(
            'sha256',
            $this->token . $this->id->toString(),
            $this->salt
        );
    }
}

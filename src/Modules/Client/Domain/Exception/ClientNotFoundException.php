<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Exception;

final class ClientNotFoundException extends \Exception
{
    public static function withToken(string $token): self
    {
        return new self(
            sprintf('Client with token "%s" does not exist!', $token)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Application\Api\Service;

use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Domain\ValueObject\Id;
use Ramsey\Uuid\Uuid;

final class ApiTokenGenerator implements ApiTokenGeneratorInterface
{
    public function generate(Id $id, string $salt): ApiToken
    {
        return new ApiToken(
            Uuid::uuid4()->toString(),
            $id,
            $salt
        );
    }
}

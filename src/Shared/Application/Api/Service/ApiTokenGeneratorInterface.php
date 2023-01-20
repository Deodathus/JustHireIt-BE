<?php

declare(strict_types=1);

namespace App\Shared\Application\Api\Service;

use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Domain\ValueObject\Id;

interface ApiTokenGeneratorInterface
{
    public function generate(Id $id, string $salt): ApiToken;
}

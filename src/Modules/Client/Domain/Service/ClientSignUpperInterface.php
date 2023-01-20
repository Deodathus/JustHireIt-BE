<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Application\Password\DTO\HashedPassword;

interface ClientSignUpperInterface
{
    public function signUp(
        ClientId $id,
        string $login,
        HashedPassword $password,
        ApiToken $apiToken,
        string $email,
        string $companyName
    ): void;
}

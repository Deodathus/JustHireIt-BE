<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Service;

use App\Modules\User\Domain\ValueObject\UserId;
use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Application\Password\DTO\HashedPassword;

interface UserSignUpperInterface
{
    public function signUp(
        UserId $id,
        string $login,
        HashedPassword $password,
        ApiToken $apiToken,
        string $email
    ): void;
}

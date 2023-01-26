<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Service;

use App\Modules\Authentication\Application\DTO\HashedPassword;
use App\Modules\Authentication\Domain\ValueObject\UserId;
use App\Shared\Application\Api\DTO\ApiToken;

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

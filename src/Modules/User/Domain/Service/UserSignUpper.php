<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Service;

use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Domain\ValueObject\UserId;
use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Application\Password\DTO\HashedPassword;
use App\Shared\Domain\ValueObject\Password;

final class UserSignUpper implements UserSignUpperInterface
{
    public function __construct(
        private readonly UserPersisterInterface $persister
    ) {}

    public function signUp(UserId $id, string $login, HashedPassword $password, ApiToken $apiToken, string $email): void
    {
        $this->persister->persist(
            new User(
                $id,
                $email,
                $login,
                new Password($password->password, $password->salt),
                $apiToken->value()
            )
        );
    }
}

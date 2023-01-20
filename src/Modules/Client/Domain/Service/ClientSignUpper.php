<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Entity\Client;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Application\Password\DTO\HashedPassword;
use App\Shared\Domain\ValueObject\Password;

final class ClientSignUpper implements ClientSignUpperInterface
{
    public function __construct(
        private readonly ClientPersisterInterface $persister
    ) {}

    public function signUp(
        ClientId $id,
        string $login,
        HashedPassword $password,
        ApiToken $apiToken,
        string $email
    ): void {
        $this->persister->persist(
            new Client(
                $id,
                $email,
                $login,
                new Password($password->password, $password->salt),
                $apiToken->value()
            )
        );
    }
}

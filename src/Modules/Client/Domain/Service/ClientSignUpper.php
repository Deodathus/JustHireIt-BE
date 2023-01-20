<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Entity\Client;
use App\Modules\Client\Domain\Entity\Group;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Modules\Client\Domain\ValueObject\GroupId;
use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Application\Password\DTO\HashedPassword;
use App\Shared\Domain\ValueObject\Password;

final class ClientSignUpper implements ClientSignUpperInterface
{
    public function __construct(
        private readonly ClientPersisterInterface $persister,
        private readonly ClientGroupPersisterInterface $clientGroupPersister
    ) {}

    public function signUp(
        ClientId $id,
        string $login,
        HashedPassword $password,
        ApiToken $apiToken,
        string $email,
        string $companyName
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

        $this->clientGroupPersister->store(
            new Group(
                GroupId::generate(),
                $companyName,
                $id,
                Group::DEFAULT_PERMISSIONS
            )
        );
    }
}

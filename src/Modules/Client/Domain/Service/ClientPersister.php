<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Entity\Client;
use App\Modules\Client\Domain\Exception\LoginWasTakenException;
use App\Modules\Client\Domain\Repository\ClientRepository;

final class ClientPersister implements ClientPersisterInterface
{
    public function __construct(
        private readonly ClientRepository $repository
    ) {}

    public function persist(Client $client): void
    {
        if ($this->repository->existByLogin($client->getLogin())) {
            throw LoginWasTakenException::withLogin($client->getLogin());
        }

        $this->repository->store($client);
    }
}

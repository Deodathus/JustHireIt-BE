<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Repository;

use App\Modules\Client\Domain\Entity\Client;
use App\Modules\Client\Domain\Repository\ClientRepository as ClientRepositoryInterface;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Shared\Domain\ValueObject\Password;
use App\SharedInfrastructure\Exception\NotFoundException;
use Doctrine\DBAL\Connection;

final class ClientRepository implements ClientRepositoryInterface
{
    private const DB_TABLE_NAME = 'clients';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function fetchByToken(string $apiToken): Client
    {
        $rawClient = $this->connection
            ->createQueryBuilder()
            ->select([
                'id',
                'email',
                'login',
                'password',
                'salt',
                'api_token'
            ])
            ->from(self::DB_TABLE_NAME)
            ->where('api_token = :apiToken')
            ->setParameter('apiToken', $apiToken)
            ->fetchAssociative();

        if (!$rawClient) {
            throw NotFoundException::create();
        }

        return new Client(
            ClientId::fromString($rawClient['id']),
            $rawClient['email'],
            $rawClient['login'],
            new Password(
                $rawClient['password'],
                $rawClient['salt']
            ),
            $rawClient['salt']
        );
    }

    public function store(Client $client): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'email' => ':email',
                'login' => ':login',
                'password' => ':password',
                'salt' => ':salt',
                'api_token' => ':apiToken',
            ])
            ->setParameters([
                'id' => $client->getId()->toString(),
                'email' => $client->getEmail(),
                'login' => $client->getLogin(),
                'password' => $client->getPassword()->password,
                'salt' => $client->getSalt(),
                'apiToken' => $client->getApiToken(),
            ])
            ->executeStatement();
    }
}

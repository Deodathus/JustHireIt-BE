<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Repository;

use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Domain\Repository\UserRepository as UserRepositoryInterface;
use App\Modules\User\Domain\ValueObject\UserId;
use App\Shared\Domain\ValueObject\Password;
use App\SharedInfrastructure\Exception\NotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class UserRepository implements UserRepositoryInterface
{
    private const DB_TABLE_NAME = 'users';

    public function __construct(
        private readonly Connection $connection
    ) {}

    /**
     * @throws Exception
     * @throws NotFoundException
     */
    public function fetch(UserId $id): User
    {
        $rawUser = $this->connection
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
            ->where('id = :id')
            ->setParameter('id', $id->toString())
            ->fetchAssociative();

        if (!$rawUser) {
            throw NotFoundException::create();
        }

        return new User(
            UserId::fromString($rawUser['id']),
            $rawUser['email'],
            $rawUser['login'],
            new Password(
                $rawUser['password'],
                $rawUser['salt']
            ),
            $rawUser['salt']
        );
    }

    public function fetchByToken(string $apiToken): User
    {
        $rawUser = $this->connection
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

        if (!$rawUser) {
            throw NotFoundException::create();
        }

        return new User(
            UserId::fromString($rawUser['id']),
            $rawUser['email'],
            $rawUser['login'],
            new Password(
                $rawUser['password'],
                $rawUser['salt']
            ),
            $rawUser['salt']
        );
    }

    public function store(User $user): void
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
                'id' => $user->getId()->toString(),
                'email' => $user->getEmail(),
                'login' => $user->getLogin(),
                'password' => $user->getPassword()->password,
                'salt' => $user->getSalt(),
                'apiToken' => $user->getApiToken(),
            ])
            ->executeStatement();
    }
}

<?php

declare(strict_types=1);

namespace Framework\Security;

use App\Modules\Client\Domain\Repository\ClientRepository;
use App\SharedInfrastructure\Exception\NotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class ClientProvider implements UserProviderInterface
{
    public function __construct(private readonly ClientRepository $repository) {}


    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return UserWrapper::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            $client = $this->repository->fetchByToken($identifier);
        } catch (NotFoundException $exception) {
            throw new UserNotFoundException();
        }

        return ClientWrapper::createFromClient($client);
    }
}

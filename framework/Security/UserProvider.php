<?php

declare(strict_types=1);

namespace Framework\Security;

use App\Modules\Authentication\Domain\Exception\UserNotFoundException as DomainUserNotFoundException;
use App\Modules\Authentication\Infrastructure\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(private readonly UserRepository $repository) {}

    public function refreshUser(UserInterface $user): UserInterface
    {
        throw new \RuntimeException(
            sprintf('This is stateless REST API! User should not be refreshed!')
        );
    }

    public function supportsClass(string $class): bool
    {
        return UserWrapper::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            $user = $this->repository->fetchByToken($identifier);
        } catch (DomainUserNotFoundException $exception) {
            throw new UserNotFoundException();
        }

        return UserWrapper::createFromUser($user);
    }
}

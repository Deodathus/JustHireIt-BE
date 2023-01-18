<?php

declare(strict_types=1);

namespace Framework\Security;

use App\Modules\User\Domain\ValueObject\UserId;
use App\Modules\User\Infrastructure\Repository\UserRepository;
use App\SharedInfrastructure\Exception\NotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(private readonly UserRepository $repository) {}

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
            $user = $this->repository->fetch(UserId::fromString($identifier));
        } catch (NotFoundException $exception) {
            throw new UserNotFoundException();
        }

        return UserWrapper::createFromUser($user);
    }
}

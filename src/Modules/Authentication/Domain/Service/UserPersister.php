<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Service;

use App\Modules\Authentication\Domain\Entity\User;
use App\Modules\Authentication\Domain\Exception\LoginWasTakenException;
use App\Modules\Authentication\Domain\Repository\UserRepository;

final class UserPersister implements UserPersisterInterface
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    /**
     * @throws LoginWasTakenException
     */
    public function persist(User $user): void
    {
        if ($this->repository->existByLogin($user->getLogin())) {
            throw LoginWasTakenException::withLogin($user->getLogin());
        }

        $this->repository->store($user);
    }
}

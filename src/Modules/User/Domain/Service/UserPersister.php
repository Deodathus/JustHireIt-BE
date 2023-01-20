<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Service;

use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Domain\Repository\UserRepository;

final class UserPersister implements UserPersisterInterface
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    public function persist(User $user): void
    {
        $this->repository->store($user);
    }
}

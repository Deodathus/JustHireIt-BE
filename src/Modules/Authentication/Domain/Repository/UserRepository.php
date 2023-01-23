<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Repository;

use App\Modules\Authentication\Domain\Entity\User;
use App\Modules\Authentication\Domain\ValueObject\UserId;

interface UserRepository
{
    public function fetch(UserId $id): User;

    public function store(User $user): void;

    public function fetchByToken(string $apiToken): User;

    public function existByLogin(string $login): bool;
}

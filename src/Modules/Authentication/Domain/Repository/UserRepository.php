<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Repository;

use App\Modules\Authentication\Domain\Entity\User;
use App\Modules\Authentication\Domain\ValueObject\Password;
use App\Modules\Authentication\Domain\ValueObject\UserId;

interface UserRepository
{
    public function fetch(UserId $id): User;

    public function store(User $user): void;

    public function fetchByToken(string $apiToken): User;

    public function existsByLogin(string $login): bool;

    public function fetchTokenByLogin(string $login): string;

    public function fetchPasswordByLogin(string $login): Password;
}

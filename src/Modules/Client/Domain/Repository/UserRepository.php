<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Repository;

use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Domain\ValueObject\UserId;

interface UserRepository
{
    public function fetch(UserId $id): User;

    public function store(User $user): void;
}

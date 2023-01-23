<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Service;

use App\Modules\Authentication\Domain\Entity\User;

interface UserPersisterInterface
{
    public function persist(User $user): void;
}

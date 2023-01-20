<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Service;

use App\Modules\User\Domain\Entity\User;

interface UserPersisterInterface
{
    public function persist(User $user): void;
}

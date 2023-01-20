<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Repository;

use App\Modules\Client\Domain\Entity\Group;

interface ClientGroupRepository
{
    public function store(Group $group): void;
}

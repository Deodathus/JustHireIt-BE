<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Entity\Group;

interface ClientGroupPersisterInterface
{
    public function store(Group $group): void;
}

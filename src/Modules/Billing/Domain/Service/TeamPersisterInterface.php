<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Entity\Team;

interface TeamPersisterInterface
{
    public function store(Team $group): void;
}

<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Entity;

use App\Modules\Billing\Domain\ValueObject\TeamMemberId;

class TeamMember
{
    public function __construct(
        private readonly TeamMemberId $id
    ) {}

    public function getId(): TeamMemberId
    {
        return $this->id;
    }
}

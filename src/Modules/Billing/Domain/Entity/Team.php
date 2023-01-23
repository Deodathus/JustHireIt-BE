<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Entity;

use App\Modules\Billing\Domain\Enum\Features;
use App\Modules\Billing\Domain\ValueObject\OwnerId;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;

class Team
{
    /**
     * @param Features[] $features
     * @param TeamMemberId[] $members
     */
    public function __construct(
        private readonly TeamId $id,
        private readonly string $name,
        private readonly OwnerId $owner,
        private readonly array $members,
        private readonly array $features
    ) {}

    public function getId(): TeamId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwner(): OwnerId
    {
        return $this->owner;
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * @return Features[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }
}

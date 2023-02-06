<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Modules\Job\Domain\ValueObject\OwnerId;

class Company
{
    public function __construct(
        private readonly CompanyId $id,
        private readonly OwnerId $ownerId,
        private readonly string $name,
        private readonly string $description
    ) {}

    public function getId(): CompanyId
    {
        return $this->id;
    }

    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

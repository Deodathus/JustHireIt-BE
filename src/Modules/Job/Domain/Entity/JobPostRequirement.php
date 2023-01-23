<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\RequirementId;

class JobPostRequirement
{
    public function __construct(
        private readonly RequirementId $id,
        private readonly string $name
    ) {}
}

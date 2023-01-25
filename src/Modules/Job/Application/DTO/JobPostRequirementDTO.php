<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class JobPostRequirementDTO
{
    public function __construct(
        public readonly string $id
    ) {}
}

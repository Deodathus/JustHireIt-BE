<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ViewModel;

final class JobPostRequirementViewModel
{
    public function __construct(
        public readonly string $requirementId,
        public readonly string $name,
        public readonly int $score
    ) {}
}

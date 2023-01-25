<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ViewModel;

final class JobPostViewModel
{
    /**
     * @param JobPostPropertyViewModel[] $properties
     * @param JobPostRequirementViewModel[] $requirements
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly array $properties,
        public readonly array $requirements
    ) {}
}

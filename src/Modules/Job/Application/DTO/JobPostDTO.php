<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class JobPostDTO
{
    /**
     * @param JobPostPropertyDTO[] $properties
     * @param JobPostRequirementDTO[] $requirements
     */
    public function __construct(
        public readonly string $name,
        public readonly array $properties,
        public readonly array $requirements
    ) {}
}

<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

class JobPost
{
    /**
     * @param JobPostProperty[] $properties
     * @param JobPostRequirement[] $requirements
     */
    public function __construct(
        private readonly JobPostId $id,
        private readonly JobId $jobId,
        private readonly string $name,
        private readonly array $properties,
        private readonly array $requirements
    ) {}

    public function getId(): JobPostId
    {
        return $this->id;
    }

    public function getJobId(): JobId
    {
        return $this->jobId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getRequirements(): array
    {
        return $this->requirements;
    }
}

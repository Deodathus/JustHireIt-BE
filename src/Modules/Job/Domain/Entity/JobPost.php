<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\JobCloserId;
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
        private readonly array $requirements,
        private bool $isClosed,
        private ?\DateTimeImmutable $closedAt = null,
        private ?JobCloserId $closedBy = null
    ) {}

    /**
     * @param JobPostProperty[] $properties
     * @param JobPostRequirement[] $requirements
     */
    public static function create(
        JobPostId $id,
        JobId $jobId,
        string $name,
        array $properties,
        array $requirements,
    ): self
    {
        return new self(
            $id,
            $jobId,
            $name,
            $properties,
            $requirements,
            false
        );
    }

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

    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    public function getClosedAt(): ?\DateTimeImmutable
    {
        return $this->closedAt;
    }

    public function getClosedBy(): ?JobCloserId
    {
        return $this->closedBy;
    }

    public function close(
        JobCloserId $jobCloserId
    ): void {
        $this->isClosed = true;
        $this->closedAt = new \DateTimeImmutable();
        $this->closedBy = $jobCloserId;
    }
}

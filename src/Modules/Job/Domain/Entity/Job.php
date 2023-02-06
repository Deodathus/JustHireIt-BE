<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;
use App\Modules\Job\Domain\ValueObject\JobCloserId;
use App\Modules\Job\Domain\ValueObject\JobId;

class Job
{
    /**
     * @param JobPost[] $jobPosts
     */
    public function __construct(
        private readonly JobId $id,
        private readonly CompanyId $companyId,
        private readonly JobCategoryId $categoryId,
        private readonly string $name,
        private readonly array $jobPosts,
        private bool $isClosed,
        private ?\DateTimeImmutable $closedAt = null,
        private ?JobCloserId $closedBy = null
    ) {}

    public static function create(
        JobId $id,
        CompanyId $companyId,
        JobCategoryId $categoryId,
        string $name,
        array $jobPosts,
    ): self {
        return new self(
            $id,
            $companyId,
            $categoryId,
            $name,
            $jobPosts,
            false
        );
    }

    public function getId(): JobId
    {
        return $this->id;
    }

    public function getCompanyId(): CompanyId
    {
        return $this->companyId;
    }

    public function getCategoryId(): JobCategoryId
    {
        return $this->categoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getJobPosts(): array
    {
        return $this->jobPosts;
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

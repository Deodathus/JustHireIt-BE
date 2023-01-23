<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\Enum\JobPostPropertyTypes;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostPropertyId;

class JobPostProperty
{
    public function __construct(
        private readonly JobPostPropertyId $id,
        private readonly JobPostId $jobPostId,
        private readonly JobPostPropertyTypes $type,
        private readonly string $value
    ) {}

    public function getId(): JobPostPropertyId
    {
        return $this->id;
    }

    public function getJobPostId(): JobPostId
    {
        return $this->jobPostId;
    }

    public function getType(): JobPostPropertyTypes
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

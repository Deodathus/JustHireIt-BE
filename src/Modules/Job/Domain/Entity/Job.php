<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\OwnerId;

class Job
{
    /**
     * @param JobPost[] $jobPosts
     */
    public function __construct(
        private readonly JobId $id,
        private readonly OwnerId $ownerId,
        private readonly string $name,
        private readonly array $jobPosts
    ) {}

    public function getId(): JobId
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

    public function getJobPosts(): array
    {
        return $this->jobPosts;
    }
}

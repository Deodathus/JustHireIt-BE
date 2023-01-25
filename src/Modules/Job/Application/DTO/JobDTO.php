<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class JobDTO
{
    /**
     * @param JobPostDTO[] $jobPosts
     */
    public function __construct(
        public readonly string $name,
        public readonly string $ownerToken,
        public readonly array $jobPosts
    ) {}
}

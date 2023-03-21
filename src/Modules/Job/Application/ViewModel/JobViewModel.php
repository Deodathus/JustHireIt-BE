<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ViewModel;

final class JobViewModel
{
    /**
     * @param JobPostViewModel[] $jobPosts
     */
    public function __construct(
        public readonly string $id,
        public readonly string $categoryId,
        public readonly string $ownerId,
        public readonly string $name,
        public readonly array $jobPosts
    ) {}
}

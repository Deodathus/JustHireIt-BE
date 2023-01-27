<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\JobCategory;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;

interface JobCategoryRepository
{
    public function store(JobCategory $jobCategory): void;

    public function exists(JobCategoryId $id): bool;

    public function existsByName(string $name): bool;
}

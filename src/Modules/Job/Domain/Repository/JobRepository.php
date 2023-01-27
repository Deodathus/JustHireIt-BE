<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\ValueObject\JobId;

interface JobRepository
{
    public function fetch(JobId $id): Job;

    public function store(Job $job): void;

    public function close(Job $job): void;
}

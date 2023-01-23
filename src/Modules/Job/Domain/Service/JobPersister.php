<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\Repository\JobRepository;

final class JobPersister implements JobPersisterInterface
{
    public function __construct(
        private readonly JobRepository $repository
    ) {}

    public function store(Job $job): void
    {
        $this->repository->store($job);
    }
}

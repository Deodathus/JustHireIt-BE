<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\Exception\JobPostDoesNotExist;
use App\Modules\Job\Domain\Exception\JobPostIsNotAvailable;
use App\Modules\Job\Domain\Repository\JobPostRepository;
use App\Modules\Job\Domain\ValueObject\JobPostId;

final class JobPostAvailabilityChecker implements JobPostAvailabilityCheckerInterface
{
    public function __construct(
        private readonly JobPostRepository $repository
    ) {}

    public function check(JobPostId $id): bool
    {
        try {
            $this->repository->fetch($id);
        } catch (JobPostDoesNotExist $exception) {
            throw JobPostIsNotAvailable::withId($id->toString(), $exception);
        }

        return true;
    }
}

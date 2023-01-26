<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\Exception\ApplicantAlreadyAppliedOnJobPost;
use App\Modules\Job\Domain\Exception\JobPostDoesNotExist;
use App\Modules\Job\Domain\Exception\JobPostIsNotAvailable;
use App\Modules\Job\Domain\Repository\ApplicationRepository;
use App\Modules\Job\Domain\Repository\JobPostRepository;
use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

final class JobPostAvailabilityChecker implements JobPostAvailabilityCheckerInterface
{
    public function __construct(
        private readonly JobPostRepository $jobPostRepository,
        private readonly ApplicationRepository $applicationRepository
    ) {}

    public function check(ApplicantId $applicantId, JobPostId $jobPostId): bool
    {
        try {
            $this->jobPostRepository->fetch($jobPostId);
        } catch (JobPostDoesNotExist $exception) {
            throw JobPostIsNotAvailable::withId($jobPostId->toString(), $exception);
        }

        if ($this->applicationRepository->applicantAppliedOnJobPost($applicantId, $jobPostId)) {
            throw ApplicantAlreadyAppliedOnJobPost::withApplicantIdAndJobPostId(
                $applicantId->toString(),
                $jobPostId->toString()
            );
        }

        return true;
    }
}

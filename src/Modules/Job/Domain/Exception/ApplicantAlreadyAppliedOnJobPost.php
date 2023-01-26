<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Exception;

final class ApplicantAlreadyAppliedOnJobPost extends \Exception
{
    public static function withApplicantIdAndJobPostId(string $applicantId, string $jobPostId): self
    {
        return new self(
            "Applicant with id '{$applicantId}' already applied on job post with id '{$jobPostId}'"
        );
    }
}

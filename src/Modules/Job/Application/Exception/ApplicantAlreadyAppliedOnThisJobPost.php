<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class ApplicantAlreadyAppliedOnThisJobPost extends \Exception
{
    public static function withIds(string $applicantId, string $jobPostId): self
    {
        return new self(
            "Applicant with id '{$applicantId}' already applied on job post with id '{$jobPostId}'!"
        );
    }
}

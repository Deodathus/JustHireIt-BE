<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Job;

use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Infrastructure\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApplicationService extends WebTestCase
{
    public static function existsByIds(string $jobPostId, string $applicantId): bool
    {
        /** @var ApplicationRepository $applicationRepository */
        $applicationRepository = self::getContainer()->get(ApplicationRepository::class);

        return $applicationRepository->applicantAppliedOnJobPost(
            ApplicantId::fromString($applicantId),
            JobPostId::fromString($jobPostId)
        );
    }
}

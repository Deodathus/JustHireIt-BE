<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\Application;
use App\Modules\Job\Domain\Repository\ApplicationRepository as ApplicationRepositoryInterface;
use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use Doctrine\DBAL\Connection;

final class ApplicationRepository implements ApplicationRepositoryInterface
{
    private const DB_TABLE_NAME = 'applications';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(Application $application): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'applicant_id' => ':applicantId',
                'job_post_id' => ':jobPostId',
                'introduction' => ':introduction',
                'by_guest' => ':byGuest',
            ])
            ->setParameters([
                'id' => $application->getId()->toString(),
                'applicantId' => $application->getApplicantId()->toString(),
                'jobPostId' => $application->getJobPostId()->toString(),
                'introduction' => $application->getIntroduction(),
                'byGuest' => (int) $application->isByGuest(),
            ])
            ->executeStatement();
    }


    public function applicantAppliedOnJobPost(ApplicantId $applicantId, JobPostId $jobPostId): bool
    {
        $foundApplications = $this->connection
            ->createQueryBuilder()
            ->select(['id'])
            ->from(self::DB_TABLE_NAME)
            ->where('job_post_id = :jobPostId')
            ->andWhere('applicant_id = :applicantId')
            ->setParameters([
                'jobPostId' => $jobPostId->toString(),
                'applicantId' => $applicantId->toString(),
            ])
            ->fetchAllAssociative();

        return count($foundApplications) > 0;
    }
}

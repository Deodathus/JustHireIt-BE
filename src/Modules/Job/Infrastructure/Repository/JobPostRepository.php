<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\Entity\JobPostProperty;
use App\Modules\Job\Domain\Entity\JobPostRequirement;
use App\Modules\Job\Domain\Repository\JobPostRepository as JobPostRepositoryInterface;
use Doctrine\DBAL\Connection;

final class JobPostRepository implements JobPostRepositoryInterface
{
    private const DB_TABLE_NAME = 'job_posts';
    private const DB_PROPERTIES_TABLE_NAME = 'job_post_properties';
    private const DB_REQUIREMENTS_TABLE_NAME = 'job_post_requirements';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(JobPost $jobPost): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'job_id' => ':jobId',
                'name' => ':name',
            ])
            ->setParameters([
                'id' => $jobPost->getId()->toString(),
                'jobId' => $jobPost->getJobId()->toString(),
                'name' => $jobPost->getName(),
            ])
            ->executeStatement();

        foreach ($jobPost->getProperties() as $jobPostProperty) {
            $this->storeProperty($jobPostProperty);
        }

        foreach ($jobPost->getRequirements() as $jobPostRequirement) {
            $this->storeRequirement($jobPostRequirement);
        }
    }

    private function storeProperty(JobPostProperty $property): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_PROPERTIES_TABLE_NAME)
            ->values([
                'id' => ':id',
                'job_post_id' => ':jobPostId',
                'type' => ':type',
                'value' => ':value'
            ])
            ->setParameters([
                'id' => $property->getId()->toString(),
                'jobPostId' => $property->getJobPostId()->toString(),
                'type' => $property->getType()->name,
                'value' => $property->getValue(),
            ])
            ->executeStatement();
    }

    private function storeRequirement(JobPostRequirement $requirement): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_REQUIREMENTS_TABLE_NAME)
            ->values([
                'job_post_id' => ':jobPostId',
                'requirement_id' => ':requirementId',
            ])
            ->setParameters([
                'jobPostId' =>  $requirement->getJobPostId()->toString(),
                'requirementId' => $requirement->getId()->toString(),
            ])
            ->executeStatement();
    }
}

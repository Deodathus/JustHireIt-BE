<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\Entity\JobPostProperty;
use App\Modules\Job\Domain\Entity\JobPostRequirement;
use App\Modules\Job\Domain\Enum\JobPostPropertyTypes;
use App\Modules\Job\Domain\Exception\JobPostDoesNotExist;
use App\Modules\Job\Domain\Repository\JobPostRepository as JobPostRepositoryInterface;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostPropertyId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementScore;
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
                'score' => ':score',
            ])
            ->setParameters([
                'jobPostId' =>  $requirement->getJobPostId()->toString(),
                'requirementId' => $requirement->getId()->toString(),
                'score' => $requirement->getScore()->getScore(),
            ])
            ->executeStatement();
    }

    public function fetch(JobPostId $id): JobPost
    {
        $rawJobPost = $this->connection
            ->createQueryBuilder()
            ->select('id', 'job_id', 'name')
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id->toString())
            ->fetchAssociative();

        if (!$rawJobPost) {
            throw JobPostDoesNotExist::withId($id->toString());
        }

        return JobPost::create(
            $id,
            JobId::fromString($rawJobPost['job_id']),
            $rawJobPost['name'],
            $this->fetchProperties($id),
            $this->fetchRequirements($id)
        );
    }

    public function close(JobPost $jobPost): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DB_TABLE_NAME)
            ->set('closed', ':closed')
            ->set('closed_at', ':closedAt')
            ->set('closed_by', ':closedBy')
            ->where('id = :id')
            ->setParameters([
                'closed' => (int) $jobPost->isClosed(),
                'id' => $jobPost->getId()->toString(),
                'closedAt' => $jobPost->getClosedAt()->format('Y-m-d H:i:s'),
                'closedBy' => $jobPost->getClosedBy()->toString(),
            ])
            ->executeStatement();
    }

    public function jobPostBelongsToJob(JobId $jobId, JobPostId $jobPostId): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select('job_id')
            ->from(self::DB_TABLE_NAME)
            ->where('job_id = :jobId')
            ->andWhere('id = :jobPostId')
            ->setParameters([
                'jobId' => $jobId->toString(),
                'jobPostId' => $jobPostId->toString(),
            ])
            ->fetchAllAssociative();

        return count($found) > 0;
    }

    public function fetchNotClosedByJobId(JobId $jobId): array
    {
        $rawJobPosts = $this->connection
            ->createQueryBuilder()
            ->select('id', 'job_id', 'name')
            ->from(self::DB_TABLE_NAME)
            ->where('job_id = :jobId')
            ->andWhere('closed = :closed')
            ->setParameters([
                'jobId' => $jobId->toString(),
                'closed' => 0,
            ])
            ->fetchAllAssociative();

        $jobPosts = [];

        foreach ($rawJobPosts as $rawJobPost) {
            $jobPostId = JobPostId::fromString($rawJobPost['id']);

            $jobPosts[] = JobPost::create(
                $jobPostId,
                $jobId,
                $rawJobPost['name'],
                $this->fetchProperties($jobPostId),
                $this->fetchRequirements($jobPostId)
            );
        }

        return $jobPosts;
    }

    /**
     * @return JobPostProperty[]
     */
    private function fetchProperties(JobPostId $jobPostId): array
    {
        $rawProperties = $this->connection
            ->createQueryBuilder()
            ->select('id', 'type', 'value')
            ->from(self::DB_PROPERTIES_TABLE_NAME)
            ->where('job_post_id = :jobPostId')
            ->setParameter('jobPostId', $jobPostId->toString())
            ->fetchAllAssociative();

        $properties = [];
        foreach ($rawProperties as $rawProperty) {
            $properties[] = new JobPostProperty(
                JobPostPropertyId::fromString($rawProperty['id']),
                $jobPostId,
                JobPostPropertyTypes::tryFrom($rawProperty['type']),
                $rawProperty['value']
            );
        }

        return $properties;
    }

    /**
     * @return JobPostRequirement[]
     */
    private function fetchRequirements(JobPostId $jobPostId): array
    {
        $rawRequirements = $this->connection
            ->createQueryBuilder()
            ->select(['requirement_id', 'score'])
            ->from(self::DB_REQUIREMENTS_TABLE_NAME)
            ->where('job_post_id = :jobPostId')
            ->setParameter('jobPostId', $jobPostId->toString())
            ->fetchAllAssociative();

        $requirements = [];
        foreach ($rawRequirements as $rawRequirement) {
            $requirements[] = new JobPostRequirement(
                $jobPostId,
                JobPostRequirementId::fromString($rawRequirement['requirement_id']),
                new JobPostRequirementScore($rawRequirement['score'])
            );
        }

        return $requirements;
    }
}

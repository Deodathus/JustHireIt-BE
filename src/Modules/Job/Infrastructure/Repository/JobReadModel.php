<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Application\Exception\JobNotFound;
use App\Modules\Job\Application\ReadModel\JobReadModel as JobReadModelInterface;
use App\Modules\Job\Application\ViewModel\JobPostPropertyViewModel;
use App\Modules\Job\Application\ViewModel\JobPostRequirementViewModel;
use App\Modules\Job\Application\ViewModel\JobPostViewModel;
use App\Modules\Job\Application\ViewModel\JobViewModel;
use Doctrine\DBAL\Connection;

final class JobReadModel implements JobReadModelInterface
{
    private const DB_TABLE_NAME = 'jobs';
    private const DB_JOB_POSTS_TABLE_NAME = 'job_posts';

    private const DB_JOB_POST_PROPERTIES_TABLE_NAME = 'job_post_properties';

    private const DB_JOB_POST_REQUIREMENTS_TABLE_NAME = 'job_post_requirements';

    private const DB_SKILLS_TABLE_NAME = 'skills';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function fetch(string $id): JobViewModel
    {
        $job = $this->connection
            ->createQueryBuilder()
            ->select(['owner_id', 'name'])
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        if (!$job) {
            throw JobNotFound::withId($id);
        }

        return new JobViewModel(
            $id,
            $job['owner_id'],
            $job['name'],
            $this->fetchJobPosts($id)
        );
    }

    /**
     * @return JobPostViewModel[]
     */
    public function fetchJobPosts(string $jobId): array
    {
        $jobPosts = [];
        $rawJobPosts = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'name'])
            ->from(self::DB_JOB_POSTS_TABLE_NAME)
            ->where('job_id = :jobId')
            ->setParameter('jobId', $jobId)
            ->fetchAllAssociative();

        foreach ($rawJobPosts as $rawJobPost) {
            $jobPosts[$rawJobPost['id']] = new JobPostViewModel(
                $rawJobPost['id'],
                $rawJobPost['name'],
                $this->fetchProperties($rawJobPost['id']),
                $this->fetchRequirementsIds($rawJobPost['id'])
            );
        }

        return $jobPosts;
    }

    /**
     * @return JobPostPropertyViewModel[]
     */
    private function fetchProperties(string $jobPostId): array
    {
        $properties = [];
        $rawProperties = $this->connection
            ->createQueryBuilder()
            ->select('id', 'type', 'value')
            ->from(self::DB_JOB_POST_PROPERTIES_TABLE_NAME)
            ->where('job_post_id = :jobPostId')
            ->setParameter('jobPostId', $jobPostId)
            ->fetchAllAssociative();

        foreach ($rawProperties as $rawProperty) {
            $properties[$rawProperty['id']] = new JobPostPropertyViewModel(
                $rawProperty['type'],
                $rawProperty['value']
            );
        }

        return $properties;
    }

    /**
     * @return JobPostRequirementViewModel[]
     */
    private function fetchRequirementsIds(string $jobPostId): array
    {
        $requirements = [];
        $rawRequirements = $this->connection
            ->createQueryBuilder()
            ->select('jr.requirement_id', 's.name')
            ->from(self::DB_JOB_POST_REQUIREMENTS_TABLE_NAME, 'jr')
            ->leftJoin('jr', self::DB_SKILLS_TABLE_NAME, 's', 'jr.requirement_id = s.id')
            ->where('job_post_id = :jobPostId')
            ->setParameter('jobPostId', $jobPostId)
            ->fetchAllAssociative();

        foreach ($rawRequirements as $rawRequirement) {
            $requirements[$rawRequirement['requirement_id']] = new JobPostRequirementViewModel(
                $rawRequirement['requirement_id'],
                $rawRequirement['name']
            );
        }

        return $requirements;
    }
}

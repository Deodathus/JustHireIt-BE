<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Application\Exception\JobCategoryDoesNotExist;
use App\Modules\Job\Application\Exception\JobPostDoesNotExist;
use App\Modules\Job\Application\ReadModel\JobPostReadModel as JobPostReadModelInterface;
use App\Modules\Job\Application\Search\SearchQuery;
use App\Modules\Job\Application\ViewModel\JobPostPropertyViewModel;
use App\Modules\Job\Application\ViewModel\JobPostRequirementViewModel;
use App\Modules\Job\Application\ViewModel\JobPostViewModel;
use Doctrine\DBAL\Connection;

final class JobPostReadModel implements JobPostReadModelInterface
{
    private const DB_JOB_POSTS_TABLE_NAME = 'job_posts';
    private const DB_JOB_POST_PROPERTIES_TABLE_NAME = 'job_post_properties';
    private const DB_JOB_POST_REQUIREMENTS_TABLE_NAME = 'job_post_requirements';
    private const DB_SKILLS_TABLE_NAME = 'skills';
    private const DB_COMPANIES_TABLE_NAME = 'companies';
    private const DB_JOBS_TABLE_NAME = 'jobs';


    public function __construct(
        private readonly Connection $connection
    ) {}

    public function fetch(string $jobId, string $jobPostId): JobPostViewModel
    {
        $rawJobPost = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'name', 'job_id'])
            ->from(self::DB_JOB_POSTS_TABLE_NAME)
            ->where('id = :id')
            ->andWhere('job_id = :jobId')
            ->setParameter('id', $jobPostId)
            ->setParameter('jobId', $jobId)
            ->fetchAssociative();

        if (!$rawJobPost) {
            throw JobPostDoesNotExist::withIdAndJobId($jobPostId, $jobId);
        }

        $companyName = $this->connection
            ->createQueryBuilder()
            ->select('c.name')
            ->from(self::DB_COMPANIES_TABLE_NAME, 'c')
            ->join('c', self::DB_JOBS_TABLE_NAME, 'j', 'j.company_id = c.id')
            ->where('j.id = :jobId')
            ->setParameter('jobId', $rawJobPost['job_id'])
            ->fetchOne();

        return new JobPostViewModel(
            $rawJobPost['id'],
            $rawJobPost['job_id'],
            $companyName,
            $rawJobPost['name'],
            $this->fetchProperties($rawJobPost['id']),
            $this->fetchRequirementsIds($rawJobPost['id'])
        );
    }

    public function fetchAll(SearchQuery $searchQuery): array
    {
        $queryBuilder = $this->connection
            ->createQueryBuilder();

        $queryBuilder
            ->select(['id', 'name', 'job_id'])
            ->from(self::DB_JOB_POSTS_TABLE_NAME);

        if ($searchQuery->category) {
            $requirementId = $this->connection
                ->createQueryBuilder()
                ->select('id')
                ->from(self::DB_SKILLS_TABLE_NAME)
                ->where('name = :name')
                ->setParameter('name', $searchQuery->category)
                ->fetchOne();

            if (!$requirementId) {
                throw JobCategoryDoesNotExist::withName($searchQuery->category);
            }

            $jobPostsIds = $this->connection
                ->createQueryBuilder()
                ->select('job_post_id')
                ->from(self::DB_JOB_POST_REQUIREMENTS_TABLE_NAME)
                ->where('requirement_id = :requirementId')
                ->setParameter('requirementId', $requirementId)
                ->fetchAllAssociativeIndexed();

            $parsedJobPostsIds = array_map(
                static fn(string $id): string => '"' . $id . '"',
                array_keys($jobPostsIds)
            );

            if (empty($jobPostsIds)) {
                return [];
            }

            $queryBuilder->where(
                $queryBuilder->expr()->in(
                    'id',
                    $parsedJobPostsIds
                )
            );
        }

        $offset = ($searchQuery->page * $searchQuery->perPage) - $searchQuery->perPage;
        $queryBuilder->setMaxResults($searchQuery->perPage)
            ->setFirstResult($offset);
        $rawJobPosts = $queryBuilder->fetchAllAssociative();

        if (!$rawJobPosts) {
            return [];
        }

        $jobsIds = [];
        foreach ($rawJobPosts as $rawJobPost) {
            $jobsIds[$rawJobPost['job_id']] = $rawJobPost['job_id'];
        }

        $companiesQueryBuilder = $this->connection->createQueryBuilder();
        $companiesNames = $companiesQueryBuilder
            ->select('j.id, c.name')
            ->from(self::DB_COMPANIES_TABLE_NAME, 'c')
            ->join('c', self::DB_JOBS_TABLE_NAME, 'j', 'j.company_id = c.id')
            ->where(
                $companiesQueryBuilder->expr()->in(
                    'j.id', ':jobsIds'
                )
            )
            ->setParameter('jobsIds', $jobsIds, Connection::PARAM_STR_ARRAY)
            ->fetchAllAssociativeIndexed();

        $result = [];
        foreach ($rawJobPosts as $rawJobPost) {
            $result[$rawJobPost['id']] = new JobPostViewModel(
                $rawJobPost['id'],
                $rawJobPost['job_id'],
                $companiesNames[$rawJobPost['job_id']]['name'],
                $rawJobPost['name'],
                $this->fetchProperties($rawJobPost['id']),
                $this->fetchRequirementsIds($rawJobPost['id'])
            );
        }

        return $result;
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
            ->select('jr.requirement_id', 's.name', 'jr.score')
            ->from(self::DB_JOB_POST_REQUIREMENTS_TABLE_NAME, 'jr')
            ->leftJoin('jr', self::DB_SKILLS_TABLE_NAME, 's', 'jr.requirement_id = s.id')
            ->where('job_post_id = :jobPostId')
            ->setParameter('jobPostId', $jobPostId)
            ->fetchAllAssociative();

        foreach ($rawRequirements as $rawRequirement) {
            $requirements[$rawRequirement['requirement_id']] = new JobPostRequirementViewModel(
                $rawRequirement['requirement_id'],
                $rawRequirement['name'],
                $rawRequirement['score'],
            );
        }

        return $requirements;
    }
}

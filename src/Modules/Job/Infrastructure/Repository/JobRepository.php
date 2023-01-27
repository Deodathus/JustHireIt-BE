<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\Exception\JobDoesNotExist;
use App\Modules\Job\Domain\Repository\JobPostRepository as JobPostRepositoryInterface;
use App\Modules\Job\Domain\Repository\JobRepository as JobRepositoryInterface;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;
use App\Modules\Job\Domain\ValueObject\JobCloserId;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use Doctrine\DBAL\Connection;

final class JobRepository implements JobRepositoryInterface
{
    private const DB_TABLE_NAME = 'jobs';

    public function __construct(
        private readonly Connection $connection,
        private readonly JobPostRepositoryInterface $jobPostRepository
    ) {}

    public function store(Job $job): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'owner_id' => ':ownerId',
                'name' => ':name',
                'category_id' => ':categoryId',
            ])
            ->setParameters([
                'id' => $job->getId()->toString(),
                'ownerId' => $job->getOwnerId()->toString(),
                'name' => $job->getName(),
                'categoryId' => $job->getCategoryId()->toString(),
            ])
            ->executeStatement();

        foreach ($job->getJobPosts() as $jobPost) {
            $this->jobPostRepository->store($jobPost);
        }
    }

    public function fetch(JobId $id): Job
    {
        $rawJob = $this->connection
            ->createQueryBuilder()
            ->select('id', 'owner_id', 'category_id', 'name', 'closed', 'closed_at', 'closed_by')
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id->toString())
            ->fetchAssociative();

        if (!$rawJob) {
            throw JobDoesNotExist::withId($id->toString());
        }

        $jobPosts = $this->jobPostRepository->fetchNotClosedByJobId($id);

        return new Job(
            $id,
            OwnerId::fromString($rawJob['owner_id']),
            JobCategoryId::fromString($rawJob['category_id']),
            $rawJob['name'],
            $jobPosts,
            (bool) $rawJob['closed'],
            $rawJob['closed_at'],
            $rawJob['closed_by'] ?? JobCloserId::fromString($rawJob['closed_by'])
        );
    }

    public function close(Job $job): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DB_TABLE_NAME)
            ->set('closed', ':closed')
            ->set('closed_at', ':closedAt')
            ->set('closed_by', ':closedBy')
            ->where('id = :id')
            ->setParameters([
                'closed' => (int) $job->isClosed(),
                'id' => $job->getId()->toString(),
                'closedAt' => $job->getClosedAt()->format('Y-m-d H:i:s'),
                'closedBy' => $job->getClosedBy()->toString(),
            ])
            ->executeStatement();
    }
}

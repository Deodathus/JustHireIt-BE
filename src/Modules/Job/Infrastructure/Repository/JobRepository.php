<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\Repository\JobPostRepository as JobPostRepositoryInterface;
use App\Modules\Job\Domain\Repository\JobRepository as JobRepositoryInterface;
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
            ])
            ->setParameters([
                'id' => $job->getId()->toString(),
                'ownerId' => $job->getOwnerId()->toString(),
                'name' => $job->getName(),
            ])
            ->executeStatement();

        foreach ($job->getJobPosts() as $jobPost) {
            $this->jobPostRepository->store($jobPost);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\JobCategory;
use App\Modules\Job\Domain\Repository\JobCategoryRepository as JobCategoryRepositoryInterface;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;
use Doctrine\DBAL\Connection;

final class JobCategoryRepository implements JobCategoryRepositoryInterface
{
    private const DB_TABLE_NAME = 'job_categories';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(JobCategory $jobCategory): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'name' => ':name',
            ])
            ->setParameters([
                'id' => $jobCategory->getId()->toString(),
                'name' => $jobCategory->getName(),
            ])
            ->executeStatement();
    }

    public function exists(JobCategoryId $id): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id->toString())
            ->fetchAllAssociative();

        return count($found) > 0;
    }

    public function existsByName(string $name): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from(self::DB_TABLE_NAME)
            ->where('name = :name')
            ->setParameter('name', $name)
            ->fetchAllAssociative();

        return count($found) > 0;
    }
}

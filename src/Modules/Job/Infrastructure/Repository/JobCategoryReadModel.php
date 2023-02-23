<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Application\ReadModel\JobCategoryReadModel as JobCategoryReadModelInterface;
use App\Modules\Job\Application\ViewModel\JobCategoryViewModel;
use Doctrine\DBAL\Connection;

final class JobCategoryReadModel implements JobCategoryReadModelInterface
{
    private const JOB_CATEGORIES_TABLE_NAME = 'job_categories';

    public function __construct(
        private readonly Connection $connection
    ) {}

    /**
     * @return JobCategoryViewModel[]
     */
    public function fetchAll(): array
    {
        $result = [];

        $rawCategoriesData = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'name'])
            ->from(self::JOB_CATEGORIES_TABLE_NAME)
            ->fetchAllAssociative();

        foreach ($rawCategoriesData as $rawCategoryData) {
            $result[] = new JobCategoryViewModel(
                $rawCategoryData['id'],
                $rawCategoryData['name'],
            );
        }

        return $result;
    }
}

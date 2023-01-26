<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Domain\Entity\ApplicationFile;
use App\Modules\Job\Domain\Repository\ApplicationFileRepository as ApplicationFileRepositoryInterface;
use Doctrine\DBAL\Connection;

final class ApplicationFileRepository implements ApplicationFileRepositoryInterface
{
    private const DB_TABLE_NAME = 'application_files';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(ApplicationFile $applicationFile): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'job_post_id' => ':jobPostId',
                'file_path' => ':filePath',
                'name' => ':name',
            ])
            ->setParameters([
                'id' => $applicationFile->getId()->toString(),
                'jobPostId' => $applicationFile->getJobPostId()->toString(),
                'filePath' => $applicationFile->getFilePath()->getFullPath(),
                'name' => $applicationFile->getFilePath()->getName(),
            ])
            ->executeStatement();
    }
}

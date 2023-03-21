<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Repository;

use App\Modules\Candidate\Application\ReadModel\SkillReadModel as SkillReadModelInterface;
use App\Modules\Candidate\Application\ViewModel\SkillViewModel;
use Doctrine\DBAL\Connection;

final class SkillReadModel implements SkillReadModelInterface
{
    private const DB_TABLE_NAME = 'skills';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function fetchAll(): array
    {
        $rawSkills = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name')
            ->from(self::DB_TABLE_NAME)
            ->fetchAllAssociative();

        $result = [];
        foreach ($rawSkills as $skill) {
            $result[] = new SkillViewModel(
                $skill['id'],
                $skill['name']
            );
        }

        return $result;
    }
}

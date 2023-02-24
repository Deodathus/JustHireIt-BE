<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Repository;

use App\Modules\Candidate\Application\Exception\SkillDoesNotExist;
use App\Modules\Candidate\Domain\Entity\Skill;
use App\Modules\Candidate\Domain\Repository\SkillRepository as SkillRepositoryInterface;
use App\Modules\Candidate\Domain\ValueObject\SkillId;
use Doctrine\DBAL\Connection;

final class SkillRepository implements SkillRepositoryInterface
{
    private const DB_TABLE_NAME = 'skills';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(Skill $skill): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'name' => ':name',
            ])
            ->setParameters([
                'id' => $skill->getId()->toString(),
                'name' => $skill->getName(),
            ])
            ->executeStatement();
    }

    public function existsByName(string $name): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select(['id'])
            ->from(self::DB_TABLE_NAME)
            ->where('name = :name')
            ->setParameter('name', $name)
            ->fetchAllAssociative();

        return count($found) > 0;
    }

    public function fetchByName(string $name): Skill
    {
        $rawSkill = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name')
            ->from(self::DB_TABLE_NAME)
            ->where('name = :name')
            ->setParameter('name', $name)
            ->fetchAssociative();

        if (!$rawSkill) {
            throw SkillDoesNotExist::withName($name);
        }

        return new Skill(
            SkillId::fromString($rawSkill['id']),
            $rawSkill['name']
        );
    }

    public function exists(SkillId $id): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select(['id'])
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id->toString())
            ->fetchAllAssociative();

        return count($found) > 0;
    }
}

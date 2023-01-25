<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Repository;

use App\Modules\Candidate\Domain\Entity\CandidateSkill;
use App\Modules\Candidate\Domain\Repository\CandidateSkillRepository as CandidateSkillRepositoryInterface;
use Doctrine\DBAL\Connection;

final class CandidateSkillRepository implements CandidateSkillRepositoryInterface
{
    private const DB_TABLE_NAME = 'candidates_skills';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(CandidateSkill $skill): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'skill_id' => ':skillId',
                'candidate_id' => ':candidateId',
                'score' => ':score',
                'numeric_score' => ':numericScore',
            ])
            ->setParameters([
                'skillId' => $skill->getSkillId()->toString(),
                'candidateId' => $skill->getCandidateId()->toString(),
                'score' => $skill->getScore()->getScore(),
                'numericScore' => $skill->getScore()->getNumericScore(),
            ])
            ->executeStatement();
    }
}

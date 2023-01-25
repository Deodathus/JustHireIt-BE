<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Repository;

use App\Modules\Candidate\Domain\Entity\Candidate;
use App\Modules\Candidate\Domain\Repository\CandidateRepository as CandidateRepositoryInterface;
use App\Modules\Candidate\Domain\Repository\CandidateSkillRepository as CandidateSkillRepositoryInterface;
use Doctrine\DBAL\Connection;

final class CandidateRepository implements CandidateRepositoryInterface
{
    private const DB_TABLE_NAME = 'candidates';

    public function __construct(
        private readonly Connection $connection,
        private readonly CandidateSkillRepositoryInterface $candidateSkillRepository
    ) {}

    public function store(Candidate $candidate): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'first_name' => ':firstName',
                'last_name' => ':lastName',
            ])
            ->setParameters([
                'id' => $candidate->getId()->toString(),
                'firstName' => $candidate->getFirstName(),
                'lastName' => $candidate->getLastName(),
            ])
            ->executeStatement();

        foreach ($candidate->getSkills() as $skill) {
            $this->candidateSkillRepository->store($skill);
        }
    }
}

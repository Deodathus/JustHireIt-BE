<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\CommandHandler;

use App\Modules\Candidate\Application\Command\StoreCandidateCommand;
use App\Modules\Candidate\Application\DTO\CandidateSkillDTO;
use App\Modules\Candidate\Domain\Entity\Candidate;
use App\Modules\Candidate\Domain\Entity\CandidateSkill;
use App\Modules\Candidate\Domain\Service\CandidatePersister;
use App\Modules\Candidate\Domain\ValueObject\CandidateId;
use App\Modules\Candidate\Domain\ValueObject\SkillId;
use App\Modules\Candidate\Domain\ValueObject\SkillScore;
use App\Shared\Application\Messenger\CommandHandler;

final class StoreCandidateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CandidatePersister $candidatePersister
    ) {}

    public function __invoke(StoreCandidateCommand $storeCandidateCommand): string
    {
        $id = CandidateId::generate();

        $skills = $this->prepareSkills($id, $storeCandidateCommand->candidate->skills);

        $this->candidatePersister->store(
            new Candidate(
                $id,
                $storeCandidateCommand->candidate->firstName,
                $storeCandidateCommand->candidate->lastName,
                $skills
            )
        );

        return $id->toString();
    }

    /**
     * @param CandidateSkillDTO[] $skills
     *
     * @return CandidateSkill[]
     */
    private function prepareSkills(CandidateId $candidateId, array $skills): array
    {
        $candidateSkills = [];

        foreach ($skills as $skill) {
            $candidateSkills[] = new CandidateSkill(
                SkillId::fromString($skill->skillId),
                $candidateId,
                $skill->name,
                new SkillScore($skill->score, $skill->numericScore)
            );
        }

        return $candidateSkills;
    }
}

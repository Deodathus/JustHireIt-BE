<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Controller\Candidate;

use App\Modules\Candidate\Application\Command\StoreCandidateCommand;
use App\Modules\Candidate\Application\DTO\CandidateDTO;
use App\Modules\Candidate\Application\DTO\CandidateSkillDTO;
use App\Modules\Candidate\Infrastructure\Http\Request\StoreCandidateRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StoreController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(StoreCandidateRequest $request): JsonResponse
    {
        $candidateSkills = [];

        foreach ($request->skills as $skill) {
            $candidateSkills[] = new CandidateSkillDTO(
                $skill['id'],
                $skill['name'],
                $skill['score'],
                $skill['numericScore']
            );
        }

        $id = $this->commandBus->dispatch(
            new StoreCandidateCommand(
                new CandidateDTO(
                    $request->firstName,
                    $request->lastName,
                    $candidateSkills
                )
            )
        );

        return new JsonResponse(
            [
                'id' => $id,
            ]
        );
    }
}

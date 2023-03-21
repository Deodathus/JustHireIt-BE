<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\CommandHandler;

use App\Modules\Candidate\Application\Command\StoreCandidateCommand;
use App\Modules\Candidate\Application\DTO\CandidateDTO;
use App\Modules\Candidate\ModuleApi\Application\Command\CreateCandidate;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\CommandHandler;

final class CreateCandidateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(CreateCandidate $command): string
    {
        return $this->commandBus->dispatch(
            new StoreCandidateCommand(
                new CandidateDTO(
                    $command->name,
                    $command->lastName,
                    []
                )
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Job\Application\Command\StoreCompanyCommand;
use App\Modules\Job\ModuleApi\Application\Command\CreateCompanyCommand;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\CommandHandler;

final class CreateCompanyCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(CreateCompanyCommand $command): void
    {
        $this->commandBus->dispatch(
            new StoreCompanyCommand(
                $command->ownerToken,
                $command->companyName,
                $command->companyDescription
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Exception\UserDoesNotExist;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamByMember;
use App\Modules\Job\Application\Command\StoreCompanyCommand;
use App\Modules\Job\Application\Exception\JobOwnerDoesNotExist;
use App\Modules\Job\Domain\Entity\Company;
use App\Modules\Job\Domain\Repository\CompanyRepository;
use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;

final class StoreCompanyCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(StoreCompanyCommand $command): string
    {
        $id = CompanyId::generate();

        try {
            $ownerId = $this->queryBus->handle(
                new GetTeamByMember(
                    $this->queryBus->handle(
                        new GetUserIdByTokenQuery($command->ownerToken)
                    )
                )
            )->id;
        } catch (UserDoesNotExist $exception) {
            throw JobOwnerDoesNotExist::withId($command->ownerToken);
        }

        $this->companyRepository->store(
            new Company(
                $id,
                OwnerId::fromString($ownerId),
                $command->name,
                $command->description
            )
        );

        return $id->toString();
    }
}

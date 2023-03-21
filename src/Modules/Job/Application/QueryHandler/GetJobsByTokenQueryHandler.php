<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\QueryHandler;

use App\Modules\Authentication\ModuleApi\Application\Exception\UserDoesNotExist;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamByMember;
use App\Modules\Job\Application\DTO\JobDTO;
use App\Modules\Job\Application\Exception\JobOwnerDoesNotExist;
use App\Modules\Job\Application\Query\GetJobsByTokenQuery;
use App\Modules\Job\Application\ReadModel\JobReadModel;
use App\Modules\Job\Domain\Repository\CompanyRepository;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use App\Shared\Application\Messenger\QueryBus;
use App\Shared\Application\Messenger\QueryHandler;

final class GetJobsByTokenQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly JobReadModel $readModel,
        private readonly QueryBus $queryBus,
        private readonly CompanyRepository $companyRepository
    ) {}

    /**
     * @return JobDTO[]
     */
    public function __invoke(GetJobsByTokenQuery $query): array
    {
        try {
            $ownerId = $this->queryBus->handle(
                new GetTeamByMember(
                    $this->queryBus->handle(
                        new GetUserIdByTokenQuery($query->ownerToken)
                    )
                )
            )->id;
        } catch (UserDoesNotExist $exception) {
            throw JobOwnerDoesNotExist::withId($query->ownerToken);
        }

        return $this->readModel->fetchByOwnerId(
            $this->companyRepository->fetchCompanyIdByOwner(OwnerId::fromString($ownerId))
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\QueryHandler;

use App\Modules\Authentication\Application\DTO\MeDTO;
use App\Modules\Authentication\Application\Exception\UserNotFoundException;
use App\Modules\Authentication\Application\Query\GetMeQuery;
use App\Modules\Authentication\Domain\Exception\UserNotFoundException as UserNotFoundDomainException;
use App\Modules\Authentication\Domain\Repository\UserRepository;
use App\Modules\Billing\ModuleApi\Application\DTO\Team;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamByMember;
use App\Shared\Application\Messenger\QueryBus;
use App\Shared\Application\Messenger\QueryHandler;

final class GetMeQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(GetMeQuery $getMeQuery): MeDTO
    {
        try {
            $user = $this->repository->fetchByToken($getMeQuery->token);
        } catch (UserNotFoundDomainException $exception) {
            throw UserNotFoundException::fromPrevious($exception);
        }

        /** @var Team $team */
        $team = $this->queryBus->handle(
            new GetTeamByMember($user->getId()->toString())
        );

        return new MeDTO(
            $user->getLogin(),
            $user->getEmail(),
            $team->name,
            $team->features
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\QueryHandler;

use App\Modules\Client\Application\DTO\MeDTO;
use App\Modules\Client\Application\Exception\ClientNotFoundException;
use App\Modules\Client\Application\Query\GetMeQuery;
use App\Modules\Client\Domain\Enum\Permissions;
use App\Modules\Client\Domain\Exception\ClientNotFoundException as ClientNotFoundDomainException;
use App\Modules\Client\Domain\Repository\ClientGroupRepository;
use App\Modules\Client\Domain\Repository\ClientRepository;
use App\Shared\Application\Messenger\QueryHandler;

final class GetMeQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ClientRepository $repository,
        private readonly ClientGroupRepository $groupRepository
    ) {}

    public function __invoke(GetMeQuery $getMeQuery): MeDTO
    {
        try {
            $client = $this->repository->fetchByToken($getMeQuery->token);
        } catch (ClientNotFoundDomainException $exception) {
            throw ClientNotFoundException::fromPrevious($exception);
        }

        $group = $this->groupRepository->fetchByClient($client->getId());

        return new MeDTO(
            $client->getLogin(),
            $client->getEmail(),
            $group->getName(),
            array_map(
                static fn(Permissions $permission) => $permission->value, $group->getPermissions()
            )
        );
    }
}

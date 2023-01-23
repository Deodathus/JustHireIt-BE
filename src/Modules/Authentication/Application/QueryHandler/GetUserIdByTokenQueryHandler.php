<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\QueryHandler;

use App\Modules\Authentication\Application\Exception\UserNotFoundException;
use App\Modules\Authentication\Domain\Exception\UserNotFoundException as UserNotFoundDomainException;
use App\Modules\Authentication\Domain\Repository\UserRepository;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Shared\Application\Messenger\QueryHandler;

final class GetUserIdByTokenQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    public function __invoke(GetUserIdByTokenQuery $query): string
    {
        try {
            $user = $this->repository->fetchByToken($query->token);
        } catch (UserNotFoundDomainException $exception) {
            throw UserNotFoundException::fromPrevious($exception);
        }

        return $user->getApiToken();
    }
}

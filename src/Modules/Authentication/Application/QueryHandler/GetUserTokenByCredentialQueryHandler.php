<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\QueryHandler;

use App\Modules\Authentication\Application\Exception\UserNotFoundException;
use App\Modules\Authentication\Application\Query\GetUserTokenByCredentialsQuery;
use App\Modules\Authentication\Domain\Exception\UserNotFoundException as UserNotFoundDomainException;
use App\Modules\Authentication\Domain\Repository\UserRepository;
use App\Shared\Application\Messenger\QueryHandler;
use App\Shared\Application\Service\PasswordVerificatorInterface;

final class GetUserTokenByCredentialQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordVerificatorInterface $passwordVerificator
    ) {}

    public function __invoke(GetUserTokenByCredentialsQuery $query): string
    {
        try {
            $password = $this->userRepository->fetchPasswordByLogin($query->login);

            $passwordIsCorrect = $this->passwordVerificator->verify(
                $password->password,
                $query->password,
                $password->salt
            );

            if ($passwordIsCorrect) {
                $token = $this->userRepository->fetchTokenByLogin($query->login);
            } else {
                throw UserNotFoundException::withGivenCredentials();
            }
        } catch (UserNotFoundDomainException $exception) {
            throw UserNotFoundException::fromPrevious($exception);
        }

        return $token;
    }
}

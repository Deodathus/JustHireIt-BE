<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\CommandHandler;

use App\Modules\Authentication\Application\DTO\RawPassword;
use App\Modules\Authentication\Application\Exception\LoginIsAlreadyTaken;
use App\Modules\Authentication\Domain\Entity\User;
use App\Modules\Authentication\Domain\Exception\LoginWasTakenException;
use App\Modules\Authentication\Domain\Service\UserPersisterInterface;
use App\Modules\Authentication\Domain\ValueObject\Password;
use App\Modules\Authentication\Domain\ValueObject\UserId;
use App\Modules\Authentication\ModuleApi\Application\Command\CreateUserCommand;
use App\Shared\Application\Api\Service\ApiTokenGeneratorInterface;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Service\PasswordHasherInterface;

final class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserPersisterInterface $userPersister,
        private readonly ApiTokenGeneratorInterface $apiTokenGenerator,
        private readonly PasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke(CreateUserCommand $command): string
    {
        $id = UserId::generate();
        $hashedPassword = $this->passwordHasher->hash(
            new RawPassword($command->user->password)
        );
        $apiToken = $this->apiTokenGenerator->generate(
            $id,
            $hashedPassword->salt
        );

        try {
            $this->userPersister->persist(
                new User(
                    $id,
                    $command->user->email,
                    $command->user->login,
                    new Password($hashedPassword->password, $hashedPassword->salt),
                    $apiToken->value()
                )
            );
        } catch (LoginWasTakenException $exception) {
            throw LoginIsAlreadyTaken::withLogin($command->user->login, $exception);
        }

        return $id->toString();
    }
}

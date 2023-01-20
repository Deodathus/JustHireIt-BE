<?php

declare(strict_types=1);

namespace App\Modules\User\Application\CommandHandler;

use App\Modules\User\Application\Command\SignUpUserCommand;
use App\Modules\User\Application\DTO\UserApiTokenDTO;
use App\Modules\User\Domain\Service\UserSignUpperInterface;
use App\Modules\User\Domain\ValueObject\UserId;
use App\Shared\Application\Api\Service\ApiTokenGeneratorInterface;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Password\DTO\RawPassword;
use App\Shared\Application\Service\PasswordHasherInterface;

final class SignUpUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserSignUpperInterface $signUpper,
        private readonly ApiTokenGeneratorInterface $apiTokenGenerator,
        private readonly PasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke(SignUpUserCommand $command): UserApiTokenDTO
    {
        $id = UserId::generate();
        $hashedPassword = $this->passwordHasher->hash(
            new RawPassword($command->userDTO->password)
        );
        $apiToken = $this->apiTokenGenerator->generate(
            $id,
            $hashedPassword->salt
        );

        $this->signUpper->signUp(
            $id,
            $command->userDTO->login,
            $hashedPassword,
            $apiToken,
            $command->userDTO->email
        );

        return new UserApiTokenDTO(
            $apiToken->value()
        );
    }
}

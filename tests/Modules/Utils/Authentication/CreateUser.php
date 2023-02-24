<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Authentication;

use App\Modules\Authentication\Application\Command\SignUpUserCommand;
use App\Modules\Authentication\Application\CommandHandler\SignUpUserCommandHandler;
use App\Modules\Authentication\Application\DTO\UserDTO;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CreateUser extends WebTestCase
{
    /** @test */
    public static function createUser(
        string $login = 'test',
        string $password = 'test',
        string $email = 'test@example.com'
    ): string {
        /** @var SignUpUserCommandHandler $userRepository */
        $signUpper = self::getContainer()->get(SignUpUserCommandHandler::class);
        $apiToken = ($signUpper)(new SignUpUserCommand(
            new UserDTO(
                'test',
                'test',
                'test@example.com'
            )
        ));

        return $apiToken->apiToken;
    }
}

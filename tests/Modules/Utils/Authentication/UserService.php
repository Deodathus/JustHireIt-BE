<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Authentication;

use App\Modules\Authentication\Infrastructure\Repository\UserRepository as UserRepositoryImplementation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UserService extends WebTestCase
{
    public static function existsByLogin(string $login): bool
    {
        /** @var UserRepositoryImplementation $userRepository */
        $userRepository = self::getContainer()->get(UserRepositoryImplementation::class);

        return $userRepository->existsByLogin($login);
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Shared\Application\Password\DTO\HashedPassword;
use App\Shared\Application\Password\DTO\RawPassword;
use Ramsey\Uuid\Uuid;

final class PasswordHasher implements PasswordHasherInterface
{
    public function hash(RawPassword $password): HashedPassword
    {
        $salt = Uuid::uuid4()->toString();

        return new HashedPassword(
            password_hash(
                $password->password . $salt,
                PASSWORD_DEFAULT
            ),
            $salt
        );
    }
}

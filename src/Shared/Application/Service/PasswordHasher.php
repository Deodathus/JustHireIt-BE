<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Modules\Authentication\Application\DTO\HashedPassword;
use App\Modules\Authentication\Application\DTO\RawPassword;
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

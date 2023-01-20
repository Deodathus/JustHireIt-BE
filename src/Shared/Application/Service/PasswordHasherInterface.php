<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Shared\Application\Password\DTO\HashedPassword;
use App\Shared\Application\Password\DTO\RawPassword;

interface PasswordHasherInterface
{
    public function hash(RawPassword $password): HashedPassword;
}

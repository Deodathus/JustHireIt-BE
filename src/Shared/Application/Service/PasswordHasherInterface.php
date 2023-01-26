<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Modules\Authentication\Application\DTO\HashedPassword;
use App\Modules\Authentication\Application\DTO\RawPassword;

interface PasswordHasherInterface
{
    public function hash(RawPassword $password): HashedPassword;
}

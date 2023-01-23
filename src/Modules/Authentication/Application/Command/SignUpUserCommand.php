<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\Command;

use App\Modules\Authentication\Application\DTO\UserDTO;
use App\Shared\Application\Messenger\Command;

final class SignUpUserCommand implements Command
{
    public function __construct(
        public readonly UserDTO $userDTO
    ) {}
}

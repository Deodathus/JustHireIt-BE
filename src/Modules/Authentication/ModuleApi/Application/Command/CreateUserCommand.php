<?php

declare(strict_types=1);

namespace App\Modules\Authentication\ModuleApi\Application\Command;

use App\Modules\Authentication\ModuleApi\Application\DTO\UserDTO;
use App\Shared\Application\Messenger\Command;

final class CreateUserCommand implements Command
{
    public function __construct(
        public readonly UserDTO $user
    ) {}
}

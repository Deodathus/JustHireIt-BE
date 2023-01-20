<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\Command;

use App\Modules\Client\Application\DTO\ClientDTO;
use App\Shared\Application\Messenger\Command;

final class SignUpClientCommand implements Command
{
    public function __construct(
        public readonly ClientDTO $userDTO
    ) {}
}

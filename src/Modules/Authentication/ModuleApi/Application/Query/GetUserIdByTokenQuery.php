<?php

declare(strict_types=1);

namespace App\Modules\Authentication\ModuleApi\Application\Query;

use App\Shared\Application\Messenger\Query;

final class GetUserIdByTokenQuery implements Query
{
    public function __construct(
        public readonly string $token
    ) {}
}

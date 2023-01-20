<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\Query;

use App\Shared\Application\Messenger\Query;

final class GetMeQuery implements Query
{
    public function __construct(
        public readonly string $token
    ) {}
}

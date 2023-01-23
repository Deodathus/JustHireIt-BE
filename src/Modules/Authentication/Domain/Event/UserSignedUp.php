<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Event;

use App\Shared\Application\Messenger\Event;

final class UserSignedUp implements Event
{
    public function __construct(
        public readonly string $id
    ) {}
}

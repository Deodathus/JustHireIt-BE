<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\DTO;

final class InvitationDTO
{
    public function __construct(
        public readonly string $teamId,
        public readonly string $creatorApiToken,
    ) {}
}

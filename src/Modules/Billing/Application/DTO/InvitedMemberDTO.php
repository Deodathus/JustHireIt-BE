<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\DTO;

final class InvitedMemberDTO
{
    public function __construct(
        public readonly string $teamId,
        public readonly string $invitationId,
        public readonly string $email,
        public readonly string $login,
        public readonly string $password
    ) {}
}

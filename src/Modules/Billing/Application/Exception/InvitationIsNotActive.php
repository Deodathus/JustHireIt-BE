<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Exception;

final class InvitationIsNotActive extends \Exception
{
    public static function withId(string $invitationId): self
    {
        return new self(
            "Invitation with id '{$invitationId}' is not active!"
        );
    }
}

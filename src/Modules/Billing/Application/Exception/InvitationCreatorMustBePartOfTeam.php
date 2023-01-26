<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Exception;

final class InvitationCreatorMustBePartOfTeam extends \Exception
{
    public static function withIds(string $creatorId, string $teamId): self
    {
        return new self(
            "Invitation creator with id '{$creatorId}' must be part of a team 
            with id '{$teamId}' to create an invitation"
        );
    }
}

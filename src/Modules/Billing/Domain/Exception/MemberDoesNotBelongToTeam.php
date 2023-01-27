<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Exception;

final class MemberDoesNotBelongToTeam extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Member with id '{$id}' does not belong to any team!"
        );
    }
}

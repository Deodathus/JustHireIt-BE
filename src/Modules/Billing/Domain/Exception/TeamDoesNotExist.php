<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Exception;

final class TeamDoesNotExist extends \Exception
{
    public static function withName(string $name): self
    {
        return new self(
            "Team with given name '{$name} does not exist!'"
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Exception;

final class TeamDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Team with id '{$id} does not exist!'"
        );
    }

    public static function withName(string $name): self
    {
        return new self(
            "Team with given name '{$name} does not exist!'"
        );
    }
}

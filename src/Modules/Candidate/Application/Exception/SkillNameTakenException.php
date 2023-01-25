<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Exception;

final class SkillNameTakenException extends \Exception
{
    public static function withName(string $name): self
    {
        return new self(
            "Skill with name '{$name}' already exists!"
        );
    }
}

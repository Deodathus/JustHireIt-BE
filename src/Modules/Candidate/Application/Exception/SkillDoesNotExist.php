<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Exception;

final class SkillDoesNotExist extends \Exception
{
    public static function withName(string $name): self
    {
        return new self("Skill with given name '{$name}' does not exist");
    }
}

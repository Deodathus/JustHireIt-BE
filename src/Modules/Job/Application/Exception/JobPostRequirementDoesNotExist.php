<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobPostRequirementDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Job post requirement with id '{$id}' does not exist!"
        );
    }

    public static function withName(string $name): self
    {
        return new self(
            "Job post requirement with name '{$name}' does not exist!"
        );
    }
}

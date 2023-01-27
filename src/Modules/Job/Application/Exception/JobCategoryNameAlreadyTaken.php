<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobCategoryNameAlreadyTaken extends \Exception
{
    public static function withName(string $name): self
    {
        return new self(
            "Category name '{$name}' is already taken!"
        );
    }
}

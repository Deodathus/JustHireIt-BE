<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobCategoryDoesNotExist extends \Exception
{
    public static function withId(string $categoryId): self
    {
        return new self(
            "Category with id '{$categoryId}' does not exits!"
        );
    }

    public static function withName(string $name): self
    {
        return new self(
            "Category with name '{$name}' does not exits!"
        );
    }
}

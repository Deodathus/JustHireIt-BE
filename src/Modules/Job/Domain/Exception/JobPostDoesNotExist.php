<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Exception;

final class JobPostDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Job post with given id '{$id} does not exist!'"
        );
    }
}

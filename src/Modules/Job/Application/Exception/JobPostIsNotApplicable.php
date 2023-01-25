<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobPostIsNotApplicable extends \Exception
{
    public static function withId(string $id, \Throwable $previous): self
    {
        return new self(
            "Job post with give id '{$id}' is not applicable!",
            0,
            $previous
        );
    }
}

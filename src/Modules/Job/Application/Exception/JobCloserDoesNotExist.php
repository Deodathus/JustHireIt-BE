<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobCloserDoesNotExist extends \Exception
{
    public static function withId(string $jobCloserId): self
    {
        return new self(
            "Job closer with id '{$jobCloserId}' does not exist!"
        );
    }
}

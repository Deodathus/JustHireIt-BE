<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Exception;

final class CanNotMoveFileException extends \Exception
{
    public static function fromPrevious(\Throwable $previous): self
    {
        return new self($previous->getMessage(), 0, $previous);
    }
}

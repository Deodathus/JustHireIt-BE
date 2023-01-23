<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\Exception;

final class UserSignUpException extends \Exception
{
    public static function fromPrevious(\Throwable $previous): self
    {
        return new self($previous->getMessage(), 0, $previous);
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\Exception;

final class UserNotFoundException extends \Exception
{
    public static function fromPrevious(\Throwable $previous): self
    {
        return new self($previous->getMessage(), 0, $previous);
    }

    public static function withGivenCredentials(): self
    {
        return new self('User with given credentials does not exist!');
    }
}

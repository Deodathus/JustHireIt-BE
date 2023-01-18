<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Exception;

class NotFoundException extends \Exception
{
    public static function create(): self
    {
        return new self();
    }
}

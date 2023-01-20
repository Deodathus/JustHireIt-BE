<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Http\Response;

use Assert\InvalidArgumentException;

final class ValidationErrorResponse
{
    public static function getResponseContent(InvalidArgumentException ...$errors): array
    {
        return array_map(
            static fn(InvalidArgumentException $exception) => [
                'property' => $exception->getPropertyPath(),
                'error' => $exception->getMessage(),
            ],
            $errors
        );
    }
}

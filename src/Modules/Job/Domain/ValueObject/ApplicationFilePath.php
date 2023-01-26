<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\ValueObject;

final class ApplicationFilePath
{
    public function __construct(
        private readonly string $fullPath,
        private readonly string $name
    ) {}

    public function getFullPath(): string
    {
        return $this->fullPath;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

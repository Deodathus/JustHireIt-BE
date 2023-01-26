<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class FilePathDTO
{
    public function __construct(
        public readonly string $filePath,
        public readonly string $fileName
    ) {}
}

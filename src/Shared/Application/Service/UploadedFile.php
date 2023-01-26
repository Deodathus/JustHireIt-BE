<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

interface UploadedFile
{
    public function move(string $path, ?string $name = null): void;

    public function getName(): string;
}

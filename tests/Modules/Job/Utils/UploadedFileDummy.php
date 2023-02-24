<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils;

use App\Shared\Application\Service\UploadedFile;

final class UploadedFileDummy implements UploadedFile
{
    public function __construct() {}

    public function move(string $path, ?string $name = null): void
    {
        // TODO: Implement move() method.
    }

    public function getName(): string
    {
        return 'test';
    }
}

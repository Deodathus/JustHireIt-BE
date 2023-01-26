<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Modules\Job\Application\DTO\FilePathDTO;

interface FileUploader
{
    public function upload(UploadedFile $file, string $path, string $name): FilePathDTO;
}

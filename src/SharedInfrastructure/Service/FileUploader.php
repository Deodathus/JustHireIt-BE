<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Service;

use App\Modules\Job\Application\DTO\FilePathDTO;
use App\Shared\Application\Service\FileUploader as FileUploaderInterface;
use App\Shared\Application\Service\UploadedFile;

final class FileUploader implements FileUploaderInterface
{
    public function __construct(
        private readonly string $storagePath
    ) {}

    public function upload(UploadedFile $file, string $path, string $name): FilePathDTO
    {
        $fullFilePath = $this->storagePath . $path;
        $file->move($this->storagePath . $path, $name);

        return new FilePathDTO(
            $fullFilePath,
            $name
        );
    }
}

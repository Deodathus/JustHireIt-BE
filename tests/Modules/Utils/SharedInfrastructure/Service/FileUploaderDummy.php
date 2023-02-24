<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\SharedInfrastructure\Service;

use App\Modules\Job\Application\DTO\FilePathDTO;
use App\Shared\Application\Service\FileUploader;
use App\Shared\Application\Service\UploadedFile;

final class FileUploaderDummy implements FileUploader
{
    public function upload(UploadedFile $file, string $path, string $name): FilePathDTO
    {
        return new FilePathDTO('', '');
    }
}

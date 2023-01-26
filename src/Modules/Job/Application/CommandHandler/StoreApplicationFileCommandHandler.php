<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Job\Application\Command\StoreApplicationFileCommand;
use App\Modules\Job\Domain\Entity\ApplicationFile;
use App\Modules\Job\Domain\Service\ApplicationFilePersister;
use App\Modules\Job\Domain\ValueObject\ApplicationFileId;
use App\Modules\Job\Domain\ValueObject\ApplicationFilePath;
use App\Modules\Job\Domain\ValueObject\ApplicationId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Service\FileUploader;

final class StoreApplicationFileCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        private readonly ApplicationFilePersister $filePersister
    ) {}

    public function __invoke(StoreApplicationFileCommand $command): void
    {
        $path = $this->fileUploader->upload(
            $command->file,
            $this->preparePath($command->applicationId),
            $command->file->getName()
        );

        $this->filePersister->store(
            new ApplicationFile(
                ApplicationFileId::generate(),
                $command->jobPostId,
                new ApplicationFilePath(
                    $path->filePath,
                    $path->fileName
                )
            )
        );
    }

    private function preparePath(ApplicationId $applicationId): string
    {
        return '/' . $applicationId->toString();
    }
}

<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Modules\Job\Domain\ValueObject\ApplicationId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Shared\Application\Messenger\Command;
use App\Shared\Application\Service\UploadedFile;

final class StoreApplicationFileCommand implements Command
{
    public function __construct(
        public readonly JobPostId $jobPostId,
        public readonly ApplicationId $applicationId,
        public readonly UploadedFile $file
    ) {}
}

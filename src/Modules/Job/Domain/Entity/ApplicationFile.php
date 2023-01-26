<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\ApplicationFileId;
use App\Modules\Job\Domain\ValueObject\ApplicationFilePath;
use App\Modules\Job\Domain\ValueObject\JobPostId;

class ApplicationFile
{
    public function __construct(
        private readonly ApplicationFileId $id,
        private readonly JobPostId $jobPostId,
        private readonly ApplicationFilePath $filePath
    ) {}

    public function getId(): ApplicationFileId
    {
        return $this->id;
    }

    public function getJobPostId(): JobPostId
    {
        return $this->jobPostId;
    }

    public function getFilePath(): ApplicationFilePath
    {
        return $this->filePath;
    }
}

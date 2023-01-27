<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Job\Application\Command\StoreJobPostCommand;
use App\Modules\Job\Application\Exception\JobNotFound;
use App\Modules\Job\Application\Factory\JobPostFactory;
use App\Modules\Job\Domain\Exception\JobDoesNotExist;
use App\Modules\Job\Domain\Repository\JobPostRepository;
use App\Modules\Job\Domain\Repository\JobRepository;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Shared\Application\Messenger\CommandHandler;

final class StoreJobPostCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly JobPostRepository $jobPostRepository,
        private readonly JobPostFactory $jobPostFactory,
        private readonly JobRepository $jobRepository
    ) {}

    public function __invoke(StoreJobPostCommand $command): string
    {
        $jobId = JobId::fromString($command->jobId);

        if (!$this->jobRepository->existsById($jobId)) {
            throw JobNotFound::withId($command->jobId);
        }

        $jobPost = $this->jobPostFactory->build($jobId, $command->jobPost);

        $this->jobPostRepository->store($jobPost);

        return $jobPost->getId()->toString();
    }
}

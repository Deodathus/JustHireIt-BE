<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Exception\UserDoesNotExist;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Billing\ModuleApi\Application\Query\DoesMemberBelongsToTeamQuery;
use App\Modules\Job\Application\Command\CloseJobPostCommand;
use App\Modules\Job\Application\Exception\JobCloserDoesNotExist;
use App\Modules\Job\Application\Exception\JobPostDoesNotBelongToJob;
use App\Modules\Job\Application\Exception\JobPostDoesNotExist as JobPostDoesNotExistDomain;
use App\Modules\Job\Application\Exception\OnlyOwnerCanCloseJob;
use App\Modules\Job\Domain\Exception\JobPostDoesNotExist;
use App\Modules\Job\Domain\Repository\JobPostRepository;
use App\Modules\Job\Domain\Repository\JobRepository;
use App\Modules\Job\Domain\ValueObject\JobCloserId;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class CloseJobPostCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly JobPostRepository $repository,
        private readonly QueryBus $queryBus,
        private readonly JobRepository $jobRepository
    ) {}

    public function __invoke(CloseJobPostCommand $command): void
    {
        try {
            $jobPost = $this->repository->fetch(JobPostId::fromString($command->jobPostId));
        } catch (JobPostDoesNotExist $exception) {
            throw JobPostDoesNotExistDomain::withId($command->jobPostId);
        }

        if (
            !$this->repository->jobPostBelongsToJob(
                JobId::fromString($command->jobId),
                JobPostId::fromString($command->jobPostId)
            )
        ) {
            throw JobPostDoesNotBelongToJob::withIds($command->jobId, $command->jobPostId);
        }

        try {
            $closerId = $this->queryBus->handle(new GetUserIdByTokenQuery($command->closerToken));

            $jobCloserId = JobCloserId::fromString($closerId);
        } catch (HandlerFailedException $exception) {
            if ($exception->getPrevious() instanceof UserDoesNotExist) {
                throw JobCloserDoesNotExist::withId($command->closerToken);
            }

            throw $exception;
        }

        $ownerId = $this->jobRepository->fetchOwnerId($jobPost->getJobId());

        if (!$this->queryBus->handle(new DoesMemberBelongsToTeamQuery($closerId, $ownerId->toString()))) {
            throw OnlyOwnerCanCloseJob::withId($closerId);
        }

        $jobPost->close($jobCloserId);

        $this->repository->close($jobPost);
    }
}

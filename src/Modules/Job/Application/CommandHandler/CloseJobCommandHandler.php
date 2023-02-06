<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Exception\UserDoesNotExist;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Billing\ModuleApi\Application\Query\DoesMemberBelongsToTeamQuery;
use App\Modules\Job\Application\Command\CloseJobCommand;
use App\Modules\Job\Application\Exception\JobCloserDoesNotExist;
use App\Modules\Job\Application\Exception\JobIsAlreadyClosed;
use App\Modules\Job\Application\Exception\JobNotFound;
use App\Modules\Job\Application\Exception\OnlyOwnerCanCloseJob;
use App\Modules\Job\Domain\Exception\JobDoesNotExist;
use App\Modules\Job\Domain\Repository\JobPostRepository;
use App\Modules\Job\Domain\Repository\JobRepository;
use App\Modules\Job\Domain\ValueObject\JobCloserId;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class CloseJobCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly JobRepository $jobRepository,
        private readonly JobPostRepository $jobPostRepository,
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(CloseJobCommand $command): void
    {
        $jobId = JobId::fromString($command->jobId);

        try {
            $job = $this->jobRepository->fetch(
                $jobId
            );
        } catch (JobDoesNotExist $exception) {
            throw JobNotFound::withId($jobId->toString(), $exception);
        }

        if ($job->isClosed()) {
            throw JobIsAlreadyClosed::withId($jobId->toString());
        }

        try {
            $closerId = $this->queryBus->handle(new GetUserIdByTokenQuery($command->token));

            $jobCloserId = JobCloserId::fromString($closerId);
        } catch (HandlerFailedException $exception) {
            if ($exception->getPrevious() instanceof UserDoesNotExist) {
                throw JobCloserDoesNotExist::withId($command->token);
            }

            throw $exception;
        }

        if (!$this->queryBus->handle(new DoesMemberBelongsToTeamQuery($closerId, $job->getCompanyId()->toString()))) {
            throw OnlyOwnerCanCloseJob::withId($closerId);
        }

        $job->close($jobCloserId);

        foreach ($job->getJobPosts() as $jobPost) {
            $jobPost->close($jobCloserId);

            $this->jobPostRepository->close($jobPost);
        }

        $this->jobRepository->close($job);
    }
}

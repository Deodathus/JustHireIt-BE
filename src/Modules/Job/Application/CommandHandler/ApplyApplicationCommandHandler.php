<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Job\Application\Command\ApplyApplicationCommand;
use App\Modules\Job\Application\Command\StoreApplicationFileCommand;
use App\Modules\Job\Application\DTO\FilePathDTO;
use App\Modules\Job\Application\Exception\ApplicantAlreadyAppliedOnThisJobPost;
use App\Modules\Job\Application\Exception\JobPostIsNotApplicable;
use App\Modules\Job\Domain\Entity\Application;
use App\Modules\Job\Domain\Exception\ApplicantAlreadyAppliedOnJobPost;
use App\Modules\Job\Domain\Exception\JobPostIsNotAvailable;
use App\Modules\Job\Domain\Service\ApplicationApplier;
use App\Modules\Job\Domain\Service\JobPostAvailabilityCheckerInterface;
use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\ApplicationId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\CommandHandler;

final class ApplyApplicationCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ApplicationApplier $applier,
        private readonly JobPostAvailabilityCheckerInterface $availabilityChecker,
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(ApplyApplicationCommand $command): string
    {
        $applicantId = ApplicantId::fromString($command->application->applicantId);
        $jobPostId = JobPostId::fromString($command->application->jobPostId);

        try {
            $this->availabilityChecker->check($applicantId, $jobPostId);
        } catch (JobPostIsNotAvailable $exception) {
            throw JobPostIsNotApplicable::withId($jobPostId, $exception);
        } catch (ApplicantAlreadyAppliedOnJobPost $exception) {
            throw ApplicantAlreadyAppliedOnThisJobPost::withIds($applicantId->toString(), $jobPostId->toString());
        }

        $id = ApplicationId::generate();

        $this->applier->apply(
            new Application(
                $id,
                $jobPostId,
                $applicantId,
                $command->application->introduction,
                $command->application->byGuest
            )
        );

        $this->commandBus->dispatch(
            new StoreApplicationFileCommand(
                $jobPostId,
                $id,
                $command->application->cvPath
            )
        );

        return $id->toString();
    }
}

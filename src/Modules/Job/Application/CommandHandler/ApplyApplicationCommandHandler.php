<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Job\Application\Command\ApplyApplicationCommand;
use App\Modules\Job\Application\Exception\JobPostIsNotApplicable;
use App\Modules\Job\Domain\Entity\Application;
use App\Modules\Job\Domain\Exception\JobPostIsNotAvailable;
use App\Modules\Job\Domain\Service\ApplicationApplier;
use App\Modules\Job\Domain\Service\JobPostAvailabilityCheckerInterface;
use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\ApplicationId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Shared\Application\Messenger\CommandHandler;

final class ApplyApplicationCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ApplicationApplier $applier,
        private readonly JobPostAvailabilityCheckerInterface $availabilityChecker
    ) {}

    public function __invoke(ApplyApplicationCommand $command): string
    {
        try {
            $this->availabilityChecker->check(JobPostId::fromString($command->application->jobPostId));
        } catch (JobPostIsNotAvailable $exception) {
            throw JobPostIsNotApplicable::withId($command->application->jobPostId, $exception);
        }

        $id = ApplicationId::generate();

        $this->applier->apply(
            new Application(
                $id,
                JobPostId::fromString($command->application->jobPostId),
                ApplicantId::fromString($command->application->applicantId),
                $command->application->introduction,
                $command->application->byGuest
            )
        );

        return $id->toString();
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Application;

use App\Modules\Job\Application\Command\ApplyApplicationCommand;
use App\Modules\Job\Application\Command\StoreApplicationFileCommand;
use App\Modules\Job\Application\CommandHandler\ApplyApplicationCommandHandler;
use App\Modules\Job\Application\DTO\ApplicationDTO;
use App\Modules\Job\Application\Exception\ApplicantAlreadyAppliedOnThisJobPost;
use App\Modules\Job\Application\Exception\JobPostIsNotApplicable;
use App\Modules\Job\Domain\Exception\ApplicantAlreadyAppliedOnJobPost;
use App\Modules\Job\Domain\Exception\JobPostIsNotAvailable;
use App\Tests\Modules\Job\Utils\ApplicationApplierStub;
use App\Tests\Modules\Job\Utils\JobPostAvailabilityCheckerSpy;
use App\Tests\Modules\Job\Utils\UploadedFileDummy;
use App\Tests\Modules\Utils\SharedInfrastructure\Messenger\CommandBusSpy;
use PHPUnit\Framework\TestCase;

final class ApplyApplicationCommandHandlerTest extends TestCase
{
    private const JOB_POST_ID = '1';
    private const APPLICANT_ID = '2';
    private const INTRODUCTION = 'Test introduction';
    private const BY_GUEST = false;

    /** @test */
    public function shouldApply(): void
    {
        $commandBus = new CommandBusSpy();
        $sut = new ApplyApplicationCommandHandler(
            new ApplicationApplierStub(),
            new JobPostAvailabilityCheckerSpy(),
            $commandBus
        );

        ($sut)(
            new ApplyApplicationCommand(
                new ApplicationDTO(
                    self::JOB_POST_ID,
                    self::APPLICANT_ID,
                    self::INTRODUCTION,
                    new UploadedFileDummy(),
                    self::BY_GUEST
                )
            )
        );

        $this->assertTrue(
            $commandBus->wasCommandDispatched(
                StoreApplicationFileCommand::class)
        );
    }

    /** @test */
    public function shouldNotApplyBecauseJobPostIsNotAvailable(): void
    {
        $commandBus = new CommandBusSpy();
        $jobPostAvailabilityChecker = new JobPostAvailabilityCheckerSpy();
        $sut = new ApplyApplicationCommandHandler(
            new ApplicationApplierStub(),
            $jobPostAvailabilityChecker,
            $commandBus
        );

        $jobPostAvailabilityChecker->makeNotAvailable(JobPostIsNotAvailable::withId(self::JOB_POST_ID));

        $this->expectException(JobPostIsNotApplicable::class);

        ($sut)(
            new ApplyApplicationCommand(
                new ApplicationDTO(
                    self::JOB_POST_ID,
                    self::APPLICANT_ID,
                    self::INTRODUCTION,
                    new UploadedFileDummy(),
                    self::BY_GUEST
                )
            )
        );
    }

    /** @test */
    public function shouldNotApplyBecauseCandidateAlreadyAppliedOnJobPost(): void
    {
        $commandBus = new CommandBusSpy();
        $jobPostAvailabilityChecker = new JobPostAvailabilityCheckerSpy();
        $sut = new ApplyApplicationCommandHandler(
            new ApplicationApplierStub(),
            $jobPostAvailabilityChecker,
            $commandBus
        );

        $jobPostAvailabilityChecker->makeNotAvailable(new ApplicantAlreadyAppliedOnJobPost());

        $this->expectException(ApplicantAlreadyAppliedOnThisJobPost::class);

        ($sut)(
            new ApplyApplicationCommand(
                new ApplicationDTO(
                    self::JOB_POST_ID,
                    self::APPLICANT_ID,
                    self::INTRODUCTION,
                    new UploadedFileDummy(),
                    self::BY_GUEST
                )
            )
        );
    }
}

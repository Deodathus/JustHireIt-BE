<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Application;

use App\Modules\Job\Application\Exception\JobNotFound;
use App\Modules\Job\Application\Query\GetJobQuery;
use App\Modules\Job\Application\QueryHandler\GetJobQueryHandler;
use App\Tests\Modules\Job\Utils\JobReadModelFake;
use App\Tests\Modules\Job\Utils\JobReadModelStub;
use PHPUnit\Framework\TestCase;

class GetJobQueryHandlerTest extends TestCase
{
    private const JOB_ID = '1';
    private const OWNER_ID = '2';
    private const NAME = 'Test name';
    private const JOB_POST_ID = '1';
    private const COMPANY_NAME = 'Test';
    private const JOB_POST_NAME = 'Test';
    private const JOB_POST_PROPERTY_TYPE = 'testPropertyType';
    private const JOB_POST_PROPERTY_VALUE = 'testPropertyValue';
    private const JOB_POST_REQUIREMENT_ID = '1';
    private const JOB_POST_REQUIREMENT_NAME = 'testRequirementName';

    /** @test */
    public function shouldReturnJob(): void
    {
        $sut = new GetJobQueryHandler(
            new JobReadModelFake()
        );

        $job = ($sut)(new GetJobQuery(self::JOB_ID));
        $jobPost = $job->jobPosts[0];
        $jobPostProperty = $jobPost->properties[0];
        $jobPostRequirement = $jobPost->requirements[0];

        $this->assertSame(self::JOB_ID, $job->id);
        $this->assertSame(self::OWNER_ID, $job->ownerId);
        $this->assertSame(self::NAME, $job->name);

        $this->assertSame(self::JOB_POST_ID, $jobPost->id);
        $this->assertSame(self::JOB_ID, $jobPost->jobId);
        $this->assertSame(self::COMPANY_NAME, $jobPost->companyName);
        $this->assertSame(self::JOB_POST_NAME, $jobPost->name);

        $this->assertSame(self::JOB_POST_PROPERTY_TYPE, $jobPostProperty->type);
        $this->assertSame(self::JOB_POST_PROPERTY_VALUE, $jobPostProperty->value);

        $this->assertSame(self::JOB_POST_REQUIREMENT_ID, $jobPostRequirement->requirementId);
        $this->assertSame(self::JOB_POST_REQUIREMENT_NAME, $jobPostRequirement->name);
    }

    /** @test */
    public function shouldThrowNotFoundException(): void
    {
        $sut = new GetJobQueryHandler(
            new JobReadModelStub()
        );

        $this->expectException(JobNotFound::class);

        ($sut)(new GetJobQuery(self::JOB_ID));
    }
}

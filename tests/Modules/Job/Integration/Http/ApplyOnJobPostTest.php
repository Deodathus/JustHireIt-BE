<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Integration\Http;

use App\Shared\Application\Service\FileUploader;
use App\Tests\Modules\Utils\Authentication\CreateUser;
use App\Tests\Modules\Utils\Job\ApplicationService;
use App\Tests\Modules\Utils\Job\JobPostService;
use App\Tests\Modules\Utils\Job\JobService;
use App\Tests\Modules\Utils\SharedInfrastructure\Service\FileUploaderDummy;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class ApplyOnJobPostTest extends WebTestCase
{
    private const API_URL = '/api/job/%s/jobPost/%s';
    private const APPLICANT_ID = '7794b83b-1bf4-4f98-8ce9-26334474c8e8';
    private const INTRODUCTION = "I'm very good developer!";
    private const IS_GUEST = false;

    /** @test */
    public function shouldNotApplyWithoutCV(): void
    {
        $client = self::createClient();

        $apiToken = CreateUser::createUser();
        $jobId = JobService::createJob($apiToken);
        $jobPostId = JobPostService::createJobPost($jobId);

        $client->request(
            Request::METHOD_POST,
            sprintf(self::API_URL, $jobId, $jobPostId),
            server: ['HTTP_X_AUTH_TOKEN' => $apiToken,],
            content: json_encode(
                [
                    'applicantId' => self::APPLICANT_ID,
                    'introduction' => self::INTRODUCTION,
                    'isGuest' => self::IS_GUEST,
                ]
            )
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function shouldApply(): void
    {
        $client = self::createClient();

        self::getContainer()->set(FileUploader::class, new FileUploaderDummy());

        $apiToken = CreateUser::createUser();
        $jobId = JobService::createJob($apiToken);
        $jobPostId = JobPostService::createJobPost($jobId);
        $cv = new UploadedFile(
            self::getContainer()->get(self::getKernelClass())->getProjectDir() . '/tests/storage/test_pdf.pdf',
            'test_pdf.pdf',
            'application/pdf'
        );

        $client->request(
            Request::METHOD_POST,
            sprintf(self::API_URL, $jobId, $jobPostId),
            parameters:
            [
                'applicantId' => self::APPLICANT_ID,
                'introduction' => self::INTRODUCTION,
                'isGuest' => self::IS_GUEST,
            ],
            files: [
                'cv' => $cv,
            ],
            server: ['HTTP_X_AUTH_TOKEN' => $apiToken,],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertTrue(ApplicationService::existsByIds($jobPostId, self::APPLICANT_ID));
    }
}

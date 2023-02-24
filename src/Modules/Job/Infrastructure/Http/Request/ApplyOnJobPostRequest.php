<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class ApplyOnJobPostRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $jobPostId,
        public readonly string $applicantId,
        public readonly string $introduction,
        public readonly UploadedFile $cv,
        public readonly bool $byGuest
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->request->all();

        $jobPostId = $request->attributes->get('jobPostId');
        $applicantId = $requestStack['applicantId'] ?? null;
        $introduction = $requestStack['introduction'] ?? null;
        $byGuest = $requestStack['byGuest'] ?? false;
        /** @var UploadedFile|null $cv */
        $cv = $request->files->get('cv');
        $cvType = $cv?->getMimeType();

        Assert::lazy()
            ->that($jobPostId, 'jobPostId')->uuid()->notEmpty()->maxLength(255)
            ->that($applicantId, 'applicantId')->uuid()->notEmpty()->maxLength(255)
            ->that($introduction, 'introduction')->string()->notEmpty()->maxLength(255)
            ->that($cv, 'cv')->notNull()->isInstanceOf(UploadedFile::class)
            ->that($cvType, 'fileExtension')->string()->notNull()->inArray([
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/pdf',
            ])
            ->that($byGuest, 'introduction')->boolean()
            ->verifyNow();

        return new self($jobPostId, $applicantId, $introduction, $cv, $byGuest);
    }

    public function toArray(): array
    {
        return [
            'jobPostId' => $this->jobPostId,
            'applicantId' => $this->applicantId,
            'introduction' => $this->introduction,
            'byGuest' => $this->byGuest,
            'cv' => $this->cv->getPath(),
        ];
    }
}

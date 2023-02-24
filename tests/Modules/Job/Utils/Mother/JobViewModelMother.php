<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils\Mother;

use App\Modules\Job\Application\ViewModel\JobPostPropertyViewModel;
use App\Modules\Job\Application\ViewModel\JobPostRequirementViewModel;
use App\Modules\Job\Application\ViewModel\JobPostViewModel;
use App\Modules\Job\Application\ViewModel\JobViewModel;
use App\Modules\Job\Domain\ValueObject\OwnerId;

final class JobViewModelMother
{
    public static function create(string $id): JobViewModel
    {
        return new JobViewModel(
            $id,
            '2',
            'Test name',
            [
                new JobPostViewModel(
                    '1',
                    '1',
                    'Test',
                    'Test',
                    [
                        new JobPostPropertyViewModel(
                            'testPropertyType',
                            'testPropertyValue'
                        )
                    ],
                    [
                        new JobPostRequirementViewModel(
                            '1',
                            'testRequirementName'
                        )
                    ]
                )
            ]
        );
    }
}

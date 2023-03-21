<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Enum;

enum JobPostPropertyTypes: string
{
    case DESCRIPTION = 'DESCRIPTION';
    case TEXT = 'TEXT';
    case HIGHEST_SALARY = 'HIGHEST_SALARY';
    case LOWEST_SALARY = 'LOWEST_SALARY';
    case CONTRACT_TYPE = 'CONTRACT_TYPE';
}

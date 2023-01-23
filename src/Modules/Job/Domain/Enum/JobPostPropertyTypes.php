<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Enum;

enum JobPostPropertyTypes: string
{
    case DESCRIPTION = 'DESCRIPTION';
    case TEXT = 'TEXT';
}

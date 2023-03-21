<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Entity;

use App\Modules\Billing\Domain\Enum\Features;

class Plan
{
    public const CANDIDATE_START_PLAN_FEATURES = [
        Features::JOB_POST_SEE,
        Features::JOB_SEE,
    ];

    public const RECRUITER_START_PLAN_FEATURES = [
        Features::JOB_CREATE,
        Features::JOB_EDIT,
        Features::JOB_CLOSE,
        Features::JOB_DELETE,
        Features::JOB_POST_CREATE,
        Features::JOB_POST_EDIT,
        Features::JOB_POST_CLOSE,
        Features::JOB_POST_DELETE,
        Features::JOB_POST_SEE,
        Features::JOB_SEE,
        Features::PANEL_ACCESS,
    ];
}

<?php

namespace App\Modules\Billing\Domain\Enum;

enum Features: string
{
    case JOB_CREATE = 'JOB_CREATE';
    case JOB_EDIT = 'JOB_EDIT';
    case JOB_DELETE = 'JOB_DELETE';
    case JOB_CLOSE = 'JOB_CLOSE';
    case JOB_POST_CREATE = 'JOB_POST_CREATE';
    case JOB_POST_EDIT = 'JOB_POST_EDIT';
    case JOB_POST_DELETE = 'JOB_POST_DELETE';
    case JOB_POST_CLOSE = 'JOB_POST_CLOSE';

    case PANEL_ACCESS = 'PANEL_ACCESS';

    case JOB_POST_SEE = 'JOB_POST_SEE';
    case JOB_SEE = 'JOB_SEE';
}

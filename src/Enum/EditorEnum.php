<?php

declare(strict_types=1);

namespace App\Enum;

enum EditorEnum: string
{
    case SO = 'so';

    case REP = 'rep';

    case CL = 'cl';

    public const CODES = ['so', 'cl', 'rep'];
}

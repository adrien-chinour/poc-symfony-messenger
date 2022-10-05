<?php

declare(strict_types=1);

namespace App\Mercure;

enum NotificationType: string
{
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case DANGER = 'danger';
    case WARNING = 'warning';
    case SUCCESS = 'success';
}

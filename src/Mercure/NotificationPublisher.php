<?php

declare(strict_types=1);

namespace App\Mercure;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

final class NotificationPublisher
{
    public function __construct(
        private readonly HubInterface $hub,
    ) {}

    public function publish(string $title, string $message, NotificationType $type = NotificationType::PRIMARY): void
    {
        $this->hub->publish(new Update(
            '/notifications',
            json_encode([
                'title' => $title,
                'message' => $message,
                'type' => $type->value
            ])
        ));
    }
}

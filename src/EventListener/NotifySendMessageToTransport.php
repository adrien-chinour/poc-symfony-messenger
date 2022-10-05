<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Mercure\NotificationPublisher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEventListener]
final class NotifySendMessageToTransport
{
    public function __construct(
        private readonly NotificationPublisher $publisher,
        private readonly SerializerInterface   $serializer,
    ) {}

    public function __invoke(SendMessageToTransportsEvent $event): void
    {
        $this->publisher->publish(
            'Message envoyé',
            sprintf("<code>%s</code>", $this->serializer->serialize($event->getEnvelope()->getMessage(), 'json'))
        );
    }
}

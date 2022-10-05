<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Mercure\NotificationPublisher;
use App\Mercure\NotificationType;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerStoppedEvent;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEventListener]
final class NotifyWorkerStopped
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly NotificationPublisher $publisher,
        private readonly SerializerInterface   $serializer
    ) {}

    public function __invoke(WorkerStoppedEvent $event): void
    {
        $this->publisher->publish(
            'Worker arrêté !',
            sprintf("<code>%s</code>", $this->serializer->serialize($event->getWorker()->getMetadata(), 'json')),
            NotificationType::WARNING
        );
    }
}

<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Mercure\TurboStreamPublisher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsEventListener]
final class NotifyWorkerMessageHandled
{
    private const NOTIFICATION_TEMPLATE = '_partials/streams/messenger-message.stream.html.twig';

    public function __construct(
        private readonly TurboStreamPublisher $publisher,
        private readonly NormalizerInterface  $normalizer
    ) {}

    public function __invoke(WorkerMessageHandledEvent $event): void
    {
        $this->publisher->publish('/messages', self::NOTIFICATION_TEMPLATE, [
            'date' => new \DateTime(),
            'queue' => $event->getReceiverName(),
            'class' => get_class($event->getEnvelope()->getMessage()),
            'data' => $this->normalizer->normalize($event->getEnvelope()->getMessage()),
            'status' => 'success'
        ]);
    }
}

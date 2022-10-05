<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Mercure\TurboStreamPublisher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsEventListener]
final class NotifyWorkerMessageFailed
{
    private const NOTIFICATION_TEMPLATE = '_partials/streams/messenger-message.stream.html.twig';

    public function __construct(
        private readonly TurboStreamPublisher $publisher,
        private readonly NormalizerInterface  $normalizer
    ) {}

    public function __invoke(WorkerMessageFailedEvent $event): void
    {
        $data = $this->normalizer->normalize($event->getEnvelope()->getMessage());
        $data['error'] = $event->getThrowable()->getMessage();

        $this->publisher->publish('/messages', self::NOTIFICATION_TEMPLATE, [
            'date' => new \DateTime(),
            'queue' => $event->getReceiverName(),
            'class' => get_class($event->getEnvelope()->getMessage()),
            'data' => $data,
            'status' => 'failed'
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Messenger\EventSubscriber;

use App\Messenger\Event\ArticlePublished;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class SitemapGenerator implements LoggerAwareInterface, MessageSubscriberInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly string              $projectDir
    ) {}

    public function __invoke(ArticlePublished $event): void
    {
        $this->logger->warning("SitemapGenerator run.");
        //throw new \RuntimeException();
    }

    public static function getHandledMessages(): iterable
    {
        return [
            ArticlePublished::class
        ];
    }
}

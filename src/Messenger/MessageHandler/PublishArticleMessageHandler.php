<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Entity\Article;
use App\Messenger\Event\ArticlePublished;
use App\Messenger\Message\PublishArticleMessage;
use App\Repository\ArticleRepository;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PublishArticleMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly ValidatorInterface  $validator,
        private readonly ArticleRepository   $repository,
        private readonly MessageBusInterface $bus
    ) {}

    public function __invoke(PublishArticleMessage $message): void
    {
        if (0 !== $this->validator->validate($message)->count()) {
            throw new \InvalidArgumentException('Message failed validation.');
        }

        $article = (new Article())->setId($message->id)->setUrl($message->url)->setEditor($message->editor);
        $this->repository->save($article);

        $this->bus->dispatch(
            (new Envelope(new ArticlePublished($article)))->with(new DispatchAfterCurrentBusStamp())
        );
    }
}

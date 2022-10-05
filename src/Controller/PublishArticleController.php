<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\EditorEnum;
use App\Messenger\Message\PublishArticleMessage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/publish/{type}', name: 'publish_article', defaults: ['type' => 'success'])]
final class PublishArticleController
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {}

    public function __invoke(string $type): Response
    {
        $this->bus->dispatch(new PublishArticleMessage(
            random_int(100_000, 999_999),
            sprintf("https://example.com/%s", uniqid()),
            $type === 'success' ? EditorEnum::SO->value : 'ko'
        ));

        return new Response();
    }
}

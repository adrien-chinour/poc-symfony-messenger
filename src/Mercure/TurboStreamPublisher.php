<?php

declare(strict_types=1);

namespace App\Mercure;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Twig\Environment;

final class TurboStreamPublisher
{
    public function __construct(
        private readonly HubInterface $hub,
        private readonly Environment  $twig,
    ) {}

    public function publish(string $topic, string $template, array $data = []): void
    {
        $this->hub->publish(new Update(
            $topic,
            $this->twig->render($template, $data)
        ));
    }
}

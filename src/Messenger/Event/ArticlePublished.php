<?php

declare(strict_types=1);

namespace App\Messenger\Event;

use App\Entity\Article;

final class ArticlePublished
{
    public function __construct(
        public readonly Article $article,
    ) {}
}

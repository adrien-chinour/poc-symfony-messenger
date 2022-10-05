<?php

namespace App\Messenger\Message;

use App\Enum\EditorEnum;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Url;

final class PublishArticleMessage
{
    public readonly int $id;

    #[Url]
    public readonly string $url;

    #[Choice(EditorEnum::CODES)]
    public readonly string $editor;

    public function __construct(int $id, string $url, string $editor)
    {
        $this->id = $id;
        $this->url = $url;
        $this->editor = $editor;
    }
}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EditorEnum;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Url;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
final class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column]
    private ?int $id = null;

    #[Url]
    #[ORM\Column(length: 1023)]
    private ?string $url = null;

    #[Choice(EditorEnum::CODES)]
    #[ORM\Column(length: 255)]
    private ?string $editor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }
}

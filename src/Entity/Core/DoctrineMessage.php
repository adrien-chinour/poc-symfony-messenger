<?php

declare(strict_types=1);

namespace App\Entity\Core;

use Symfony\Component\Messenger\Envelope;

class DoctrineMessage
{
    private int $id;

    private Envelope $envelope;

    private \DateTime $createdAt;

    private ?\DateTime $availableAt;

    private ?\DateTime $deliveredAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEnvelope(): Envelope
    {
        return $this->envelope;
    }

    public function setEnvelope(Envelope $envelope): void
    {
        $this->envelope = $envelope;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime|string $createdAt): void
    {
        if (is_string($createdAt)) {
            $createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', $createdAt) ?: null;
        }

        $this->createdAt = $createdAt;
    }

    public function getAvailableAt(): ?\DateTime
    {
        return $this->availableAt;
    }

    public function setAvailableAt(null|\DateTime|string $availableAt): void
    {
        if (is_string($availableAt)) {
            $availableAt = \DateTime::createFromFormat('Y-m-d H:i:s', $availableAt) ?: null;
        }

        $this->availableAt = $availableAt;
    }

    public function getDeliveredAt(): ?\DateTime
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(null|\DateTime|string $deliveredAt): void
    {
        if (is_string($deliveredAt)) {
            $deliveredAt = \DateTime::createFromFormat('Y-m-d H:i:s', $deliveredAt) ?: null;
        }

        $this->deliveredAt = $deliveredAt;
    }
}

<?php

declare(strict_types=1);

namespace App\Repository\Core;

use App\Entity\Core\DoctrineMessage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DoctrineMessageRepository implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly Connection          $connection,
        private readonly SerializerInterface $serializer,
        private readonly NormalizerInterface $normalizer
    ) {}

    /**
     * @param string $transport
     * @param int $limit
     * @return Collection<DoctrineMessage>
     */
    public function findByTransport(string $transport, int $limit = 10): Collection
    {
        try {
            $statement = $this->connection->prepare('select * from messenger_messages where queue_name = :queue limit :limit');
            $statement->bindValue(':queue', $transport);
            $statement->bindValue(':limit', $limit);

            return (new ArrayCollection($statement->executeQuery()->fetchAllAssociative()))->map(fn($item) => $this->mapEntity($item));

        } catch (Exception $e) {
            $this->logger?->critical($e->getMessage());

            return new ArrayCollection();
        }
    }

    private function mapEntity(array $item): DoctrineMessage
    {
        $message = new DoctrineMessage();
        $message->setId($item['id'] ?? null);
        $message->setCreatedAt($item['created_at'] ?? new \DateTime());
        $message->setAvailableAt($item['available_at'] ?? null);
        $message->setDeliveredAt($item['delivered_at'] ?? null);
        $message->setEnvelope($this->serializer->decode([
            'body' => $item['body'],
            'headers' => $item['headers'],
        ]));

        return $message;
    }
}

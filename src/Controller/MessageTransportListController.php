<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Core\DoctrineMessage;
use App\Repository\Core\DoctrineMessageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsController]
#[Route('/messages/{transport}', defaults: ['transport' => 'main'])]
final class MessageTransportListController
{
    public function __construct(
        private readonly DoctrineMessageRepository $repository,
        private readonly NormalizerInterface       $normalizer
    ) {}

    public function __invoke(string $transport): Response
    {
        $messages = $this->repository->findByTransport($transport);

        if (false === $messages->isEmpty()) {
            $messages = $messages->map(fn(DoctrineMessage $message) => $this->normalizer->normalize($message));
        }

        return new JsonResponse($messages->toArray());
    }
}

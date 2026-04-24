<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class HttpExceptionListener
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof HttpExceptionInterface) {
            /** @var HttpExceptionInterface $exception */
            $exception = $event->getThrowable();

            $json = $this->serializer->serialize(['exception' => $exception], JsonEncoder::FORMAT);

            $response = new JsonResponse($json, $exception->getStatusCode(), [], true);
            $response->headers->replace($exception->getHeaders());
            $response->headers->set('Content-Type', 'application/problem+json');

            $event->setResponse($response);
        }
    }
}

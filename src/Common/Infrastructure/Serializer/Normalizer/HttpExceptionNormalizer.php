<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Serializer\Normalizer;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class HttpExceptionNormalizer implements NormalizerInterface
{
    /**
     * @param HttpExceptionInterface $object
     *
     * @return array<string, mixed>
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return [
            'message' => $object->getMessage(),
            'code' => $object->getStatusCode(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof HttpExceptionInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [HttpExceptionInterface::class => true];
    }
}

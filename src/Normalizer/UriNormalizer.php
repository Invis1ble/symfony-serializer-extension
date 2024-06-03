<?php

declare(strict_types=1);

namespace Invis1ble\SymfonySerializerExtension\Normalizer;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UriNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(protected readonly UriFactoryInterface $uriFactory)
    {
    }

    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = [],
    ): string {
        return (string) $object;
    }

    public function supportsNormalization(
        mixed $data,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $data instanceof UriInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Uri::class => true,
            UriInterface::class => true,
        ];
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): UriInterface {
        return $this->uriFactory->createUri($data);
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return in_array($type, [
            Uri::class,
            UriInterface::class,
        ], true);
    }
}

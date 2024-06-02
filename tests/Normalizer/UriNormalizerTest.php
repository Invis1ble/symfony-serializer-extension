<?php

declare(strict_types=1);

namespace Invis1ble\SymfonySerializerExtension\Tests\Normalizer;

use Invis1ble\SymfonySerializerExtension\Normalizer\UriNormalizer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class UriNormalizerTest extends TestCase
{
    private readonly UriNormalizer $normalizer;

    private readonly UriInterface $uri;

    private readonly UriFactoryInterface $uriFactory;

    protected function setUp(): void
    {
        $this->uri = $this->createMock(UriInterface::class);
        $this->uriFactory = $this->createMock(UriFactoryInterface::class);
        $this->normalizer = new UriNormalizer($this->uriFactory);
    }

    public function testNormalize(): void
    {
        $this->uri->expects($this->once())
            ->method('__toString')
            ->willReturn('https://example.com');

        $result = $this->normalizer->normalize($this->uri);

        $this->assertSame('https://example.com', $result);
    }

    public function testSupportsNormalization(): void
    {
        $this->assertTrue($this->normalizer->supportsNormalization($this->uri));
        $this->assertFalse($this->normalizer->supportsNormalization(new \stdClass()));
    }

    public function testGetSupportedTypes(): void
    {
        $supportedTypes = $this->normalizer->getSupportedTypes(null);

        $this->assertArrayHasKey(UriInterface::class, $supportedTypes);
        $this->assertTrue($supportedTypes[UriInterface::class]);
    }

    public function testDenormalize(): void
    {
        $this->uriFactory->expects($this->once())
            ->method('createUri')
            ->with('https://example.com')
            ->willReturn($this->uri);

        $result = $this->normalizer->denormalize('https://example.com', UriInterface::class);

        $this->assertSame($this->uri, $result);
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->normalizer->supportsDenormalization(null, UriInterface::class));
        $this->assertFalse($this->normalizer->supportsDenormalization(null, \stdClass::class));
    }
}

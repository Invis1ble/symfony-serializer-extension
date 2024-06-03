<?php

declare(strict_types=1);

namespace Invis1ble\SymfonySerializerExtension\Tests\Normalizer;

use GuzzleHttp\Psr7\Uri;
use Invis1ble\SymfonySerializerExtension\Normalizer\UriNormalizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class UriNormalizerTest extends TestCase
{
    private readonly UriNormalizer $normalizer;

    private readonly UriFactoryInterface $uriFactory;

    protected function setUp(): void
    {
        $this->uriFactory = $this->createMock(UriFactoryInterface::class);
        $this->normalizer = new UriNormalizer($this->uriFactory);
    }

    #[DataProvider('provideSupportedType')]
    public function testNormalize(string $fqn): void
    {
        $uri = $this->createMock($fqn);

        $uri->expects($this->once())
            ->method('__toString')
            ->willReturn('https://example.com');

        $result = $this->normalizer->normalize($uri);

        $this->assertSame('https://example.com', $result);
    }

    #[DataProvider('provideSupportedType')]
    public function testSupportsNormalization(string $fqn): void
    {
        $uri = $this->createMock($fqn);

        $this->assertTrue($this->normalizer->supportsNormalization($uri));
    }

    #[DataProvider('provideNotSupportedType')]
    public function testDoesNotSupportNormalization(string $fqn): void
    {
        $uri = $this->createMock($fqn);

        $this->assertFalse($this->normalizer->supportsNormalization($uri));
    }

    #[DataProvider('provideSupportedType')]
    public function testGetSupportedTypes(string $fqn): void
    {
        $supportedTypes = $this->normalizer->getSupportedTypes(null);

        $this->assertArrayHasKey($fqn, $supportedTypes);
        $this->assertTrue($supportedTypes[$fqn]);
    }

    #[DataProvider('provideSupportedType')]
    public function testDenormalize(string $fqn): void
    {
        $uri = $this->createMock($fqn);

        $this->uriFactory->expects($this->once())
            ->method('createUri')
            ->with('https://example.com')
            ->willReturn($uri);

        $result = $this->normalizer->denormalize('https://example.com', $fqn);

        $this->assertSame($uri, $result);
    }

    #[DataProvider('provideSupportedType')]
    public function testSupportsDenormalization(string $fqn): void
    {
        $this->assertTrue($this->normalizer->supportsDenormalization(null, $fqn));
    }

    #[DataProvider('provideNotSupportedType')]
    public function testDoeNotSupportDenormalization(string $fqn): void
    {
        $this->assertFalse($this->normalizer->supportsDenormalization(null, $fqn));
    }

    public static function provideSupportedType(): iterable
    {
        yield [Uri::class];
        yield [UriInterface::class];
    }

    public static function provideNotSupportedType(): iterable
    {
        yield [\stdClass::class];
    }
}

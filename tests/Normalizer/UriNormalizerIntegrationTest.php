<?php

declare(strict_types=1);

namespace Invis1ble\SymfonySerializerExtension\Tests\Normalizer;

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Uri;
use Invis1ble\SymfonySerializerExtension\Normalizer\UriNormalizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Serializer;

class UriNormalizerIntegrationTest extends TestCase
{
    #[DataProvider('provideRoundTrip')]
    public function testRoundTrip(string $value, string $type): void
    {
        $serializer = new Serializer([new UriNormalizer(new HttpFactory())], [new JsonEncoder()]);

        foreach ([[], ['custom_option' => true]] as $context) {
            $uri = new Uri($value);
            $this->assertSame($value, $serializer->normalize($uri, null, $context));
            $this->assertSame($value, (string) $serializer->denormalize($value, $type, null, $context));

            $json = $serializer->serialize($uri, 'json', $context);
            $this->assertSame($value, json_decode($json, true, 512, JSON_THROW_ON_ERROR));

            $restored = $serializer->deserialize($json, $type, 'json', $context);
            $this->assertInstanceOf($type, $restored);
            $this->assertSame($value, (string) $restored);
        }
    }

    #[DataProvider('provideInvalidData')]
    public function testNonStringDataIsRejectedAfterCachingSupport(mixed $data): void
    {
        $serializer = new Serializer([new UriNormalizer(new HttpFactory())]);
        $serializer->denormalize('https://example.com', UriInterface::class);

        $this->expectException(\TypeError::class);

        $serializer->denormalize($data, UriInterface::class);
    }

    public function testInvalidUriIsRejectedByTheFactory(): void
    {
        $serializer = new Serializer([new UriNormalizer(new HttpFactory())]);

        $this->expectException(\InvalidArgumentException::class);

        $serializer->denormalize('https://example.com:99999', UriInterface::class);
    }

    public function testUnsupportedObjectCannotBeNormalized(): void
    {
        $serializer = new Serializer([new UriNormalizer(new HttpFactory())]);

        $this->expectException(NotNormalizableValueException::class);

        $serializer->normalize(new \stdClass());
    }

    public function testUnsupportedTypeCannotBeDenormalized(): void
    {
        $serializer = new Serializer([new UriNormalizer(new HttpFactory())]);

        $this->expectException(NotNormalizableValueException::class);

        $serializer->denormalize('https://example.com', \stdClass::class);
    }

    public static function provideRoundTrip(): iterable
    {
        foreach ([UriInterface::class, Uri::class] as $type) {
            foreach (['https://user:pass@example.com:8443/path?query=value#fragment', '/relative/path?query=value', ''] as $value) {
                yield [$value, $type];
            }
        }
    }

    public static function provideInvalidData(): iterable
    {
        yield [null];
        yield [42];
        yield [false];
        yield [[]];
        yield [new \stdClass()];
    }
}

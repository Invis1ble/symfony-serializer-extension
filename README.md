Symfony Serializer Extension
============================

![CI Status](https://github.com/Invis1ble/symfony-serializer-extension/actions/workflows/ci.yml/badge.svg?event=push)
[![Code Coverage](https://codecov.io/gh/Invis1ble/symfony-serializer-extension/graph/badge.svg?token=6UQDPQ9ZO7)](https://codecov.io/gh/Invis1ble/symfony-serializer-extension)
[![Packagist](https://img.shields.io/packagist/v/Invis1ble/symfony-serializer-extension.svg)](https://packagist.org/packages/Invis1ble/symfony-serializer-extension)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)

A useful set of additional (de)normalizers for [symfony/serializer](https://github.com/symfony/serializer):

- `UriNormalizer` for normalizing objects implementing `Psr\Http\Message\UriInterface`

Requirements
------------

Version 1.2 adds Symfony Serializer 8 support without changing the normalizer API
or dropping compatibility with earlier supported versions:

| Symfony Serializer | Minimum PHP version |
| --- | --- |
| 6.4 | 8.1 |
| 7.x | 8.2 |
| 8.x | 8.4.1 |

Both PSR-7 1.1 and 2.x are supported. Provide a PSR-17 `UriFactoryInterface`
implementation when constructing the normalizer. Guzzle is optional at runtime.

Installation
------------

To install this package, you can use Composer:

```sh
composer require invis1ble/symfony-serializer-extension
```

or just add it as a dependency in your `composer.json` file:

```json

{
    "require": {
        "invis1ble/symfony-serializer-extension": "^1.2"
    }
}
```

After adding the above line, run the following command to install the package:

```sh
composer install
```


Usage
-----------

Currently implemented `UriNormalizer` only.

This normalizer is designed for normalizing `Uri` objects implementing the `Psr\Http\Message\UriInterface`.

Read the official [documentation for the Serializer](https://symfony.com/doc/current/components/serializer.html#usage) component to use normalizers.

```php
use Invis1ble\SymfonySerializerExtension\Normalizer\UriNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

$encoders = [new XmlEncoder(), new JsonEncoder()];
$normalizers = [new UriNormalizer($uriFactory)];

$serializer = new Serializer($normalizers, $encoders);
```

Normalization accepts any `UriInterface` implementation. Denormalization supports
`UriInterface` and `GuzzleHttp\Psr7\Uri` declarations and returns the object created
by the injected factory. To use the concrete Guzzle type, inject a factory that
returns that implementation, such as `GuzzleHttp\Psr7\HttpFactory`.

The normalizer is independent of format and context. URI strings, including empty
and relative URIs, are passed to the factory unchanged. Non-string denormalization
input raises `TypeError`; invalid URI syntax is rejected according to the factory's
validation rules. Support checks describe the supported types and do not validate
the input URI.

To update an existing installation:

```sh
composer require invis1ble/symfony-serializer-extension:^1.2 --with-all-dependencies
```


Development
-----------

### Getting started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up -d --wait` to start the Docker containers
4. Run `docker compose exec php composer install` to install dependencies
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

Development uses PHP 8.4 by default. Set `PHP_VERSION` consistently for Compose
commands to select another version, for example `PHP_VERSION=8.2 docker compose
build`. CI tests Symfony 6.4 on PHP 8.1, Symfony 7 on PHP 8.2, and Symfony 8 on PHP
8.4 and 8.5, including both supported PSR-7 major versions. Development dependencies
use stable releases; PHPUnit's compatible major is selected for the PHP version.

### Check for Coding Standards violations

Run PHP_CodeSniffer checks:

```sh
docker compose exec -it php bin/php_codesniffer
```

Run PHP-CS-Fixer checks:

```sh
docker compose exec -it php bin/php-cs-fixer
```

Run Rector checks:

```sh
docker compose exec -it php bin/rector
```


Testing
-------

To run Unit tests during development

```sh
docker compose exec php vendor/bin/phpunit
```

To run with coverage

```sh
XDEBUG_MODE=coverage docker compose up -d --wait
docker compose exec php vendor/bin/phpunit --coverage-clover var/log/coverage-clover.xml
```


License
-------

[The MIT License](./LICENSE)

Symfony Serializer Extension
============================

![CI Status](https://github.com/Invis1ble/symfony-serializer-extension/actions/workflows/ci.yml/badge.svg?event=push)
[![Code Coverage](https://codecov.io/gh/Invis1ble/symfony-serializer-extension/graph/badge.svg?token=AQRIP417A4)](https://codecov.io/gh/Invis1ble/symfony-serializer-extension)
[![Packagist](https://img.shields.io/packagist/v/Invis1ble/symfony-serializer-extension.svg)](https://packagist.org/packages/Invis1ble/symfony-serializer-extension)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)

A useful set of additional (de)normalizers for [symfony/serializer](https://github.com/symfony/serializer)

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
        "invis1ble/symfony-serializer-extension": "^1.0"
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
$normalizers = [new UriNormalizer()];

$serializer = new Serializer($normalizers, $encoders);
```


Development
-----------

### Getting started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up -d --wait` to start the Docker containers
4. Run `docker compose exec php composer install` to install dependencies
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

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

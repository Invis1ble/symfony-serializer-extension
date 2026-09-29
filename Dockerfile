ARG PHP_VERSION=8.4
FROM php:${PHP_VERSION}-cli-bookworm

ENV XDEBUG_MODE=off

RUN apt-get update && apt-get install -y --no-install-recommends \
      git=1:2.39.* \
      unzip=6.0-* \
    && rm -rf /var/lib/apt/lists/*

RUN bash -c '[[ -n "$(pecl list | grep xdebug)" ]]\
 || (pecl install xdebug-3.5.3 && docker-php-ext-enable xdebug)'

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY . .

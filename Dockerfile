FROM php:8.2-cli

ENV XDEBUG_MODE=off

RUN apt-get update && apt-get install -y --no-install-recommends \
      git=1:2.39.2-1.1 \
      unzip=6.0-28 \
    && rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY . .

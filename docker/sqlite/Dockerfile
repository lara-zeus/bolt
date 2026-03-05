FROM php:8.3-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN apk add --no-progress --no-cache \
    curl-dev \
    libpng-dev \
    libzip-dev \
    icu-dev

RUN docker-php-ext-install \
    curl \
    gd \
    intl \
    zip

RUN composer install

COPY . .

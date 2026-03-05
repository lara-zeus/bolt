FROM php:8.3-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN apk add --no-progress --no-cache \
    curl-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    postgresql-dev \
    libpq

RUN docker-php-ext-install \
    curl \
    gd \
    intl \
    zip \
    pdo_pgsql
    
WORKDIR /app

RUN apk add --update linux-headers

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY docker/xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

RUN composer install

COPY . .

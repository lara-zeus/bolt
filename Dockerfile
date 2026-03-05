FROM php:8.3-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-progress --no-cache \
    curl-dev \
    libpng-dev \
    libzip-dev \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install \
    curl \
    gd \
    intl \
    zip

WORKDIR /app

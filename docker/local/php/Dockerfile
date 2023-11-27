FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
        libzip-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-enable pdo_mysql


ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy or pull composer and add it to the image/container we are building
# This method is like adding to cart a toppings to our PHP Image
COPY --from=composer/composer:2.5.8 /usr/bin/composer /usr/bin/composer

# Copy composer to working directory
COPY ./src/composer.* ./

# Install the composer
RUN composer install --no-scripts --no-progress --no-interaction
# --prefer-dist --no-dev 
# Copy application files to the working directory
COPY ./src .

RUN composer dump-autoload --optimize

# RUN chmod -R 777 /storage/logs/*

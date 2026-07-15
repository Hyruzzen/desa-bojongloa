# syntax=docker/dockerfile:1

#########################
# Build Frontend Assets #
#########################
FROM node:22-alpine AS node

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .

RUN npm run build

########################
# PHP + FrankenPHP     #
########################
FROM dunglas/frankenphp:1-php8.3

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    tesseract-ocr \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

COPY --from=node /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

COPY Caddyfile /etc/caddy/Caddyfile

ENV SERVER_NAME=:8080

EXPOSE 8080
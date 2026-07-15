# ==========================
# Stage 1 - Build Vite Assets
# ==========================
FROM node:22-alpine AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build

# ==========================
# Stage 2 - Laravel + FrankenPHP
# ==========================
FROM dunglas/frankenphp:1-php8.3

WORKDIR /app

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    tesseract-ocr \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy source
COPY . .

# Install dependency PHP
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Copy hasil build Vite
COPY --from=node /app/public/build ./public/build

# Permission
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

ENV APP_ENV=production

EXPOSE 8080

CMD ["frankenphp", "php-server", "--root", "/app/public", "--listen", ":8080"]
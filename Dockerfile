# =========================
# Base PHP
# =========================

FROM php:8.4-fpm AS base

WORKDIR /var/www/html


RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    default-mysql-client \
    libpng-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        intl \
        zip \
        gd \
    && rm -rf /var/lib/apt/lists/*


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer



# =========================
# Composer dependencies
# =========================

FROM base AS vendor


WORKDIR /var/www/html


COPY composer.json composer.lock ./


RUN composer config -g process-timeout 2000 \
    && composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --no-progress \
        --optimize-autoloader \
        --no-scripts



# =========================
# Frontend build
# =========================

FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install

COPY . .


RUN npm run build



# =========================
# Final image
# =========================

FROM base AS app


WORKDIR /var/www/html


COPY . .


COPY --from=vendor \
    /var/www/html/vendor \
    ./vendor


COPY --from=frontend \
    /app/public/build \
    ./public/build



RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache


RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache



EXPOSE 9000


CMD ["php-fpm"]

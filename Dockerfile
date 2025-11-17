# ──────────────────────────────────────────────────────────────
#  Laravel + PHP 8.2 FPM (Debian) – works on Render, Railway, Fly.io
# ──────────────────────────────────────────────────────────────
FROM php:8.2-fpm

# 1. Set working directory
WORKDIR /var/www/html

# 2. Install system packages + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 3. Install Composer (official image)
COPY --from=composer/composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copy only composer files first (better layer caching)
COPY composer.json composer.lock ./

# 5. Install PHP dependencies (production only)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist \
    && composer dump-autoload --optimize --classmap-authoritative

# 6. Copy the rest of the app
COPY . .

# 7. Generate autoloader & optimize
RUN composer install --optimize-autoloader --no-dev

# 8. Permissions (Laravel needs this)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# 9. Expose port (FPM listens on 9000)
EXPOSE 9000

# 10. Start php-fpm
CMD ["php-fpm"]

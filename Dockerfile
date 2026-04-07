FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libssl-dev \
    && pecl install mongodb-1.21.0 \
    && docker-php-ext-enable mongodb \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=$PORT

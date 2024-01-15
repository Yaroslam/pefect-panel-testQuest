# Dockerfile
FROM php:8.1

RUN apt-get update -y && apt-get install -y libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo zip

WORKDIR /app
COPY . /app

RUN composer install
RUN composer dumpautoload

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

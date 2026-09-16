FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git unzip libzip-dev libpng-dev libonig-dev libicu-dev zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl intl gd \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

CMD ["php-fpm"]

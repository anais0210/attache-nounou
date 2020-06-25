FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev libzip-dev zip git && docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-configure zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/project
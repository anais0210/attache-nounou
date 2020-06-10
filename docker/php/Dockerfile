FROM php:7.3-fpm

RUN curl -OL https://github.com/composer/composer/releases/download/1.72/composer.phar && \ 
mv composer.phar /usr/local/bin/composer && \
chmod +x /usr/local/bin/composer

WORKDIR /var/www/attache-nounou
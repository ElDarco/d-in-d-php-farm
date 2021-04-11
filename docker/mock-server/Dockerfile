FROM php:8.0-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    && docker-php-ext-install -j$(nproc) iconv sockets pcntl intl bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --version 2.0.2 --install-dir=/usr/local/bin --filename=composer

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

WORKDIR /var/www

CMD ["php-fpm"]

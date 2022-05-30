FROM php:8.0-fpm-alpine

RUN apk update && apk upgrade \
    && apk add --no-cache bash git openssh unzip icu-dev curl-dev pkgconfig openssl-dev \
    && apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && docker-php-ext-install -j$(nproc) sockets pdo_mysql mysqli pcntl intl bcmath \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apk del pcre-dev ${PHPIZE_DEPS}

RUN curl -sS https://getcomposer.org/installer | php -- --version 2.0.2 --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

COPY docker/mock-server/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/mock-server/php.ini /usr/local/etc/php/conf.d/00-php.ini

COPY src/backend-mock-server /var/www

WORKDIR /var/www

#clear vendor if exist
RUN rm -rf vendor

RUN composer install

CMD ["php-fpm"]

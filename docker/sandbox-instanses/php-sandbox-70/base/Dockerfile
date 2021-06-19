FROM php:7.0-fpm-alpine

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install xhprof-beta \
    && docker-php-ext-enable xhprof \
    && apk del pcre-dev ${PHPIZE_DEPS}

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY php.ini /usr/local/etc/php/conf.d/00-php.ini

WORKDIR /var/www

CMD ["php-fpm"]

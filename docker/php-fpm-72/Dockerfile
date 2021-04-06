FROM php:7.2-fpm

RUN pecl install xhprof-beta && docker-php-ext-enable xhprof

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

WORKDIR /var/www

CMD ["php-fpm"]

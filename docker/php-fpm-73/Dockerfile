FROM php:7.3-fpm

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

RUN mkdir -p /var/log/php-fpm

WORKDIR /var/www

CMD ["php-fpm"]

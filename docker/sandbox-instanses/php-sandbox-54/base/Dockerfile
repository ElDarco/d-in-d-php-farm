FROM php:5.4-fpm

COPY docker-php-pecl-install /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-php-pecl-install
RUN docker-php-pecl-install xhprof-0.9.4

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY php.ini /usr/local/etc/php/conf.d/00-php.ini

WORKDIR /var/www

CMD ["php-fpm"]

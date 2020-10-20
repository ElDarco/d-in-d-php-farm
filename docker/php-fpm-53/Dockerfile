FROM devilbox/php-fpm-5.3

RUN mkdir -p /var/log/php-fpm
RUN ln -sf /dev/stdout /var/log/php-fpm/access.log
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

WORKDIR /var/www

CMD ["php-fpm"]

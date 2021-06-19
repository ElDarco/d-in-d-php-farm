FROM eldarco/code-try:php-hub-base

COPY src/backend-php-hub /var/www

WORKDIR /var/www

#clear vendor if exist
RUN rm -rf vendor

RUN composer install

CMD ["php-fpm"]
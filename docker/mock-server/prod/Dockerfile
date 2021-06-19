FROM eldarco/code-try:mock-server-base

COPY src/backend-mock-server /var/www

WORKDIR /var/www

#clear vendor if exist
RUN rm -rf vendor

RUN composer install

CMD ["php-fpm"]
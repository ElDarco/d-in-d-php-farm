FROM eldarco/code-try:entrypoint-base

COPY src/backend-php-sandbox /var/www/backend-php-sandbox
COPY src/backend-php-hub /var/www/backend-php-hub
COPY src/backend-mock-server /var/www/backend-mock-server
COPY docker/entrypoint/prod/templates /etc/nginx/templates

CMD ["nginx", "-g", "daemon off;"]
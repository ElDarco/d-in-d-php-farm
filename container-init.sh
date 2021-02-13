#!/usr/bin/env sh

if ! /usr/bin/env docker-compose exec -T php-fpm-53 php install.php http://codetry/php-fpm-53/index.php; then
    echo "Running php init.sh failed"
    exit 1;
fi;

if ! /usr/bin/env docker-compose exec -T php-hub /var/www/init.sh; then
    echo "Running php init.sh failed"
    exit 1;
fi;

if ! /usr/bin/env docker-compose exec -T nodejs /entripont.sh; then
    echo "Running nodejs prod-entripont.sh failed"
    exit 1;
fi;

if ! /usr/bin/env docker-compose stop nodejs; then
    echo "Stop nodejs failed"
    exit 1;
fi;


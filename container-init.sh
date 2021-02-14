#!/usr/bin/env sh

if ! /usr/bin/env docker-compose exec -T php-hub /var/www/init.sh; then
    echo "Running php init.sh failed"
    exit 1;
fi;

versions=(54 55 56 70 71 72 73 74 80)
for v in "${versions[@]}"
do
  if ! /usr/bin/env docker-compose exec -T php-fpm-"$v" php install.php http://codetry-nginx/php-fpm-"$v"/index.php; then
      echo "Running php-fpm-$v php install.php failed"
      exit 1;
  fi;
done

if ! /usr/bin/env docker-compose exec -T nodejs /entripont.sh; then
    echo "Running nodejs prod-entripont.sh failed"
    exit 1;
fi;

if ! /usr/bin/env docker-compose stop nodejs; then
    echo "Stop nodejs failed"
    exit 1;
fi;


#!/bin/sh
set -eu

port="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${port}/" /etc/apache2/ports.conf
sed -i "s/10000/${port}/g" /etc/apache2/sites-available/000-default.conf

php artisan migrate --force
php artisan db:seed --force
php artisan optimize

exec apache2-foreground
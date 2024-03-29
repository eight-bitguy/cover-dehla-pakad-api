#!/usr/bin/env bash

set -e

echo '-----------------Prepare DEV environment-----------------'

echo '> Install Composer dependencies'
php -d memory_limit=-1 /usr/local/bin/composer install

echo '> Clear Config'
php artisan config:clear

echo '> Clear Route'
php artisan route:clear

echo '> Clear Cache'
php artisan cache:clear

# echo '> Config Cache'
# php artisan config:cache

echo '> Route Cache'
php artisan route:cache

# echo '> Run migrations in local db...'
# php artisan migrate --database=mysql

echo '> Run seeder in local db...'
#php artisan db:seed

echo '> Running php serve'
php artisan serve --host=0.0.0.0:8000

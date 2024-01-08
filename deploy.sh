#!/bin/bash

set -e


echo "Deploying..."

git pull origin master

php artisan down

php composer install --no-dev --optimize-auto

php artisan migrate --force

php artisan optimize:clear

php artisan serve

echo "Done!"

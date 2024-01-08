#!/bin/bash

set -e


echo "Deploying..."

git pull origin master

composer install --no-dev

php artisan migrate

php artisan optimize:clear

php artisan serve

echo "Done!"

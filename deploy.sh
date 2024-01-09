#!/bin/bash

set -e


echo "Deploying..."

git pull origin master

composer install --ignore-platform-reqs

php artisan migrate

php artisan optimize:clear

php artisan db:seed

echo "Done!"

#!/bin/bash

set -e

git pull origin main

php artisan down

php composer install --no-dev --optimize-auto

php artisan migrate --force

php artisan optimize:clear

php artisan serve

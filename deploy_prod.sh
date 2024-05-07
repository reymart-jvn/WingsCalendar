#!/bin/bash

# Navigate to your Laravel project directory
cd /var/www/html

# Pull the latest changes from the master branch
# git pull origin master

# Install/update Composer dependencies
# composer install --no-interaction --optimize-autoloader

# Run database migrations and other necessary commands
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache
docker compose exec shuttlewiser php artisan optimize:clear

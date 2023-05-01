#!/bin/bash

set -e

# Run composer install in the local directory
cd /var/www/office-mag/local
composer install

# Run the PHP-FPM process
exec php-fpm

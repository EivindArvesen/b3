#!/usr/bin/env bash
php artisan migrate:refresh && composer dump-autoload && php artisan db:seed -vvv
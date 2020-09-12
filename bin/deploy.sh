#!/bin/bash

WORD_DIR=/var/www/devlog-mh

cd ${WORD_DIR} && git pull
docker exec devlog-mh_app_1 composer install
docker exec devlog-mh_app_1 php artisan migrate

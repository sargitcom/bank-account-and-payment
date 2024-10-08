#!/bin/bash

sudo docker compose up -d --build
sudo docker exec -it ifx-php-apache php vendor/bin/phpunit -c phpunit.xml

#!/bin/bash

docker-compose run --rm npm install
docker-compose run --rm composer install
cp .env.example .env
docker-compose run --rm artisan key:generate
docker-compose run --rm artisan migrate:fresh --seed
docker-compose down

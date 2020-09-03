#!/bin/bash

docker-compose run --rm npm install
docker-compose up $@ nginx app db ui

FROM php:7.4-fpm

ARG DEBIAN_FRONTEND=noninteractive

ENV TZ="America/Sao_Paulo"

WORKDIR /var/www/html

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install pdo pdo_mysql

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /app

USER www

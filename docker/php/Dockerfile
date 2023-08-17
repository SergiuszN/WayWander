FROM php:8.2-fpm-alpine

RUN apk update && \
    apk upgrade && \
    apk add curl nano zip unzip wget bash libsodium libsodium-dev

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd pdo_mysql xdebug apcu intl zip bcmath curl opcache xml sodium exif

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

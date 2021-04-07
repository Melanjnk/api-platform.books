FROM composer:1 as composer
FROM php:8.0.3-fpm-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk update && apk add \
    postgresql-dev \
    icu-dev \
    autoconf \
    g++ \
    make
#    make \
#    rabbitmq-c-dev

RUN docker-php-ext-install \
        pdo_pgsql \
        opcache \
        intl \
        sockets

#RUN pecl install \
#        xdebug  \
#        amqp \
#    && docker-php-ext-enable \
#        xdebug \
#        amqp

RUN apk update && apk upgrade && \
    apk add --no-cache bash git openssh


COPY php.ini ${PHP_INI_DIR}
COPY conf.d/opcache.ini ${PHP_INI_DIR}/conf.d/

WORKDIR /var/www
FROM php:fpm
RUN apt-get update && \
    apt update && \
    apt install default-mysql-client -y && \
    docker-php-ext-install pdo_mysql

COPY /Docker/php/uploads.ini /usr/local/etc/php/conf.d/
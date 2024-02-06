FROM php:fpm
RUN apt-get update && \
    apt update && \
    apt install default-mysql-client -y && \
    docker-php-ext-install pdo_mysql

RUN apt-get update -y && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev

# RUN docker-php-ext-install gd

# RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-webp 

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN cd /usr/src/php/ext/gd && make
RUN docker-php-ext-install gd

COPY /Docker/php/uploads.ini /usr/local/etc/php/conf.d/

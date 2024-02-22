FROM php:fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Add PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd fileinfo intl mbstring pdo_mysql zip

RUN apt-get update && \
    apt update && \
    apt install default-mysql-client -y && \
    docker-php-ext-install pdo_mysql

RUN apt-get install -y git libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev

# RUN docker-php-ext-install gd

# RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-webp 

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN cd /usr/src/php/ext/gd && make
RUN docker-php-ext-install gd

COPY uploads.ini /usr/local/etc/php/conf.d/

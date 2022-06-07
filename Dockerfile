FROM php:5.6-cli

WORKDIR /code

RUN apt-get update \
    && apt-get install -y \
        ca-certificates \
        git \
        zip \
        unzip \
        zlib1g-dev \
        libzip-dev \
        libpng-dev \
    && apt-get clean

RUN docker-php-ext-install mysql zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
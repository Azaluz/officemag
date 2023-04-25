FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      apt-get install -y --no-install-recommends \
      libonig-dev \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libwebp-dev \
      libwebp6 \
      libxpm-dev && \
      docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ --with-webp=/usr/include/ --with-xpm=/usr/include/ && \
      docker-php-ext-install bcmath gd zip mysqli && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN usermod -u 1000 www-data

WORKDIR /var/www/office-mag

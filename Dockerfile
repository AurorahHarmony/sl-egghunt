# FROM php:8.2-fpm

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip

# # Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# RUN mkdir -p /var/www
# WORKDIR /var/www
# COPY . /var/www/

# # Get latest Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

FROM composer:latest as build
COPY . /app/
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

FROM php:8.2-apache-buster as production

ENV APP_ENV=development
ENV APP_DEBUG=true

RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo pdo_mysql
COPY ./docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY --from=build /app /var/www/html
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN touch /var/www/html/.env &&\
    # php artisan config:cache && \
    php artisan route:cache && \
    chmod 777 -R /var/www/html/storage/ && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite

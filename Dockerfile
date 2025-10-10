FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    pkg-config \
    git \
    unzip

RUN docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql \
    mbstring \
    xml \
    zip

RUN pecl install memcached && \
    docker-php-ext-enable memcached

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html/

RUN composer install --no-interaction --optimize-autoloader --no-dev

EXPOSE 80

CMD ["apache2-foreground"]
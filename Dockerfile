FROM php:8.1-apache

# PHP extensions
RUN apt update && apt install -y zlib1g-dev g++ libicu-dev zip libzip-dev libpq-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get install -y git \
    && a2enmod rewrite

# Node.js Setup
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Copy composer files
COPY composer.json composer.lock /var/www/html/

# Install composer dependencies
RUN composer install --no-interaction --no-scripts --no-autoloader

# Copy the rest of your application code
COPY . /var/www/html

# Generate autoload files
RUN composer dump-autoload --optimize

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 

# Expose port 80 (default HTTP port)
EXPOSE 80

FROM php:8.1-apache

# PHP setup
RUN apt update && apt install -y zlib1g-dev g++ libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get install -y git

# Nodejs Setup
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composer Setup
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# System Setup
WORKDIR /var/www/html

COPY . .

RUN chmod +x start-container.sh

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN if [ -d "/var/www/html/storage"]; then chown -R www-data:www-data /var/www/html/storage; fi
RUN if [ -d "/var/www/html/bootstrap/cache"]; then chown -R www-data:www-data /var/www/html/bootstrap/cache; fi

RUN useradd -G www-data,root -u 100 -d /home/devuser devuser

RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser /var/www/html

RUN a2enmod rewrite header

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181

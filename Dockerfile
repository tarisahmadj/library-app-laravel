# Use PHP with Apache as the base image
FROM php:8.2-apache

# Install Additional System Dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libmagickwand-dev \
    libsodium-dev \
    libicu-dev \
    --no-install-recommends

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip sodium intl

# Install Imagick PHP extension via PECL
RUN pecl install imagick && docker-php-ext-enable imagick

# Pastikan file .ini extensions sudah ada
RUN docker-php-ext-enable pdo_mysql zip sodium

# Konfigurasi PHP untuk mendukung host.docker.internal
# RUN echo "host.docker.internal $(/sbin/ip route|awk '/default/ { print $3 }')\n" >> /etc/hosts

# Configure Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy the application code
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts

# Manually set the application key
RUN php -r "file_exists('.env') || copy('.env.example', '.env');"
RUN php artisan key:generate --show

# Optimize application for production
RUN php artisan optimize

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

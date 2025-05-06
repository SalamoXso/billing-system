# Use an official PHP runtime as a parent image
FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy the current directory contents into the container
COPY . .

# Install PHP dependencies
RUN composer install

# Expose port 80
EXPOSE 80

# Start PHP-FPM server
CMD ["php-fpm"]

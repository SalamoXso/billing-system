FROM php:8.3.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    curl \
    zip \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Node & build Vite assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install && \
    npm run build
    
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Copy config files
# Remove ALL default nginx configs
RUN rm -f /etc/nginx/sites-enabled/default \
        /etc/nginx/conf.d/default.conf

# Copy correct one
COPY ./nginx.conf /etc/nginx/conf.d/default.conf
COPY ./supervisord.conf /etc/supervisord.conf


# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose HTTP
EXPOSE 80
RUN cat /etc/nginx/conf.d/default.conf
RUN ls -la /var/www/public
# Start both PHP-FPM and Nginx with supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

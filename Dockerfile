# Use an official PHP base image with Node.js installed
FROM php:8.3-cli

# Install dependencies (Composer, Node.js, npm, and build dependencies)
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    nodejs \
    npm \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set the working directory in the container
WORKDIR /app

# Copy your application files to the container
COPY . .

# Install PHP dependencies (Composer) and Node dependencies (npm)
RUN composer install && npm install

# Expose the port Laravel will run on
EXPOSE 8000

# Run the build and configuration commands
RUN npm run build && php artisan config:clear

# Start the PHP server (this may need to be adjusted based on your needs)
CMD php artisan serve --host=0.0.0.0 --port=8000

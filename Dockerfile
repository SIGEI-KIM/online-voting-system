# Use an official PHP image with Apache (or Nginx if you prefer)
FROM php:8.2-apache

# Install system dependencies and PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql # Use pdo_pgsql for PostgreSQL

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy your Laravel application code
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Run Laravel migrations and cache commands (only once during build)
RUN php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port (if not using Apache's default)
# EXPOSE 80

# Command to run on container start (Apache is typically default)
# CMD ["apache2-foreground"]
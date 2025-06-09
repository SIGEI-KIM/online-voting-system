# Use an official PHP image with Apache
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
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory to the application root
WORKDIR /var/www/html

# Copy your Laravel application code
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# --- NEW: Clear Laravel caches explicitly before other commands ---
RUN php artisan optimize:clear

# Run Laravel migrations and cache commands (only once during build)
RUN php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Remove the default Apache virtual host configuration
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Copy your custom virtual host configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable the custom virtual host configuration
RUN a2ensite 000-default.conf

# Enable Apache's mod_rewrite module (essential for Laravel's pretty URLs)
RUN a2enmod rewrite

# Expose port 80 (Apache's default)
EXPOSE 80

# Command to run on container start (Apache is typically default for this base image)
# CMD ["apache2-foreground"]

FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk update && apk add --no-cache \
    nginx \
    supervisor \
    git \
    unzip \
    libzip-dev \
    icu-dev \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo pdo_pgsql zip intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Create storage link
RUN php artisan storage:link

# Generate application key if it doesn't exist
RUN php artisan key:generate --ansi

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx and Supervisor configurations
COPY /docker/nginx.conf /etc/nginx/nginx.conf
COPY /docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 80
EXPOSE 80

# Start Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Health check (optional, but recommended)
HEALTHCHECK --interval=5s --timeout=3s CMD curl -f http://localhost
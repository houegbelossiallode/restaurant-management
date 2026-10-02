# FROM php:8.3-apache AS php-base

# RUN apt-get update && apt-get install -y --no-install-recommends \
#         libfreetype6-dev \
#         libjpeg62-turbo-dev \
#         libonig-dev \
#         libpng-dev \
#         libpq-dev \
#         libxml2-dev \
#         libzip-dev \
#         unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j1 dom xmlreader \
#     && docker-php-ext-install -j"$(nproc)" \
#         bcmath gd mbstring pdo_pgsql simplexml xml xmlwriter zip \
#     && a2enmod rewrite headers \
#     && rm -rf /var/lib/apt/lists/*

# FROM php-base AS app-build

# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
# WORKDIR /var/www/html
# COPY . .
# RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress

# FROM node:22-alpine AS assets-build

# WORKDIR /app
# COPY package.json package-lock.json ./
# RUN npm ci
# COPY resources ./resources
# COPY vite.config.js postcss.config.js tailwind.config.js ./
# COPY public ./public
# RUN npm run build

# FROM php-base AS runtime

# WORKDIR /var/www/html
# COPY --from=app-build /var/www/html /var/www/html
# COPY --from=assets-build /app/public/build /var/www/html/public/build
# COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
# COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
# RUN chmod +x /usr/local/bin/docker-entrypoint \
#     && chown -R www-data:www-data storage bootstrap/cache

# EXPOSE 10000
# ENTRYPOINT ["sh", "/usr/local/bin/docker-entrypoint"]




# Stage 1: Build Frontend Assets
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci
COPY resources ./resources
COPY public ./public
RUN npm run build

# Stage 2: Production PHP + Nginx Environment
FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    gettext-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip opcache bcmath intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create database file & configure permissions
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod 664 /var/www/html/database/database.sqlite

# Copy Nginx & Supervisor configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose Render PORT
EXPOSE 10000

# Entrypoint script
CMD ["/usr/local/bin/start.sh"]

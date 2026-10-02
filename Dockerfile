FROM php:8.3-apache AS php-base

RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libpq-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j1 dom xmlreader \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath gd mbstring pdo_pgsql simplexml xml xmlwriter zip \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

FROM php-base AS app-build

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress

FROM node:22-alpine AS assets-build

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY public ./public
RUN npm run build

FROM php-base AS runtime

WORKDIR /var/www/html
COPY --from=app-build /var/www/html /var/www/html
COPY --from=assets-build /app/public/build /var/www/html/public/build
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000
ENTRYPOINT ["sh", "/usr/local/bin/docker-entrypoint"]
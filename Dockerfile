FROM docker.io/dunglas/frankenphp:php8.5
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    libzip-dev zip \
    libicu-dev

# Configure GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP Extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    gd \
    zip \
    bcmath \
    intl \
    exif

# Install Composer
COPY --from=docker.io/library/composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
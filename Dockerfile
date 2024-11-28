FROM php:8.2-fpm

# Install dependensi sistem dan Composer
RUN apt-get clean && apt-get update -y && apt-get install -y \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring bcmath \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Set working directory ke /var/www
WORKDIR /app

# Copy file aplikasi Laravel ke dalam container
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Pastikan direktori storage dan cache bisa ditulis
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expose port untuk PHP-FPM
EXPOSE 9000

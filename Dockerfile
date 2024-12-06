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
    libpq-dev \
    netcat-openbsd \
    python3 \
    python3-pip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql mbstring bcmath \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Install Python packages
RUN pip3 install pandas psycopg2

# Set working directory ke /app
WORKDIR /app

# Copy file aplikasi Laravel ke dalam container
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Install faker untuk seeding
RUN composer require fakerphp/faker

# Pastikan direktori storage dan cache bisa ditulis
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port untuk PHP-FPM
EXPOSE 9000

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]
#!/bin/sh

# Tunggu hingga layanan database siap
until nc -z -v -w30 db 5432
do
  echo "Menunggu database connection..."
  sleep 1
done
echo "Database connection tersedia!"

# Jalankan perintah setup Laravel
php artisan key:generate
php artisan storage:link
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
php artisan passport:install

# Jalankan PHP-FPM
php-fpm
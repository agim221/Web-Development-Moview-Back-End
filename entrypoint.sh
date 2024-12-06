#!/bin/sh

# Tunggu hingga layanan database di Railway siap
until nc -z -v -w30 postgres-ifxh.railway.internal 5432
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

# Jalankan PHP built-in server
php artisan serve --host=0.0.0.0 --port=8000

tail -f /dev/null

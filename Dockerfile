# Gunakan PHP versi 8.2
FROM php:8.2-cli

# Install alat yang dibutuhkan Laravel & SQLite
RUN apt-get update && apt-get install -y unzip sqlite3 libsqlite3-dev

# Install Composer untuk PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Tentukan folder kerja di dalam server
WORKDIR /app

# Salin semua file dari GitHub-mu ke server Render
COPY . /app

# Install pustaka Laravel
RUN composer install --no-dev --optimize-autoloader

# Buat file database SQLite dan lakukan migrasi
RUN touch database/database.sqlite
RUN php artisan migrate --force

# Nyalakan server web Laravel
CMD php artisan serve --host=0.0.0.0 --port=$PORT
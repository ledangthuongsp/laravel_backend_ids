# Sử dụng PHP official image làm base
FROM php:8.3-fpm

# Cài đặt các extension cần thiết cho Laravel và MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Cài đặt Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ mã nguồn Laravel vào container
COPY . .

# Cài đặt các package Laravel
RUN composer install --no-dev --optimize-autoloader

# Thiết lập quyền cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port cho ứng dụng PHP-FPM
EXPOSE 9000

# Chạy PHP-FPM khi container khởi động
CMD ["php-fpm"]

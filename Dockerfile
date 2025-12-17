# Sử dụng hình ảnh PHP 8.2 với Apache (Laravel 11 yêu cầu tối thiểu PHP 8.2)
FROM php:8.3-apache

# Cài đặt các thư viện hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Xóa cache để giảm dung lượng
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài đặt các PHP extensions cần thiết cho Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Bật mod_rewrite của Apache (quan trọng cho URL Laravel)
RUN a2enmod rewrite

# Cấu hình DocumentRoot trỏ vào thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ source code vào container
COPY . .

# Cài đặt các gói phụ thuộc của Laravel (bỏ qua dev dependencies)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Phân quyền cho thư mục storage và bootstrap/cache (để Laravel có thể ghi log/cache)
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose cổng 80
EXPOSE 80

CMD bash -c "php artisan migrate --force && apache2-foreground"
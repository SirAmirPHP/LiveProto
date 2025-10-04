FROM php:8.2-cli

# نصب Extension های مورد نیاز
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تنظیم دایرکتوری کار
WORKDIR /app

# کپی فایل‌های پروژه
COPY . .

# نصب وابستگی‌ها
RUN composer install --no-dev --optimize-autoloader

# ایجاد دایرکتوری داده
RUN mkdir -p /app/data

# تنظیم مجوزها
RUN chmod +x /app/run.sh

# اجرای برنامه
CMD ["./run.sh"]
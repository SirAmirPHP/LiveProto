FROM php:8.1-apache

# نصب extension های مورد نیاز
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    ffmpeg \
    && docker-php-ext-install pdo pdo_mysql zip

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تنظیم Apache
RUN a2enmod rewrite
COPY .htaccess /var/www/html/

# کپی فایل‌های پروژه
COPY . /var/www/html/

# تنظیم مجوزها
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# تنظیم PHP
RUN echo "upload_max_filesize = 50M" >> /usr/local/etc/php/conf.d/uploads.ini
RUN echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini
RUN echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# تنظیم Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
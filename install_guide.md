# راهنمای کامل نصب ربات شناسایی آهنگ

## مرحله 1: آماده‌سازی سرور

### پیش‌نیازهای سیستم
- **PHP 7.4 یا بالاتر**
- **MySQL 5.7 یا بالاتر**
- **FFmpeg** (برای استخراج صدا از ویدیو)
- **SSL Certificate** (برای webhook)

### بررسی پیش‌نیازها
```bash
# بررسی نسخه PHP
php -v

# بررسی MySQL
mysql --version

# بررسی FFmpeg
ffmpeg -version
```

## مرحله 2: آپلود فایل‌ها

1. تمام فایل‌های پروژه را در پوشه `public_html` یا `www` آپلود کنید
2. مطمئن شوید که فایل‌ها با مجوزهای صحیح آپلود شده‌اند

## مرحله 3: ایجاد دیتابیس

### در cPanel:
1. به بخش **MySQL Databases** بروید
2. دیتابیس جدید ایجاد کنید (مثال: `music_bot_db`)
3. کاربر دیتابیس ایجاد کنید
4. کاربر را به دیتابیس متصل کنید
5. مجوزهای کامل به کاربر بدهید

### با دستور SQL:
```sql
CREATE DATABASE music_bot_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'music_bot_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON music_bot_db.* TO 'music_bot_user'@'localhost';
FLUSH PRIVILEGES;
```

## مرحله 4: تنظیم فایل config.php

```php
<?php
// تنظیمات ربات تلگرام
define('BOT_TOKEN', '1234567890:ABCdefGHIjklMNOpqrsTUVwxyz'); // توکن ربات
define('WEBHOOK_URL', 'https://yourdomain.com/webhook.php');

// تنظیمات دیتابیس
define('DB_HOST', 'localhost');
define('DB_NAME', 'music_bot_db');
define('DB_USER', 'music_bot_user');
define('DB_PASS', 'strong_password');

// تنظیمات API
define('INSTAGRAM_API_KEY', 'your_instagram_api_key');
define('MUSIC_RECOGNITION_API_KEY', 'your_music_recognition_api_key');

// تنظیمات عمومی
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB
define('ALLOWED_EXTENSIONS', ['mp4', 'mov', 'avi']);
?>
```

## مرحله 5: ایجاد ربات تلگرام

### با BotFather:
1. به [@BotFather](https://t.me/botfather) پیام دهید
2. دستور `/newbot` را ارسال کنید
3. نام ربات را وارد کنید (مثال: "Music Recognition Bot")
4. username ربات را وارد کنید (مثال: "music_recognition_bot")
5. توکن ربات را کپی کنید

### تنظیم دستورات ربات:
```
/setcommands
@music_recognition_bot
start - شروع کار با ربات
help - راهنمای استفاده
```

## مرحله 6: دریافت API Keys

### Instagram Basic Display API:
1. به [Facebook Developers](https://developers.facebook.com/) بروید
2. اپلیکیشن جدید ایجاد کنید
3. **Instagram Basic Display** را اضافه کنید
4. کلید API را دریافت کنید

### ACRCloud API (شناسایی آهنگ):
1. به [ACRCloud](https://www.acrcloud.com/) بروید
2. حساب کاربری ایجاد کنید
3. پروژه جدید ایجاد کنید
4. کلید API و Secret را دریافت کنید

### جایگزین: Shazam API:
1. به [RapidAPI](https://rapidapi.com/) بروید
2. Shazam API را پیدا کنید
3. کلید API را دریافت کنید

## مرحله 7: نصب FFmpeg

### در cPanel:
1. به بخش **Software** بروید
2. **FFmpeg** را نصب کنید
3. یا از **Softaculous Apps Installer** استفاده کنید

### با دستور:
```bash
# CentOS/RHEL
yum install ffmpeg

# Ubuntu/Debian
apt-get install ffmpeg

# cPanel
/usr/local/bin/ffmpeg
```

## مرحله 8: تنظیم Webhook

### اجرای setup.php:
```
https://yourdomain.com/setup.php?password=your_admin_password
```

### تنظیم دستی:
```bash
curl -X POST "https://api.telegram.org/bot<BOT_TOKEN>/setWebhook" \
     -H "Content-Type: application/json" \
     -d '{"url": "https://yourdomain.com/webhook.php"}'
```

## مرحله 9: تست ربات

### اجرای test.php:
```
https://yourdomain.com/test.php?password=your_admin_password
```

### تست دستی:
1. ربات را در تلگرام پیدا کنید
2. دستور `/start` را ارسال کنید
3. لینک ریلز اینستاگرام را ارسال کنید

## مرحله 10: تنظیم Cron Job

### در cPanel:
1. به بخش **Cron Jobs** بروید
2. cron job جدید ایجاد کنید:
   - **Minute:** 0
   - **Hour:** * (هر ساعت)
   - **Day:** * (هر روز)
   - **Month:** * (هر ماه)
   - **Weekday:** * (هر روز هفته)
   - **Command:** `php /path/to/your/cron.php`

## مرحله 11: امنیت

### تنظیم .htaccess:
```apache
# محافظت از فایل‌های حساس
<Files "config.php">
    Order Allow,Deny
    Deny from all
</Files>

# محدودیت دسترسی
Options -Indexes
ServerSignature Off
```

### تنظیم مجوزهای فایل:
```bash
chmod 644 *.php
chmod 600 config.php
chmod 755 .
```

## مرحله 12: مانیتورینگ

### لاگ‌ها:
- لاگ‌های PHP: `/var/log/php_errors.log`
- لاگ‌های Apache: `/var/log/apache2/error.log`
- لاگ‌های MySQL: `/var/log/mysql/error.log`

### پنل مدیریت:
```
https://yourdomain.com/admin.php?password=your_admin_password
```

## عیب‌یابی

### خطاهای رایج:

1. **خطای اتصال به دیتابیس:**
   - اطلاعات دیتابیس را بررسی کنید
   - اطمینان حاصل کنید که دیتابیس ایجاد شده است

2. **خطای FFmpeg:**
   - FFmpeg را نصب کنید
   - مسیر FFmpeg را در کد تنظیم کنید

3. **خطای API:**
   - کلیدهای API را بررسی کنید
   - محدودیت‌های API را در نظر بگیرید

4. **خطای Webhook:**
   - SSL certificate را بررسی کنید
   - URL webhook را صحیح تنظیم کنید

### تست‌های اضافی:

1. **تست اتصال دیتابیس:**
```php
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=music_bot_db", "user", "pass");
    echo "Database connection successful";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

2. **تست FFmpeg:**
```bash
ffmpeg -version
```

3. **تست API:**
```bash
curl -X GET "https://api.telegram.org/bot<BOT_TOKEN>/getMe"
```

## پشتیبانی

برای پشتیبانی و گزارش باگ، لطفاً با توسعه‌دهنده تماس بگیرید.

---

**نکته مهم:** این راهنما برای هاست‌های cPanel نوشته شده است. برای هاست‌های دیگر ممکن است نیاز به تنظیمات اضافی باشد.
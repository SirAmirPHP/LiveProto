#!/bin/bash

# اسکریپت نصب مانیتورینگ گیفت‌های تلگرام
# Telegram Gift Monitor Installation Script

echo "🚀 شروع نصب مانیتورینگ گیفت‌های تلگرام..."

# بررسی وجود PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP نصب نشده است. لطفاً ابتدا PHP را نصب کنید."
    exit 1
fi

# بررسی نسخه PHP
PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "✅ PHP نسخه $PHP_VERSION یافت شد"

# بررسی وجود Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer نصب نشده است. لطفاً ابتدا Composer را نصب کنید."
    echo "📖 راهنمای نصب: https://getcomposer.org/download/"
    exit 1
fi

echo "✅ Composer یافت شد"

# نصب وابستگی‌ها
echo "📦 نصب وابستگی‌ها..."
composer install --no-dev --optimize-autoloader

if [ $? -eq 0 ]; then
    echo "✅ وابستگی‌ها با موفقیت نصب شدند"
else
    echo "❌ خطا در نصب وابستگی‌ها"
    exit 1
fi

# ایجاد فایل‌های ضروری
echo "📁 ایجاد فایل‌های ضروری..."

# ایجاد دایرکتوری لاگ
mkdir -p logs
chmod 755 logs

# ایجاد فایل لاگ
touch logs/gift_monitor.log
chmod 644 logs/gift_monitor.log

# بررسی فایل تنظیمات
if [ ! -f "config.json" ]; then
    echo "⚠️ فایل config.json یافت نشد. لطفاً تنظیمات را تکمیل کنید."
    echo "📝 نمونه تنظیمات:"
    echo '{
    "api_id": "YOUR_API_ID",
    "api_hash": "YOUR_API_HASH", 
    "bot_token": "YOUR_BOT_TOKEN",
    "channel_id": "YOUR_CHANNEL_ID",
    "channel_username": "YOUR_CHANNEL_USERNAME",
    "check_interval": 30
}'
else
    echo "✅ فایل تنظیمات یافت شد"
fi

# ایجاد اسکریپت اجرا
cat > start_monitor.sh << 'EOF'
#!/bin/bash
echo "🚀 شروع مانیتورینگ گیفت‌های تلگرام..."
php telegram_gift_monitor.php start
EOF

chmod +x start_monitor.sh

# ایجاد اسکریپت تست
cat > test_connection.sh << 'EOF'
#!/bin/bash
echo "🧪 تست اتصال..."
php telegram_gift_monitor.php test
EOF

chmod +x test_connection.sh

echo ""
echo "🎉 نصب با موفقیت تکمیل شد!"
echo ""
echo "📋 مراحل بعدی:"
echo "1. فایل config.json را ویرایش کنید و اطلاعات API خود را وارد کنید"
echo "2. برای تست اتصال: ./test_connection.sh"
echo "3. برای شروع مانیتورینگ: ./start_monitor.sh"
echo ""
echo "📖 راهنمای کامل در فایل README.md موجود است"
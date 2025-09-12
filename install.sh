#!/bin/bash

echo "🚀 نصب ربات مانیتورینگ گیفت‌های تلگرام"
echo "========================================"

# بررسی وجود PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP نصب نشده است. لطفاً PHP 8.2 یا بالاتر نصب کنید."
    exit 1
fi

# بررسی نسخه PHP
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
REQUIRED_VERSION="8.2"

if [ "$(printf '%s\n' "$REQUIRED_VERSION" "$PHP_VERSION" | sort -V | head -n1)" != "$REQUIRED_VERSION" ]; then
    echo "❌ نسخه PHP شما ($PHP_VERSION) کمتر از نسخه مورد نیاز ($REQUIRED_VERSION) است."
    exit 1
fi

echo "✅ نسخه PHP: $PHP_VERSION"

# بررسی وجود Composer
if ! command -v composer &> /dev/null; then
    echo "📦 نصب Composer..."
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
fi

echo "✅ Composer موجود است"

# نصب وابستگی‌ها
echo "📦 نصب وابستگی‌ها..."
composer install --no-dev --optimize-autoloader

# ایجاد فایل کانفیگ
if [ ! -f "gift_config.json" ]; then
    echo "⚙️ ایجاد فایل کانفیگ..."
    cp config_example.json gift_config.json
    echo "📝 فایل gift_config.json ایجاد شد. لطفاً تنظیمات را تکمیل کنید."
fi

# ایجاد فایل اجرایی
echo "🔧 ایجاد فایل اجرایی..."
cat > run.sh << 'EOF'
#!/bin/bash
echo "🚀 شروع ربات مانیتورینگ گیفت‌های تلگرام..."
php telegram_gift_monitor.php
EOF

chmod +x run.sh

# بررسی Extension های مورد نیاز
echo "🔍 بررسی Extension های PHP..."
REQUIRED_EXTENSIONS=("openssl" "gmp" "json" "xml" "dom" "filter" "hash" "zlib" "fileinfo")

for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if php -m | grep -q "$ext"; then
        echo "✅ $ext"
    else
        echo "❌ $ext - نصب نشده"
        echo "   لطفاً extension $ext را نصب کنید"
    fi
done

echo ""
echo "🎉 نصب با موفقیت انجام شد!"
echo ""
echo "📋 مراحل بعدی:"
echo "1. فایل gift_config.json را ویرایش کنید"
echo "2. api_id و api_hash خود را وارد کنید"
echo "3. کانال‌های هدف را اضافه کنید"
echo "4. با دستور ./run.sh برنامه را اجرا کنید"
echo ""
echo "📖 برای راهنمای کامل، فایل README_FA.md را مطالعه کنید."
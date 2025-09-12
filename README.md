# مانیتورینگ گیفت‌های تلگرام
## Telegram Gift Monitor

یک سورس کد PHP برای مانیتورینگ و ارسال خودکار گیفت‌های جدید تلگرام به کانال تعیین شده.

## ویژگی‌ها

- 🔍 **مانیتورینگ خودکار**: بررسی مداوم گیفت‌های جدید
- 📱 **ارسال فوری**: ارسال سریع گیفت‌های جدید به کانال
- 🎁 **اطلاعات کامل**: نمایش نام، مشخصات و جزئیات گیفت
- ⚙️ **قابل تنظیم**: فاصله زمانی قابل تنظیم برای بررسی
- 🛡️ **امن**: استفاده از API رسمی تلگرام
- 🌐 **سازگار با cPanel**: قابل اجرا در هاست cPanel

## پیش‌نیازها

- PHP 7.4 یا بالاتر
- Composer
- دسترسی به API تلگرام (api_id و api_hash)
- توکن ربات تلگرام
- شناسه کانال مقصد

## نصب

### 1. دریافت API اطلاعات از تلگرام

1. به [my.telegram.org](https://my.telegram.org) بروید
2. وارد حساب کاربری خود شوید
3. به بخش "API development tools" بروید
4. یک اپلیکیشن جدید ایجاد کنید
5. `api_id` و `api_hash` را دریافت کنید

### 2. ایجاد ربات تلگرام

1. با [@BotFather](https://t.me/BotFather) صحبت کنید
2. دستور `/newbot` را ارسال کنید
3. نام و نام کاربری ربات را تعیین کنید
4. توکن ربات را دریافت کنید

### 3. دریافت شناسه کانال

1. ربات را به کانال اضافه کنید
2. دسترسی ادمین به ربات بدهید
3. شناسه کانال را از URL یا با استفاده از ربات‌های مخصوص دریافت کنید

### 4. نصب و راه‌اندازی

```bash
# کلون کردن پروژه
git clone <repository-url>
cd telegram-gift-monitor

# اجرای اسکریپت نصب
chmod +x install.sh
./install.sh
```

### 5. تنظیمات

فایل `config.json` را ویرایش کنید:

```json
{
    "api_id": "12345678",
    "api_hash": "abcdef1234567890abcdef1234567890",
    "bot_token": "1234567890:ABCdefGHIjklMNOpqrsTUVwxyz",
    "channel_id": "@your_channel_username",
    "channel_username": "your_channel_username",
    "check_interval": 30,
    "debug": true,
    "language": "fa",
    "timezone": "Asia/Tehran"
}
```

## استفاده

### تست اتصال

```bash
./test_connection.sh
# یا
php telegram_gift_monitor.php test
```

### شروع مانیتورینگ

```bash
./start_monitor.sh
# یا
php telegram_gift_monitor.php start
```

### اجرا در پس‌زمینه (cPanel)

```bash
nohup php telegram_gift_monitor.php start > logs/gift_monitor.log 2>&1 &
```

## تنظیمات cPanel

### 1. آپلود فایل‌ها

- تمام فایل‌ها را در دایرکتوری `public_html` یا زیردایرکتوری آپلود کنید

### 2. تنظیم Cron Job

در cPanel، بخش Cron Jobs:
```bash
*/5 * * * * cd /home/username/public_html && php telegram_gift_monitor.php start
```

### 3. تنظیمات PHP

اطمینان حاصل کنید که:
- PHP 7.4+ فعال است
- Extension های `curl`, `json`, `mbstring` فعال هستند
- حافظه کافی (حداقل 128MB) در دسترس است

## ساختار فایل‌ها

```
telegram-gift-monitor/
├── telegram_gift_monitor.php    # فایل اصلی
├── config.json                  # تنظیمات
├── composer.json               # وابستگی‌ها
├── install.sh                  # اسکریپت نصب
├── start_monitor.sh            # اسکریپت شروع
├── test_connection.sh          # اسکریپت تست
├── logs/                       # دایرکتوری لاگ‌ها
│   └── gift_monitor.log
└── README.md                   # راهنما
```

## عیب‌یابی

### خطاهای رایج

1. **خطای اتصال به API**
   - بررسی صحت `api_id` و `api_hash`
   - اطمینان از دسترسی به اینترنت

2. **خطای ارسال پیام**
   - بررسی توکن ربات
   - اطمینان از عضویت ربات در کانال
   - بررسی دسترسی‌های ربات

3. **خطای حافظه**
   - افزایش `memory_limit` در PHP
   - کاهش `check_interval`

### لاگ‌ها

لاگ‌ها در فایل `logs/gift_monitor.log` ذخیره می‌شوند.

## امنیت

- هرگز اطلاعات API را در کد قرار ندهید
- فایل `config.json` را در `.gitignore` قرار دهید
- دسترسی‌های فایل‌ها را به درستی تنظیم کنید

## پشتیبانی

برای گزارش باگ یا درخواست ویژگی جدید، issue ایجاد کنید.

## مجوز

این پروژه تحت مجوز MIT منتشر شده است.

---

**نکته**: این ابزار صرفاً برای اهداف آموزشی و شخصی طراحی شده است. لطفاً از قوانین و مقررات تلگرام پیروی کنید.
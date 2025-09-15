## Telegram Reels Music Recognizer (PHP, cPanel)

This PHP bot receives an Instagram Reels link and replies with the song name using AudD music recognition.

### Files
- `public/index.php`: Telegram webhook entrypoint
- `src/config.php`: Put your tokens here
- `src/bootstrap.php`: Core bot logic
- `tools/set_webhook.php`: Helper to set Telegram webhook

### Requirements
- PHP 7.4+ with cURL enabled (cPanel default is fine)
- A public HTTPS URL (use your cPanel domain)
- Telegram Bot Token (from @BotFather)
- AudD API token (`https://audd.io`)

### Setup
1. Edit `src/config.php` and set:
   - `TELEGRAM_BOT_TOKEN`
   - `AUDD_API_TOKEN`
2. Upload the project to your hosting so that `public/index.php` is accessible at `https://your-domain.tld/index.php` (or map DocumentRoot to `public/`).
3. Set the webhook:
   - From your computer: `php tools/set_webhook.php https://your-domain.tld/index.php`
   - Or via browser: `https://api.telegram.org/bot<YOUR_TOKEN>/setWebhook?url=https://your-domain.tld/index.php`
4. Send `/start` to your bot, then send an Instagram Reels URL.

### Notes
- The bot extracts the first Instagram Reels-like URL from the message.
- If AudD cannot fetch/recognize the audio, it will respond with an error message.
- Logs (if enabled) go to `storage/logs/app.log` (create directory with write permissions if needed).

# ربات مدیریت کانال تلگرام
## Telegram Channel Manager Bot

این ربات به شما امکان مدیریت کانال‌های تلگرام را می‌دهد و قابل اجرا در هاست cPanel است.

### ویژگی‌ها (Features)

- ✅ افزودن ربات به کانال با تأیید مالکیت
- ✅ مدیریت کانال‌ها با دکمه‌های شیشه‌ای
- ✅ تنظیم کپشن مخصوص هر کانال
- ✅ حذف کانال از لیست
- ✅ ذخیره‌سازی اطلاعات در فایل JSON
- ✅ ذخیره لیست کانال‌ها در فایل TXT
- ✅ پشتیبانی از وب‌هوک

### نصب و راه‌اندازی (Installation)

#### 1. ایجاد ربات در تلگرام
1. به [@BotFather](https://t.me/BotFather) پیام دهید
2. دستور `/newbot` را ارسال کنید
3. نام و نام کاربری ربات را انتخاب کنید
4. توکن ربات را کپی کنید

#### 2. آپلود فایل‌ها
1. فایل‌های زیر را در هاست cPanel آپلود کنید:
   - `bot.php` (فایل اصلی ربات)
   - `config.php` (فایل تنظیمات)

#### 3. تنظیمات
1. فایل `config.php` را ویرایش کنید:
   ```php
   define('BOT_TOKEN', 'YOUR_BOT_TOKEN_HERE');
   define('WEBHOOK_URL', 'https://yourdomain.com/bot.php');
   ```

#### 4. تنظیم وب‌هوک
1. در مرورگر به آدرس زیر بروید:
   ```
   https://yourdomain.com/bot.php?set_webhook=1
   ```
2. پیام "Webhook set" را مشاهده کنید

### نحوه استفاده (Usage)

#### افزودن ربات به کانال
1. ربات را استارت کنید: `/start`
2. روی "افزودن ربات به کانال" کلیک کنید
3. ربات را به کانال خود اضافه کنید
4. ربات را به عنوان ادمین کانال تنظیم کنید
5. فقط مالک کانال می‌تواند ربات را اضافه کند

#### مدیریت کانال‌ها
1. روی "مدیریت کانال" کلیک کنید
2. کانال مورد نظر را از لیست انتخاب کنید
3. گزینه‌های زیر در دسترس است:
   - تنظیم کپشن
   - حذف کانال

### ساختار فایل‌ها (File Structure)

```
/
├── bot.php          # فایل اصلی ربات
├── config.php       # فایل تنظیمات
├── database.json    # دیتابیس کانال‌ها و کپشن‌ها (خودکار ایجاد می‌شود)
├── channels.txt     # لیست شناسه‌های کانال‌ها (خودکار ایجاد می‌شود)
└── bot.log          # فایل لاگ (در صورت فعال بودن)
```

### تنظیمات پیشرفته (Advanced Settings)

در فایل `config.php` می‌توانید تنظیمات زیر را تغییر دهید:

- `MAX_CHANNELS_PER_USER`: حداکثر تعداد کانال برای هر کاربر
- `ALLOWED_IPS`: لیست IP های مجاز
- `ENABLE_LOGGING`: فعال/غیرفعال کردن لاگ
- `TIMEZONE`: منطقه زمانی

### امنیت (Security)

- ربات فقط توسط مالک کانال قابل اضافه کردن است
- هر کاربر فقط کانال‌های خود را می‌تواند مدیریت کند
- امکان محدود کردن دسترسی بر اساس IP
- لاگ تمام فعالیت‌ها

### عیب‌یابی (Troubleshooting)

#### ربات پاسخ نمی‌دهد
1. بررسی کنید که توکن ربات صحیح باشد
2. وب‌هوک به درستی تنظیم شده باشد
3. فایل‌ها در مسیر صحیح آپلود شده باشند

#### خطای دسترسی
1. مجوزهای فایل‌ها را بررسی کنید (755 برای پوشه‌ها، 644 برای فایل‌ها)
2. بررسی کنید که PHP فعال باشد

#### کانال اضافه نمی‌شود
1. اطمینان حاصل کنید که مالک کانال هستید
2. ربات را به عنوان ادمین کانال تنظیم کنید
3. ربات دسترسی کامل به کانال داشته باشد

### پشتیبانی (Support)

برای پشتیبانی و گزارش باگ، لطفاً با توسعه‌دهنده تماس بگیرید.

### مجوز (License)

این پروژه تحت مجوز MIT منتشر شده است.

---

**نکته مهم**: قبل از استفاده در محیط تولید، حتماً تنظیمات امنیتی را بررسی کنید.
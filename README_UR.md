# ٹیلیگرام میوزک ریکگنیشن بوٹ

یہ ٹیلیگرام بوٹ انسٹاگرام ریلس سے موسیقی کی شناخت کر سکتا ہے۔ صارفین انسٹاگرام ریلس کے لنک بھیج سکتے ہیں اور بوٹ گانے کا نام اور آرٹسٹ کی شناخت کرے گا۔

## خصوصیات

- 🎵 انسٹاگرام ریلس سے موسیقی کی شناخت
- 🎤 آرٹسٹ اور گانے کا نام دکھانا
- 💿 البم کی معلومات دکھانا (اگر دستیاب ہو)
- 📅 ریلیز کا سال دکھانا
- 🎯 اعتماد کا فیصد دکھانا
- 💾 ڈیٹابیس میں تاریخ محفوظ کرنا
- 🔒 اعلیٰ سیکیورٹی اور ڈیٹا کی حفاظت

## ضروریات

- PHP 7.4 یا اس سے زیادہ
- MySQL 5.7 یا اس سے زیادہ
- FFmpeg (ویڈیو سے آڈیو نکالنے کے لیے)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL Certificate (webhook کے لیے)

## انسٹالیشن

### 1. فائلز اپ لوڈ کریں

پروجیکٹ کی تمام فائلز کو cPanel ہوسٹ میں اپ لوڈ کریں۔

### 2. انسٹالیشن چلائیں

`install.php` کو براؤزر میں چلائیں تاکہ ضروریات چیک ہوں۔

### 3. ڈیٹابیس سیٹ اپ کریں

1. MySQL ڈیٹابیس بنائیں
2. `config.php` میں ترمیم کریں اور ڈیٹابیس کی معلومات درج کریں

### 4. ٹیلیگرام بوٹ بنائیں

1. ٹیلیگرام پر [@BotFather](https://t.me/botfather) سے بات کریں
2. `/newbot` کمانڈ بھیجیں
3. بوٹ کا نام اور username منتخب کریں
4. بوٹ ٹوکن کاپی کریں
5. ٹوکن کو `config.php` میں درج کریں

### 5. APIs سیٹ اپ کریں

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) پر جائیں
2. نیا ایپلیکیشن بنائیں
3. Instagram Basic Display شامل کریں
4. API key حاصل کریں

#### ACRCloud API (موسیقی کی شناخت)
1. [ACRCloud](https://www.acrcloud.com/) پر جائیں
2. اکاؤنٹ بنائیں
3. API key حاصل کریں

### 6. Webhook سیٹ اپ کریں

`setup.php` چلائیں:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. بوٹ ٹیسٹ کریں

`test.php` چلائیں:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## استعمال

1. ٹیلیگرام پر بوٹ تلاش کریں
2. `/start` کمانڈ بھیجیں
3. انسٹاگرام ریلس کا لنک بھیجیں
4. موسیقی کی شناخت کا انتظار کریں

## فائل سٹرکچر

```
/
├── config.php              # مرکزی کنفیگریشن
├── database.php            # ڈیٹابیس کلاس
├── instagram_handler.php   # انسٹاگرام پروسیسنگ
├── music_recognizer.php    # موسیقی کی شناخت
├── telegram_bot.php        # ٹیلیگرام بوٹ کلاس
├── webhook.php            # webhook handler
├── setup.php              # سیٹ اپ
├── test.php               # بوٹ ٹیسٹنگ
├── install.php            # انسٹالیشن
├── index.php              # مرکزی صفحہ
└── README.md              # دستاویزات
```

## سپورٹڈ APIs

### موسیقی کی شناخت
- **ACRCloud**: مرکزی موسیقی شناخت سروس
- **Shazam**: ACRCloud کا متبادل

### انسٹاگرام
- **Instagram Basic Display API**: انسٹاگرام مواد تک رسائی

## ایڈوانسڈ سیٹنگز

### فائل کی حدود
`.htaccess` فائل میں:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### سیکیورٹی
- `config.php` کو عوامی رسائی سے محفوظ کریں
- درست SSL certificate استعمال کریں
- مضبوط پاس ورڈ منتخب کریں

## خرابیوں کا ازالہ

### عام مسائل

1. **ڈیٹابیس کنکشن ایرر**
   - ڈیٹابیس کی معلومات چیک کریں
   - یقینی بنائیں کہ ڈیٹابیس بن گئی ہے

2. **FFmpeg ایرر**
   - FFmpeg انسٹال کریں
   - کوڈ میں FFmpeg کا راستہ سیٹ کریں

3. **API ایرر**
   - API keys چیک کریں
   - API کی حدود پر غور کریں

4. **Webhook ایرر**
   - SSL certificate چیک کریں
   - صحیح webhook URL سیٹ کریں

## سپورٹ

سپورٹ اور بگ رپورٹس کے لیے، براہ کرم ڈیولپر سے رابطہ کریں۔

## لائسنس

یہ پروجیکٹ MIT لائسنس کے تحت لائسنس یافتہ ہے۔
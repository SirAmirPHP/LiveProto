# Telegram Musiqa Tanib Olish Boti

Bu Telegram boti Instagram Reels-dan musiqa tanib olishi mumkin. Foydalanuvchilar Instagram Reels havolalarini yuborishlari mumkin va bot qo'shiq nomini va ijrochisini tanib oladi.

## Xususiyatlar

- 🎵 Instagram Reels-dan musiqa tanib olish
- 🎤 Ijrochi va qo'shiq nomini ko'rsatish
- 💿 Albom ma'lumotini ko'rsatish (agar mavjud bo'lsa)
- 📅 Nashr yilini ko'rsatish
- 🎯 Ishonch foizini ko'rsatish
- 💾 Tarixni ma'lumotlar bazasida saqlash
- 🔒 Yuqori xavfsizlik va ma'lumotlarni himoya qilish

## Talablar

- PHP 7.4 yoki undan yuqori
- MySQL 5.7 yoki undan yuqori
- FFmpeg (videodan audio olish uchun)
- PHP Kengaytmalar: curl, json, pdo, pdo_mysql
- SSL sertifikati (webhook uchun)

## O'rnatish

### 1. Fayllarni Yuklash

Barcha loyiha fayllarini cPanel hostingingizga yuklang.

### 2. O'rnatishni Ishga Tushirish

Talablarni tekshirish uchun `install.php`-ni brauzeringizda ishga tushiring.

### 3. Ma'lumotlar Bazasini Sozlash

1. MySQL ma'lumotlar bazasini yarating
2. `config.php`-ni tahrirlang va ma'lumotlar bazasi ma'lumotini kiriting

### 4. Telegram Bot Yaratish

1. Telegram-da [@BotFather](https://t.me/botfather) bilan gaplashing
2. `/newbot` buyrug'ini yuboring
3. Bot nomini va foydalanuvchi nomini tanlang
4. Bot tokenini nusxalang
5. Tokenni `config.php`-da kiriting

### 5. API-larni Sozlash

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/)-ga o'ting
2. Yangi ilovani yarating
3. Instagram Basic Display qo'shing
4. API kalitini oling

#### ACRCloud API (Musiqa Tanib Olish)
1. [ACRCloud](https://www.acrcloud.com/)-ga o'ting
2. Hisob yarating
3. API kalitini oling

### 6. Webhook Sozlash

`setup.php`-ni ishga tushiring:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Botni Sinash

`test.php`-ni ishga tushiring:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Foydalanish

1. Botni Telegram-da toping
2. `/start` buyrug'ini yuboring
3. Instagram Reels havolasini yuboring
4. Musiqa tanib olishni kuting

## Fayl Tuzilishi

```
/
├── config.php              # Asosiy sozlash
├── database.php            # Ma'lumotlar bazasi sinfi
├── instagram_handler.php   # Instagram ishlov berish
├── music_recognizer.php    # Musiqa tanib olish
├── telegram_bot.php        # Telegram bot sinfi
├── webhook.php            # Webhook boshqaruvchisi
├── setup.php              # Sozlash
├── test.php               # Bot sinovi
├── install.php            # O'rnatish
├── index.php              # Asosiy sahifa
└── README.md              # Hujjatlashtirish
```

## Qo'llab-quvvatlanadigan API-lar

### Musiqa Tanib Olish
- **ACRCloud**: Asosiy musiqa tanib olish xizmati
- **Shazam**: ACRCloud alternativasi

### Instagram
- **Instagram Basic Display API**: Instagram kontentiga kirish

## Rivojlangan Sozlash

### Fayl Cheklovlari
`.htaccess` faylida:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Xavfsizlik
- `config.php`-ni umumiy kirishdan himoya qiling
- Haqiqiy SSL sertifikatidan foydalaning
- Kuchli parollar tanlang

## Muammolarni Hal Qilish

### Keng Tarqalgan Muammolar

1. **Ma'lumotlar Bazasi Ulanish Xatosi**
   - Ma'lumotlar bazasi ma'lumotini tekshiring
   - Ma'lumotlar bazasi yaratilganligiga ishonch hosil qiling

2. **FFmpeg Xatosi**
   - FFmpeg o'rnating
   - FFmpeg yo'lini kodda belgilang

3. **API Xatosi**
   - API kalitlarini tekshiring
   - API cheklovlarini hisobga oling

4. **Webhook Xatosi**
   - SSL sertifikatini tekshiring
   - Webhook URL-ni to'g'ri belgilang

## Qo'llab-quvvatlash

Qo'llab-quvvatlash va xato hisobotlari uchun, ishlab chiquvchi bilan bog'laning.

## Litsenziya

Bu loyiha MIT Litsenziyasi ostida litsenziyalangan.
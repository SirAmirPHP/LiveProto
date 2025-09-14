# Telegram Musiqi Tanıma Botu

Bu Telegram botu Instagram Reels-dən musiqi tanıya bilər. İstifadəçilər Instagram Reels linklərini göndərə bilər və bot mahnının adını və ifaçını tanıyacaq.

## Xüsusiyyətlər

- 🎵 Instagram Reels-dən musiqi tanıma
- 🎤 İfaçı və mahnının adını göstərmə
- 💿 Albom məlumatını göstərmə (əgər mövcuddursa)
- 📅 Nəşr ilini göstərmə
- 🎯 Etibar faizini göstərmə
- 💾 Tarixçəni verilənlər bazasında saxlama
- 🔒 Yüksək təhlükəsizlik və məlumat qorunması

## Tələblər

- PHP 7.4 və ya daha yüksək
- MySQL 5.7 və ya daha yüksək
- FFmpeg (videodan audio çıxarmaq üçün)
- PHP Uzantıları: curl, json, pdo, pdo_mysql
- SSL sertifikatı (webhook üçün)

## Quraşdırma

### 1. Faylları Yükləmə

Bütün layihə fayllarını cPanel hostunuza yükləyin.

### 2. Quraşdırmanı İcra Etmə

Tələbləri yoxlamaq üçün `install.php`-ni brauzerinizdə işə salın.

### 3. Verilənlər Bazasını Konfiqurasiya Etmə

1. MySQL verilənlər bazası yaradın
2. `config.php`-ni redaktə edin və verilənlər bazası məlumatını daxil edin

### 4. Telegram Bot Yaratma

1. Telegram-da [@BotFather](https://t.me/botfather) ilə danışın
2. `/newbot` əmrini göndərin
3. Bot adını və istifadəçi adını seçin
4. Bot tokenini kopyalayın
5. Tokeni `config.php`-də daxil edin

### 5. API-ləri Konfiqurasiya Etmə

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/)-ə gedin
2. Yeni tətbiq yaradın
3. Instagram Basic Display əlavə edin
4. API açarını əldə edin

#### ACRCloud API (Musiqi Tanıma)
1. [ACRCloud](https://www.acrcloud.com/)-ə gedin
2. Hesab yaradın
3. API açarını əldə edin

### 6. Webhook Konfiqurasiya Etmə

`setup.php`-ni işə salın:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot Test Etmə

`test.php`-ni işə salın:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## İstifadə

1. Botu Telegram-da tapın
2. `/start` əmrini göndərin
3. Instagram Reels linkini göndərin
4. Musiqi tanınmasını gözləyin

## Fayl Strukturu

```
/
├── config.php              # Əsas konfiqurasiya
├── database.php            # Verilənlər bazası sinfi
├── instagram_handler.php   # Instagram emalı
├── music_recognizer.php    # Musiqi tanıma
├── telegram_bot.php        # Telegram bot sinfi
├── webhook.php            # Webhook meneceri
├── setup.php              # Konfiqurasiya
├── test.php               # Bot testi
├── install.php            # Quraşdırma
├── index.php              # Əsas səhifə
└── README.md              # Sənədləşdirmə
```

## Dəstəklənən API-lər

### Musiqi Tanıma
- **ACRCloud**: Əsas musiqi tanıma xidməti
- **Shazam**: ACRCloud alternativi

### Instagram
- **Instagram Basic Display API**: Instagram məzmununa giriş

## Qabaqcıl Konfiqurasiya

### Fayl Məhdudiyyətləri
`.htaccess` faylında:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Təhlükəsizlik
- `config.php`-ni ictimai girişdən qoruyun
- Etibarlı SSL sertifikatı istifadə edin
- Güclü parollar seçin

## Problemləri Həll Etmə

### Ümumi Problemlər

1. **Verilənlər Bazası Bağlantı Xətası**
   - Verilənlər bazası məlumatını yoxlayın
   - Verilənlər bazasının yaradıldığından əmin olun

2. **FFmpeg Xətası**
   - FFmpeg quraşdırın
   - FFmpeg yolunu kodda təyin edin

3. **API Xətası**
   - API açarlarını yoxlayın
   - API məhdudiyyətlərini nəzərə alın

4. **Webhook Xətası**
   - SSL sertifikatını yoxlayın
   - Webhook URL-ni düzgün təyin edin

## Dəstək

Dəstək və xəta hesabatları üçün, tərtibatçı ilə əlaqə saxlayın.

## Lisenziya

Bu layihə MIT Lisenziyası altında lisenziyalaşdırılıb.
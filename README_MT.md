# Bot Telegram għal Rikonoxximent tal-Mużika

Dan il-bot Telegram jista' jidentifika mużika minn Instagram Reels. L-utenti jistgħu jibagħtu links Instagram Reels u l-bot se jidentifika l-isem tal-kanzunetta u l-artist.

## Funzjonijiet

- 🎵 Rikonoxximent tal-mużika minn Instagram Reels
- 🎤 Wiri tal-isem tal-artist u tal-kanzunetta
- 💿 Wiri ta' informazzjoni tal-album (jekk disponibbli)
- 📅 Wiri tas-sena tal-ħruġ
- 🎯 Wiri tal-perċentwal tal-fiduċja
- 💾 Ħlief tal-istorja fil-database
- 🔒 Sigurtà għolja u protezzjoni tad-dejta

## Rekwiżiti

- PHP 7.4 jew ogħla
- MySQL 5.7 jew ogħla
- FFmpeg (għal estrazzjoni tal-awdjo mill-video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- Ċertifikat SSL (għal webhook)

## Instalazzjoni

### 1. Upload tal-Files

Ibbagħat l-files kollha tal-proġett għall-host cPanel tiegħek.

### 2. Eżekuzzjoni tal-Instalazzjoni

Eżegwixxi `install.php` fil-browser tiegħek biex tivverifika r-rekwiżiti.

### 3. Konfigurazzjoni tad-Database

1. Oħloq database MySQL
2. Editja `config.php` u daħħal informazzjoni tad-database

### 4. Ħolqien tal-Bot Telegram

1. Ħaddem chat ma' [@BotFather](https://t.me/botfather) fuq Telegram
2. Ibgħat il-kmand `/newbot`
3. Agħżel l-isem tal-bot u l-username
4. Ikkopja t-token tal-bot
5. Daħħal it-token fil-`config.php`

### 5. Konfigurazzjoni tal-API

#### Instagram Basic Display API
1. Mur fuq [Facebook Developers](https://developers.facebook.com/)
2. Oħloq applikazzjoni ġdida
3. Żid Instagram Basic Display
4. Ikseb il-ċavetta API

#### ACRCloud API (Rikonoxximent tal-Mużika)
1. Mur fuq [ACRCloud](https://www.acrcloud.com/)
2. Oħloq kont
3. Ikseb il-ċavetta API

### 6. Konfigurazzjoni tal-Webhook

Eżegwixxi `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Test tal-Bot

Eżegwixxi `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Użu

1. Sib il-bot fuq Telegram
2. Ibgħat il-kmand `/start`
3. Ibgħat link Instagram Reels
4. Stenna għar-rikonoxximent tal-mużika

## Struttura tal-Files

```
/
├── config.php              # Konfigurazzjoni prinċipali
├── database.php            # Klassi tad-database
├── instagram_handler.php   # Proċessar tal-Instagram
├── music_recognizer.php    # Rikonoxximent tal-mużika
├── telegram_bot.php        # Klassi tal-bot Telegram
├── webhook.php            # Ħallieq tal-webhook
├── setup.php              # Settings
├── test.php               # Test tal-bot
├── install.php            # Instalazzjoni
├── index.php              # Paġna prinċipali
└── README.md              # Dokumentazzjoni
```

## API Appoġġjati

### Rikonoxximent tal-Mużika
- **ACRCloud**: Servizz prinċipali tar-rikonoxximent tal-mużika
- **Shazam**: Alternattiva għal ACRCloud

### Instagram
- **Instagram Basic Display API**: Aċċess għall-kontenut tal-Instagram

## Settings Avvanzati

### Limiti tal-Files
Fil-file `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sigurtà
- Ħares `config.php` mill-aċċess pubbliku
- Uża ċertifikat SSL validu
- Agħżel passwords qawwija

## Soluzzjoni tal-Problemi

### Problemi Komuni

1. **Żball tal-Konnessjoni tad-Database**
   - Iverifika l-informazzjoni tad-database
   - Kun żgur li d-database ġiet maħluqa

2. **Żball FFmpeg**
   - Installa FFmpeg
   - Issettja l-passaġġ tal-FFmpeg fil-kodiċi

3. **Żball API**
   - Iverifika l-ċwievet API
   - Ikkunsidra l-limiti tal-API

4. **Żball Webhook**
   - Iverifika ċ-ċertifikat SSL
   - Issettja l-URL tal-webhook korrett

## Appoġġ

Għall-appoġġ u rapporti ta' żbalji, jekk jogħġbok ikkuntattja l-iżviluppatur.

## Liċenzja

Dan il-proġett huwa liċenzjat taħt il-Liċenzja MIT.
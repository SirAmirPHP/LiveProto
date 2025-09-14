# Telegram Musikigenkänningsbot

Denna Telegram-bot kan identifiera musik från Instagram Reels. Användare kan skicka Instagram Reels-länkar och boten kommer att identifiera låtnamnet och artisten.

## Funktioner

- 🎵 Musikigenkänning från Instagram Reels
- 🎤 Visa artist och låtnamn
- 💿 Visa albuminformation (om tillgänglig)
- 📅 Visa utgivningsår
- 🎯 Visa konfidensgrad i procent
- 💾 Spara historik i databas
- 🔒 Hög säkerhet och dataskydd

## Krav

- PHP 7.4 eller högre
- MySQL 5.7 eller högre
- FFmpeg (för att extrahera ljud från video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL-certifikat (för webhook)

## Installation

### 1. Ladda Upp Filer

Ladda upp alla projektfiler till din cPanel-värd.

### 2. Kör Installation

Kör `install.php` i din webbläsare för att kontrollera krav.

### 3. Konfigurera Databas

1. Skapa MySQL-databas
2. Redigera `config.php` och ange databasinformation

### 4. Skapa Telegram-bot

1. Chatta med [@BotFather](https://t.me/botfather) på Telegram
2. Skicka `/newbot` kommando
3. Välj botnamn och användarnamn
4. Kopiera bot-token
5. Ange token i `config.php`

### 5. Konfigurera API:er

#### Instagram Basic Display API
1. Gå till [Facebook Developers](https://developers.facebook.com/)
2. Skapa ny applikation
3. Lägg till Instagram Basic Display
4. Få API-nyckel

#### ACRCloud API (Musikigenkänning)
1. Gå till [ACRCloud](https://www.acrcloud.com/)
2. Skapa konto
3. Få API-nyckel

### 6. Konfigurera Webhook

Kör `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testa Bot

Kör `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Användning

1. Hitta boten på Telegram
2. Skicka `/start` kommando
3. Skicka Instagram Reels-länk
4. Vänta på musikigenkänning

## Filstruktur

```
/
├── config.php              # Huvudkonfiguration
├── database.php            # Databas-klass
├── instagram_handler.php   # Instagram-behandling
├── music_recognizer.php    # Musikigenkänning
├── telegram_bot.php        # Telegram-bot-klass
├── webhook.php            # Webhook-hanterare
├── setup.php              # Inställningar
├── test.php               # Bot-testning
├── install.php            # Installation
├── index.php              # Huvudsida
└── README.md              # Dokumentation
```

## Stödda API:er

### Musikigenkänning
- **ACRCloud**: Huvudservice för musikigenkänning
- **Shazam**: ACRCloud-alternativ

### Instagram
- **Instagram Basic Display API**: Åtkomst till Instagram-innehåll

## Avancerade Inställningar

### Fillimiter
I `.htaccess`-fil:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Säkerhet
- Skydda `config.php` från offentlig åtkomst
- Använd giltigt SSL-certifikat
- Välj starka lösenord

## Felsökning

### Vanliga Problem

1. **Databasanslutningsfel**
   - Kontrollera databasinformation
   - Säkerställ att databasen är skapad

2. **FFmpeg-fel**
   - Installera FFmpeg
   - Ställ in FFmpeg-sökväg i kod

3. **API-fel**
   - Kontrollera API-nycklar
   - Överväg API-begränsningar

4. **Webhook-fel**
   - Kontrollera SSL-certifikat
   - Ställ in korrekt webhook-URL

## Support

För support och felrapporter, kontakta utvecklaren.

## Licens

Detta projekt är licensierad under MIT-licensen.
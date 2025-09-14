# Telegram Musikgenkendelse Bot

Denne Telegram-bot kan identificere musik fra Instagram Reels. Brugere kan sende Instagram Reels-links og boten vil identificere sangnavnet og kunstneren.

## Funktioner

- 🎵 Musikgenkendelse fra Instagram Reels
- 🎤 Vis kunstner og sangnavn
- 💿 Vis albuminformation (hvis tilgængelig)
- 📅 Vis udgivelsesår
- 🎯 Vis tillidsprocent
- 💾 Gem historik i database
- 🔒 Høj sikkerhed og databeskyttelse

## Krav

- PHP 7.4 eller højere
- MySQL 5.7 eller højere
- FFmpeg (til at ekstrahere lyd fra video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL-certifikat (til webhook)

## Installation

### 1. Upload Filer

Upload alle projektfiler til din cPanel-vært.

### 2. Kør Installation

Kør `install.php` i din browser for at tjekke krav.

### 3. Konfigurer Database

1. Opret MySQL-database
2. Rediger `config.php` og indtast databaseinformation

### 4. Opret Telegram-bot

1. Chat med [@BotFather](https://t.me/botfather) på Telegram
2. Send `/newbot` kommando
3. Vælg botnavn og brugernavn
4. Kopier bot-token
5. Indtast token i `config.php`

### 5. Konfigurer API:er

#### Instagram Basic Display API
1. Gå til [Facebook Developers](https://developers.facebook.com/)
2. Opret ny applikation
3. Tilføj Instagram Basic Display
4. Få API-nøgle

#### ACRCloud API (Musikgenkendelse)
1. Gå til [ACRCloud](https://www.acrcloud.com/)
2. Opret konto
3. Få API-nøgle

### 6. Konfigurer Webhook

Kør `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Test Bot

Kør `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Brug

1. Find boten på Telegram
2. Send `/start` kommando
3. Send Instagram Reels-link
4. Vent på musikgenkendelse

## Filstruktur

```
/
├── config.php              # Hovedkonfiguration
├── database.php            # Database-klasse
├── instagram_handler.php   # Instagram-behandling
├── music_recognizer.php    # Musikgenkendelse
├── telegram_bot.php        # Telegram-bot-klasse
├── webhook.php            # Webhook-håndterer
├── setup.php              # Indstillinger
├── test.php               # Bot-testing
├── install.php            # Installation
├── index.php              # Hovedside
└── README.md              # Dokumentation
```

## Understøttede API:er

### Musikgenkendelse
- **ACRCloud**: Hovedtjeneste for musikgenkendelse
- **Shazam**: ACRCloud-alternativ

### Instagram
- **Instagram Basic Display API**: Adgang til Instagram-indhold

## Avancerede Indstillinger

### Fillimiter
I `.htaccess`-fil:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sikkerhed
- Beskyt `config.php` mod offentlig adgang
- Brug gyldigt SSL-certifikat
- Vælg stærke adgangskoder

## Fejlfinding

### Almindelige Problemer

1. **Databaseforbindelsesfejl**
   - Tjek databaseinformation
   - Sørg for at databasen er oprettet

2. **FFmpeg-fejl**
   - Installer FFmpeg
   - Sæt FFmpeg-sti i kode

3. **API-fejl**
   - Tjek API-nøgler
   - Overvej API-begrænsninger

4. **Webhook-fejl**
   - Tjek SSL-certifikat
   - Sæt korrekt webhook-URL

## Support

For support og fejlrapporter, kontakt udvikleren.

## Licens

Dette projekt er licenseret under MIT-licensen.
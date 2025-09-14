# Telegram Muziekherkenning Bot

Deze Telegram bot kan muziek herkennen uit Instagram Reels. Gebruikers kunnen Instagram Reels links sturen en de bot zal de songnaam en artiest identificeren.

## Functies

- 🎵 Muziekherkenning uit Instagram Reels
- 🎤 Artiest en songnaam weergeven
- 💿 Albuminformatie weergeven (indien beschikbaar)
- 📅 Uitgavejaar weergeven
- 🎯 Vertrouwenspercentage weergeven
- 💾 Geschiedenis opslaan in database
- 🔒 Hoge beveiliging en gegevensbescherming

## Vereisten

- PHP 7.4 of hoger
- MySQL 5.7 of hoger
- FFmpeg (voor audio-extractie uit video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL Certificaat (voor webhook)

## Installatie

### 1. Bestanden Uploaden

Upload alle projectbestanden naar uw cPanel host.

### 2. Installatie Uitvoeren

Voer `install.php` uit in uw browser om vereisten te controleren.

### 3. Database Instellen

1. MySQL database aanmaken
2. `config.php` bewerken en database-informatie invoeren

### 4. Telegram Bot Aanmaken

1. Chatten met [@BotFather](https://t.me/botfather) op Telegram
2. `/newbot` commando sturen
3. Bot naam en gebruikersnaam kiezen
4. Bot token kopiëren
5. Token invoeren in `config.php`

### 5. API's Instellen

#### Instagram Basic Display API
1. Ga naar [Facebook Developers](https://developers.facebook.com/)
2. Nieuwe applicatie aanmaken
3. Instagram Basic Display toevoegen
4. API sleutel verkrijgen

#### ACRCloud API (Muziekherkenning)
1. Ga naar [ACRCloud](https://www.acrcloud.com/)
2. Account aanmaken
3. API sleutel verkrijgen

### 6. Webhook Instellen

Voer `setup.php` uit:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot Testen

Voer `test.php` uit:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Gebruik

1. Bot vinden op Telegram
2. `/start` commando sturen
3. Instagram Reels link sturen
4. Wachten op muziekherkenning

## Bestandsstructuur

```
/
├── config.php              # Hoofdconfiguratie
├── database.php            # Database klasse
├── instagram_handler.php   # Instagram verwerking
├── music_recognizer.php    # Muziekherkenning
├── telegram_bot.php        # Telegram bot klasse
├── webhook.php            # Webhook handler
├── setup.php              # Instellingen
├── test.php               # Bot testen
├── install.php            # Installatie
├── index.php              # Hoofdpagina
└── README.md              # Documentatie
```

## Ondersteunde API's

### Muziekherkenning
- **ACRCloud**: Hoofdservice voor muziekherkenning
- **Shazam**: ACRCloud alternatief

### Instagram
- **Instagram Basic Display API**: Toegang tot Instagram content

## Geavanceerde Instellingen

### Bestandslimieten
In `.htaccess` bestand:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Beveiliging
- `config.php` beschermen tegen publieke toegang
- Geldig SSL certificaat gebruiken
- Sterke wachtwoorden kiezen

## Probleemoplossing

### Veelvoorkomende Problemen

1. **Database Verbindingsfout**
   - Database informatie controleren
   - Zorgen dat database is aangemaakt

2. **FFmpeg Fout**
   - FFmpeg installeren
   - FFmpeg pad instellen in code

3. **API Fout**
   - API sleutels controleren
   - API limieten overwegen

4. **Webhook Fout**
   - SSL certificaat controleren
   - Juiste webhook URL instellen

## Ondersteuning

Voor ondersteuning en bug rapporten, neem contact op met de ontwikkelaar.

## Licentie

Dit project is gelicentieerd onder de MIT Licentie.
# Telegram Musikkjenning Bot

Denne Telegram-boten kan identifisere musikk fra Instagram Reels. Brukere kan sende Instagram Reels-lenker og boten vil identifisere sangnavnet og artisten.

## Funksjoner

- 🎵 Musikkjenning fra Instagram Reels
- 🎤 Vise artist og sangnavn
- 💿 Vise albuminformasjon (hvis tilgjengelig)
- 📅 Vise utgivelsesår
- 🎯 Vise tillitsprosent
- 💾 Lagre historikk i database
- 🔒 Høy sikkerhet og databeskyttelse

## Krav

- PHP 7.4 eller høyere
- MySQL 5.7 eller høyere
- FFmpeg (for å ekstrahere lyd fra video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL-sertifikat (for webhook)

## Installasjon

### 1. Last Opp Filer

Last opp alle prosjektfiler til din cPanel-vert.

### 2. Kjør Installasjon

Kjør `install.php` i nettleseren for å sjekke krav.

### 3. Konfigurer Database

1. Opprett MySQL-database
2. Rediger `config.php` og skriv inn databaseinformasjon

### 4. Opprett Telegram-bot

1. Chat med [@BotFather](https://t.me/botfather) på Telegram
2. Send `/newbot` kommando
3. Velg botnavn og brukernavn
4. Kopier bot-token
5. Skriv inn token i `config.php`

### 5. Konfigurer API:er

#### Instagram Basic Display API
1. Gå til [Facebook Developers](https://developers.facebook.com/)
2. Opprett ny applikasjon
3. Legg til Instagram Basic Display
4. Få API-nøkkel

#### ACRCloud API (Musikkjenning)
1. Gå til [ACRCloud](https://www.acrcloud.com/)
2. Opprett konto
3. Få API-nøkkel

### 6. Konfigurer Webhook

Kjør `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Test Bot

Kjør `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Bruk

1. Finn boten på Telegram
2. Send `/start` kommando
3. Send Instagram Reels-lenke
4. Vent på musikkjenning

## Filstruktur

```
/
├── config.php              # Hovedkonfigurasjon
├── database.php            # Database-klasse
├── instagram_handler.php   # Instagram-behandling
├── music_recognizer.php    # Musikkjenning
├── telegram_bot.php        # Telegram-bot-klasse
├── webhook.php            # Webhook-håndterer
├── setup.php              # Innstillinger
├── test.php               # Bot-testing
├── install.php            # Installasjon
├── index.php              # Hovedside
└── README.md              # Dokumentasjon
```

## Støttede API:er

### Musikkjenning
- **ACRCloud**: Hovedtjeneste for musikkjenning
- **Shazam**: ACRCloud-alternativ

### Instagram
- **Instagram Basic Display API**: Tilgang til Instagram-innhold

## Avanserte Innstillinger

### Fillimiter
I `.htaccess`-fil:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sikkerhet
- Beskytt `config.php` fra offentlig tilgang
- Bruk gyldig SSL-sertifikat
- Velg sterke passord

## Feilsøking

### Vanlige Problemer

1. **Databaseforbindelsesfeil**
   - Sjekk databaseinformasjon
   - Sørg for at databasen er opprettet

2. **FFmpeg-feil**
   - Installer FFmpeg
   - Sett FFmpeg-sti i kode

3. **API-feil**
   - Sjekk API-nøkler
   - Vurder API-begrensninger

4. **Webhook-feil**
   - Sjekk SSL-sertifikat
   - Sett korrekt webhook-URL

## Support

For support og feilrapporter, kontakt utvikleren.

## Lisens

Dette prosjektet er lisensiert under MIT-lisensen.
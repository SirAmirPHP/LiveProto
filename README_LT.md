# Telegram Muzikos Atpažinimo Bot

Šis Telegram botas gali identifikuoti muziką iš Instagram Reels. Naudotojai gali siųsti Instagram Reels nuorodas ir botas identifikuos dainos pavadinimą ir atlikėją.

## Funkcijos

- 🎵 Muzikos atpažinimas iš Instagram Reels
- 🎤 Atlikėjo ir dainos pavadinimo rodymas
- 💿 Albumo informacijos rodymas (jei prieinama)
- 📅 Išleidimo metų rodymas
- 🎯 Pasitikėjimo procento rodymas
- 💾 Istorijos išsaugojimas duomenų bazėje
- 🔒 Aukštas saugumas ir duomenų apsauga

## Reikalavimai

- PHP 7.4 ar aukštesnė
- MySQL 5.7 ar aukštesnė
- FFmpeg (garso ištraukimui iš vaizdo)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL sertifikatas (webhook)

## Instaliacija

### 1. Failų Įkėlimas

Įkelkite visus projekto failus į savo cPanel hostą.

### 2. Instaliacijos Paleidimas

Paleiskite `install.php` savo naršyklėje, kad patikrintumėte reikalavimus.

### 3. Duomenų Bazės Nustatymas

1. Sukurkite MySQL duomenų bazę
2. Redaguokite `config.php` ir įveskite duomenų bazės informaciją

### 4. Telegram Boto Sukūrimas

1. Kalbėkitės su [@BotFather](https://t.me/botfather) Telegram
2. Siųskite `/newbot` komandą
3. Pasirinkite boto vardą ir vartotojo vardą
4. Nukopijuokite boto tokeną
5. Įveskite tokeną į `config.php`

### 5. API Nustatymas

#### Instagram Basic Display API
1. Eikite į [Facebook Developers](https://developers.facebook.com/)
2. Sukurkite naują programą
3. Pridėkite Instagram Basic Display
4. Gaukite API raktą

#### ACRCloud API (Muzikos Atpažinimas)
1. Eikite į [ACRCloud](https://www.acrcloud.com/)
2. Sukurkite paskyrą
3. Gaukite API raktą

### 6. Webhook Nustatymas

Paleiskite `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Boto Testavimas

Paleiskite `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Naudojimas

1. Raskite botą Telegram
2. Siųskite `/start` komandą
3. Siųskite Instagram Reels nuorodą
4. Laukite muzikos atpažinimo

## Failų Struktūra

```
/
├── config.php              # Pagrindinė konfigūracija
├── database.php            # Duomenų bazės klasė
├── instagram_handler.php   # Instagram apdorojimas
├── music_recognizer.php    # Muzikos atpažinimas
├── telegram_bot.php        # Telegram boto klasė
├── webhook.php            # Webhook tvarkyklė
├── setup.php              # Nustatymai
├── test.php               # Boto testavimas
├── install.php            # Instaliacija
├── index.php              # Pagrindinis puslapis
└── README.md              # Dokumentacija
```

## Palaikomi API

### Muzikos Atpažinimas
- **ACRCloud**: Pagrindinis muzikos atpažinimo servisas
- **Shazam**: ACRCloud alternatyva

### Instagram
- **Instagram Basic Display API**: Prieiga prie Instagram turinio

## Papildomi Nustatymai

### Failų Ribotai
`.htaccess` faile:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Saugumas
- Apsaugokite `config.php` nuo viešos prieigos
- Naudokite galiojantį SSL sertifikatą
- Pasirinkite stiprius slaptažodžius

## Problemų Sprendimas

### Dažnos Problemos

1. **Duomenų Bazės Ryšio Klaida**
   - Patikrinkite duomenų bazės informaciją
   - Įsitikinkite, kad duomenų bazė sukurta

2. **FFmpeg Klaida**
   - Įdiekite FFmpeg
   - Nustatykite FFmpeg kelią kode

3. **API Klaida**
   - Patikrinkite API raktus
   - Apsvarstykite API apribojimus

4. **Webhook Klaida**
   - Patikrinkite SSL sertifikatą
   - Nustatykite teisingą webhook URL

## Palaikymas

Palaikymui ir klaidų pranešimams susisiekite su kūrėju.

## Licencija

Šis projektas licencijuotas pagal MIT licenciją.
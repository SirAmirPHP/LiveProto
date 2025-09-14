# Telegram Musiek Herkenning Bot

Hierdie Telegram bot kan musiek herken vanaf Instagram Reels. Gebruikers kan Instagram Reels skakels stuur en die bot sal die liedjie naam en kunstenaar identifiseer.

## Kenmerke

- 🎵 Musiek herkenning vanaf Instagram Reels
- 🎤 Wys die kunstenaar en liedjie naam
- 💿 Wys album inligting (indien beskikbaar)
- 📅 Wys publikasie jaar
- 🎯 Wys vertroue persentasie
- 💾 Stoor geskiedenis in databasis
- 🔒 Hoë sekuriteit en data beskerming

## Vereistes

- PHP 7.4 of hoër
- MySQL 5.7 of hoër
- FFmpeg (om klank uit video te onttrek)
- PHP Uitbreidings: curl, json, pdo, pdo_mysql
- SSL sertifikaat (vir webhook)

## Installasie

### 1. Laai Lêers Op

Laai alle projek lêers op jou cPanel host.

### 2. Voer Installasie Uit

Voer `install.php` uit in jou blaaier om vereistes te verifieer.

### 3. Konfigureer Databasis

1. Skep 'n MySQL databasis
2. Redigeer `config.php` en voer databasis inligting in

### 4. Skep Telegram Bot

1. Praat met [@BotFather](https://t.me/botfather) op Telegram
2. Stuur `/newbot` bevel
3. Kies bot naam en gebruikersnaam
4. Kopieer bot token
5. Voer token in `config.php` in

### 5. Konfigureer APIs

#### Instagram Basic Display API
1. Gaan na [Facebook Developers](https://developers.facebook.com/)
2. Skep nuwe toepassing
3. Voeg Instagram Basic Display by
4. Kry API sleutel

#### ACRCloud API (Musiek Herkenning)
1. Gaan na [ACRCloud](https://www.acrcloud.com/)
2. Skep rekening
3. Kry API sleutel

### 6. Konfigureer Webhook

Voer `setup.php` uit:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Toets Bot

Voer `test.php` uit:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Gebruik

1. Vind die bot op Telegram
2. Stuur `/start` bevel
3. Stuur Instagram Reels skakel
4. Wag vir musiek herkenning

## Lêer Struktuur

```
/
├── config.php              # Hoof konfigurasie
├── database.php            # Databasis klas
├── instagram_handler.php   # Instagram verwerking
├── music_recognizer.php    # Musiek herkenning
├── telegram_bot.php        # Telegram bot klas
├── webhook.php            # Webhook bestuurder
├── setup.php              # Konfigurasie
├── test.php               # Bot toets
├── install.php            # Installasie
├── index.php              # Hoof bladsy
└── README.md              # Dokumentasie
```

## Ondersteunde APIs

### Musiek Herkenning
- **ACRCloud**: Hoof musiek herkenning diens
- **Shazam**: ACRCloud alternatief

### Instagram
- **Instagram Basic Display API**: Toegang tot Instagram inhoud

## Gevorderde Konfigurasie

### Lêer Limiete
In `.htaccess` lêer:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sekuriteit
- Beskerm `config.php` teen publieke toegang
- Gebruik geldige SSL sertifikaat
- Kies sterk wagwoorde

## Probleem Oplossing

### Algemene Probleme

1. **Databasis Verbinding Fout**
   - Verifieer databasis inligting
   - Maak seker databasis is geskep

2. **FFmpeg Fout**
   - Installeer FFmpeg
   - Stel FFmpeg pad in kode

3. **API Fout**
   - Verifieer API sleutels
   - Oorweeg API limiete

4. **Webhook Fout**
   - Verifieer SSL sertifikaat
   - Stel webhook URL korrek

## Ondersteuning

Vir ondersteuning en fout verslae, kontak die ontwikkelaar.

## Lisensie

Hierdie projek is gelisensieer onder MIT Lisensie.
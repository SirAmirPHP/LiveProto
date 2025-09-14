# Telegram Bot fyrir Tónlistarþekkingu

Þessi Telegram bot getur þekkt tónlist úr Instagram Reels. Notendur geta sent Instagram Reels tengla og botinn mun þekkja nafn lagsins og listamanninn.

## Eiginleikar

- 🎵 Tónlistarþekking úr Instagram Reels
- 🎤 Sýna nafn listamanns og lags
- 💿 Sýna upplýsingar um plötu (ef tiltækar)
- 📅 Sýna útgáfuár
- 🎯 Sýna traustshlutfall
- 💾 Vista sögu í gagnagrunni
- 🔒 Hár öryggi og gagnavörn

## Kröfur

- PHP 7.4 eða hærra
- MySQL 5.7 eða hærra
- FFmpeg (til að draga út hljóð úr myndskeiði)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL vottorð (fyrir webhook)

## Uppsetning

### 1. Hlaða inn Skrám

Hlaðið inn öllum skrám verkefnisins á cPanel hýslið ykkar.

### 2. Keyra Uppsetningu

Keyrið `install.php` í vafranum ykkar til að athuga kröfurnar.

### 3. Stilla Gagnagrunn

1. Búið til MySQL gagnagrunn
2. Breytið `config.php` og færið inn gagnagrunnsupplýsingar

### 4. Búa til Telegram Bot

1. Spjallaðu við [@BotFather](https://t.me/botfather) á Telegram
2. Sendu `/newbot` skipun
3. Veldu nafn botsins og notandanafn
4. Afritaðu bot token
5. Færðu token inn í `config.php`

### 5. Stilla API

#### Instagram Basic Display API
1. Farðu á [Facebook Developers](https://developers.facebook.com/)
2. Búðu til nýja forrit
3. Bættu við Instagram Basic Display
4. Fáðu API lykil

#### ACRCloud API (Tónlistarþekking)
1. Farðu á [ACRCloud](https://www.acrcloud.com/)
2. Búðu til reikning
3. Fáðu API lykil

### 6. Stilla Webhook

Keyrið `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Prófa Bot

Keyrið `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Notkun

1. Finndu botinn á Telegram
2. Sendu `/start` skipun
3. Sendu Instagram Reels tengil
4. Bíddu eftir tónlistarþekkingu

## Skráaruppbygging

```
/
├── config.php              # Aðalstillingar
├── database.php            # Gagnagrunnsflokkur
├── instagram_handler.php   # Instagram vinnsla
├── music_recognizer.php    # Tónlistarþekking
├── telegram_bot.php        # Telegram bot flokkur
├── webhook.php            # Webhook vinnsluvefur
├── setup.php              # Stillingar
├── test.php               # Bot prófun
├── install.php            # Uppsetning
├── index.php              # Aðalsíða
└── README.md              # Skjöl
```

## Stuðlaðir API

### Tónlistarþekking
- **ACRCloud**: Aðalþjónusta tónlistarþekkingar
- **Shazam**: ACRCloud valkostur

### Instagram
- **Instagram Basic Display API**: Aðgangur að Instagram efni

## Ítarlegar Stillingar

### Skráartakmarkanir
Í `.htaccess` skrá:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Öryggi
- Verndaðu `config.php` fyrir opinberum aðgangi
- Notaðu gilt SSL vottorð
- Veldu sterk lykilorð

## Vandamálalausn

### Algeng Vandamál

1. **Gagnagrunnstengingu Villa**
   - Athugaðu gagnagrunnsupplýsingar
   - Gakktu úr skugga um að gagnagrunnurinn sé búinn til

2. **FFmpeg Villa**
   - Setja upp FFmpeg
   - Stilltu FFmpeg slóð í kóðanum

3. **API Villa**
   - Athugaðu API lykla
   - Hugsaðu um API takmarkanir

4. **Webhook Villa**
   - Athugaðu SSL vottorð
   - Stilltu rétta webhook URL

## Aðstoð

Fyrir aðstoð og villuskýrslur, vinsamlegast hafðu samband við forritarann.

## Leyfi

Þetta verkefni er leyfð undir MIT leyfi.
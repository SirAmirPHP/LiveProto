# Telegram Bot za Prepoznavanje Glasbe

Ta Telegram bot lahko identificira glasbo iz Instagram Reels. Uporabniki lahko pošljejo Instagram Reels povezave in bot bo identificiral ime pesmi in izvajalca.

## Funkcije

- 🎵 Prepoznavanje glasbe iz Instagram Reels
- 🎤 Prikazovanje imena izvajalca in pesmi
- 💿 Prikazovanje informacij o albumu (če je na voljo)
- 📅 Prikazovanje leta izdaje
- 🎯 Prikazovanje odstotka zaupanja
- 💾 Shranjevanje zgodovine v bazo podatkov
- 🔒 Visoka varnost in varstvo podatkov

## Zahteve

- PHP 7.4 ali višji
- MySQL 5.7 ali višji
- FFmpeg (za ekstrakcijo zvoka iz videa)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL certifikat (za webhook)

## Namestitev

### 1. Nalaganje Datotek

Naložite vse datoteke projekta na vaš cPanel gostitelj.

### 2. Zagon Namestitve

Zaženite `install.php` v vašem brskalniku za preverjanje zahtev.

### 3. Nastavitev Baze Podatkov

1. Ustvarite MySQL bazo podatkov
2. Uredite `config.php` in vnesite informacije o bazi podatkov

### 4. Ustvarjanje Telegram Bota

1. Pogovorite se z [@BotFather](https://t.me/botfather) na Telegramu
2. Pošljite `/newbot` ukaz
3. Izberite ime bota in uporabniško ime
4. Kopirajte token bota
5. Vnesite token v `config.php`

### 5. Nastavitev API-jev

#### Instagram Basic Display API
1. Pojdite na [Facebook Developers](https://developers.facebook.com/)
2. Ustvarite novo aplikacijo
3. Dodajte Instagram Basic Display
4. Pridobite API ključ

#### ACRCloud API (Prepoznavanje Glasbe)
1. Pojdite na [ACRCloud](https://www.acrcloud.com/)
2. Ustvarite račun
3. Pridobite API ključ

### 6. Nastavitev Webhook-a

Zaženite `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testiranje Bota

Zaženite `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Uporaba

1. Poiščite bot na Telegramu
2. Pošljite `/start` ukaz
3. Pošljite Instagram Reels povezavo
4. Počakajte na prepoznavanje glasbe

## Struktura Datotek

```
/
├── config.php              # Glavna konfiguracija
├── database.php            # Razred baze podatkov
├── instagram_handler.php   # Obdelava Instagrama
├── music_recognizer.php    # Prepoznavanje glasbe
├── telegram_bot.php        # Razred Telegram bota
├── webhook.php            # Upravljalec webhook-a
├── setup.php              # Nastavitve
├── test.php               # Testiranje bota
├── install.php            # Namestitev
├── index.php              # Glavna stran
└── README.md              # Dokumentacija
```

## Podprti API-ji

### Prepoznavanje Glasbe
- **ACRCloud**: Glavna storitev za prepoznavanje glasbe
- **Shazam**: ACRCloud alternativa

### Instagram
- **Instagram Basic Display API**: Dostop do vsebine Instagrama

## Napredne Nastavitve

### Omejitve Datotek
V `.htaccess` datoteki:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Varnost
- Zaščitite `config.php` pred javnim dostopom
- Uporabite veljaven SSL certifikat
- Izberite močna gesla

## Reševanje Težav

### Pogoste Težave

1. **Napaka Povezave z Bazo Podatkov**
   - Preverite informacije o bazi podatkov
   - Prepričajte se, da je baza podatkov ustvarjena

2. **FFmpeg Napaka**
   - Namestite FFmpeg
   - Nastavite pot FFmpeg v kodi

3. **API Napaka**
   - Preverite API ključe
   - Razmislite o omejitvah API-ja

4. **Webhook Napaka**
   - Preverite SSL certifikat
   - Nastavite pravilno webhook URL

## Podpora

Za podporo in poročanje napak se obrnite na razvijalca.

## Licenca

Ta projekt je licenciran pod MIT licenco.
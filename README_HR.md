# Telegram Bot za Prepoznavanje Glazbe

Ovaj Telegram bot može identificirati glazbu iz Instagram Reels. Korisnici mogu slati Instagram Reels linkove i bot će identificirati naziv pjesme i izvođača.

## Funkcije

- 🎵 Prepoznavanje glazbe iz Instagram Reels
- 🎤 Prikazivanje naziva izvođača i pjesme
- 💿 Prikazivanje informacija o albumu (ako je dostupno)
- 📅 Prikazivanje godine izdanja
- 🎯 Prikazivanje postotka pouzdanosti
- 💾 Spremanje povijesti u bazu podataka
- 🔒 Visoka sigurnost i zaštita podataka

## Zahtjevi

- PHP 7.4 ili viši
- MySQL 5.7 ili viši
- FFmpeg (za izdvajanje audio iz videa)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL certifikat (za webhook)

## Instalacija

### 1. Učitavanje Datoteka

Učitajte sve datoteke projekta na vaš cPanel host.

### 2. Pokretanje Instalacije

Pokrenite `install.php` u vašem pregledniku za provjeru zahtjeva.

### 3. Postavljanje Baze Podataka

1. Stvorite MySQL bazu podataka
2. Uredite `config.php` i unesite informacije o bazi podataka

### 4. Stvaranje Telegram Bota

1. Razgovarajte s [@BotFather](https://t.me/botfather) na Telegramu
2. Pošaljite `/newbot` naredbu
3. Odaberite ime bota i korisničko ime
4. Kopirajte token bota
5. Unesite token u `config.php`

### 5. Postavljanje API-ja

#### Instagram Basic Display API
1. Idite na [Facebook Developers](https://developers.facebook.com/)
2. Stvorite novu aplikaciju
3. Dodajte Instagram Basic Display
4. Dobijte API ključ

#### ACRCloud API (Prepoznavanje Glazbe)
1. Idite na [ACRCloud](https://www.acrcloud.com/)
2. Stvorite račun
3. Dobijte API ključ

### 6. Postavljanje Webhook-a

Pokrenite `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testiranje Bota

Pokrenite `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Korištenje

1. Pronađite bot na Telegramu
2. Pošaljite `/start` naredbu
3. Pošaljite Instagram Reels link
4. Čekajte prepoznavanje glazbe

## Struktura Datoteka

```
/
├── config.php              # Glavna konfiguracija
├── database.php            # Klasa baze podataka
├── instagram_handler.php   # Obrada Instagrama
├── music_recognizer.php    # Prepoznavanje glazbe
├── telegram_bot.php        # Klasa Telegram bota
├── webhook.php            # Rukovalac webhook-a
├── setup.php              # Postavke
├── test.php               # Testiranje bota
├── install.php            # Instalacija
├── index.php              # Glavna stranica
└── README.md              # Dokumentacija
```

## Podržani API-ji

### Prepoznavanje Glazbe
- **ACRCloud**: Glavna usluga prepoznavanja glazbe
- **Shazam**: ACRCloud alternativa

### Instagram
- **Instagram Basic Display API**: Pristup sadržaju Instagrama

## Napredne Postavke

### Ograničenja Datoteka
U `.htaccess` datoteci:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sigurnost
- Zaštitite `config.php` od javnog pristupa
- Koristite valjani SSL certifikat
- Odaberite jake lozinke

## Rješavanje Problema

### Uobičajeni Problemi

1. **Greška Povezivanja s Bazom Podataka**
   - Provjerite informacije o bazi podataka
   - Uvjerite se da je baza podataka stvorena

2. **FFmpeg Greška**
   - Instalirajte FFmpeg
   - Postavite putanju FFmpeg u kodu

3. **API Greška**
   - Provjerite API ključeve
   - Razmotrite ograničenja API-ja

4. **Webhook Greška**
   - Provjerite SSL certifikat
   - Postavite ispravnu webhook URL

## Podrška

Za podršku i prijavu grešaka, molimo kontaktirajte programera.

## Licenca

Ovaj projekt je licenciran pod MIT licencom.
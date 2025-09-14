# Telegram Musiikkitunnistus Botti

Tämä Telegram-botti voi tunnistaa musiikkia Instagram Reelsistä. Käyttäjät voivat lähettää Instagram Reels-linkkejä ja botti tunnistaa kappaleen nimen ja artistin.

## Ominaisuudet

- 🎵 Musiikkitunnistus Instagram Reelsistä
- 🎤 Näytä artisti ja kappaleen nimi
- 💿 Näytä albumin tiedot (jos saatavilla)
- 📅 Näytä julkaisuvuosi
- 🎯 Näytä luottamusprosentti
- 💾 Tallenna historia tietokantaan
- 🔒 Korkea turvallisuus ja tietosuoja

## Vaatimukset

- PHP 7.4 tai uudempi
- MySQL 5.7 tai uudempi
- FFmpeg (äänen poistamiseen videosta)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL-sertifikaatti (webhookille)

## Asennus

### 1. Lataa Tiedostot

Lataa kaikki projektitiedostot cPanel-isäntään.

### 2. Suorita Asennus

Suorita `install.php` selaimessa tarkistaaksesi vaatimukset.

### 3. Aseta Tietokanta

1. Luo MySQL-tietokanta
2. Muokkaa `config.php` ja syötä tietokantatiedot

### 4. Luo Telegram-botti

1. Keskustele [@BotFather](https://t.me/botfather) kanssa Telegramissa
2. Lähetä `/newbot` komento
3. Valitse botin nimi ja käyttäjänimi
4. Kopioi bot-token
5. Syötä token `config.php`:hen

### 5. Aseta API:t

#### Instagram Basic Display API
1. Mene [Facebook Developers](https://developers.facebook.com/):iin
2. Luo uusi sovellus
3. Lisää Instagram Basic Display
4. Hae API-avain

#### ACRCloud API (Musiikkitunnistus)
1. Mene [ACRCloud](https://www.acrcloud.com/):iin
2. Luo tili
3. Hae API-avain

### 6. Aseta Webhook

Suorita `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testaa Botti

Suorita `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Käyttö

1. Etsi botti Telegramista
2. Lähetä `/start` komento
3. Lähetä Instagram Reels-linkki
4. Odota musiikkitunnistusta

## Tiedostorakenne

```
/
├── config.php              # Pääkonfiguraatio
├── database.php            # Tietokantaluokka
├── instagram_handler.php   # Instagram-käsittely
├── music_recognizer.php    # Musiikkitunnistus
├── telegram_bot.php        # Telegram-botti-luokka
├── webhook.php            # Webhook-käsittelijä
├── setup.php              # Asetukset
├── test.php               # Botin testaus
├── install.php            # Asennus
├── index.php              # Pääsivu
└── README.md              # Dokumentaatio
```

## Tuetut API:t

### Musiikkitunnistus
- **ACRCloud**: Päämusiikkitunnistuspalvelu
- **Shazam**: ACRCloud-vaihtoehto

### Instagram
- **Instagram Basic Display API**: Pääsy Instagram-sisältöön

## Edistyneet Asetukset

### Tiedostorajoitukset
`.htaccess`-tiedostossa:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Turvallisuus
- Suojaa `config.php` julkiselta pääsyltä
- Käytä voimassa olevaa SSL-sertifikaattia
- Valitse vahvat salasanat

## Vianmääritys

### Yleiset Ongelmat

1. **Tietokantayhteyden Virhe**
   - Tarkista tietokantatiedot
   - Varmista, että tietokanta on luotu

2. **FFmpeg-virhe**
   - Asenna FFmpeg
   - Aseta FFmpeg-polku koodissa

3. **API-virhe**
   - Tarkista API-avaimet
   - Harkitse API-rajoituksia

4. **Webhook-virhe**
   - Tarkista SSL-sertifikaatti
   - Aseta oikea webhook-URL

## Tuki

Tuen ja virheraporttien saamiseksi ota yhteyttä kehittäjään.

## Lisenssi

Tämä projekti on lisensoitu MIT-lisenssillä.
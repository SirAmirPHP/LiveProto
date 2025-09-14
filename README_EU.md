# Telegram Musika Ezagutzeko Bot

Telegram bot honek musika identifika dezake Instagram Reels-etik. Erabiltzaileek Instagram Reels estekak bidal ditzakete eta bot-ak abestiaren izena eta artista identifikatuko ditu.

## Ezaugarriak

- 🎵 Musika ezagutzea Instagram Reels-etik
- 🎤 Artista eta abestiaren izena erakustea
- 💿 Albumaren informazioa erakustea (eskuragarri badago)
- 📅 Argitalpen urtea erakustea
- 🎯 Konfiantza portzentajea erakustea
- 💾 Historia datu-basean gordetzea
- 🔒 Segurtasun handia eta datuen babesa

## Baldintzak

- PHP 7.4 edo handiagoa
- MySQL 5.7 edo handiagoa
- FFmpeg (audioa bideotik ateratzeko)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL ziurtagiria (webhook-erako)

## Instalazioa

### 1. Fitxategiak Igo

Igo proiektuaren fitxategi guztiak zure cPanel ostalarian.

### 2. Instalazioa Exekutatu

Exekutatu `install.php` zure nabigatzailean baldintzak egiaztatzeko.

### 3. Datu-basea Konfiguratu

1. Sortu MySQL datu-basea
2. Editatu `config.php` eta sartu datu-basearen informazioa

### 4. Telegram Bot Sortu

1. Hizket egin [@BotFather](https://t.me/botfather)-ekin Telegram-en
2. Bidali `/newbot` komandoa
3. Aukeratu bot-aren izena eta erabiltzaile izena
4. Kopiatu bot-aren tokena
5. Sartu tokena `config.php`-n

### 5. API-ak Konfiguratu

#### Instagram Basic Display API
1. Joan [Facebook Developers](https://developers.facebook.com/)-era
2. Sortu aplikazio berria
3. Gehitu Instagram Basic Display
4. Lortu API gakoa

#### ACRCloud API (Musika Ezagutzea)
1. Joan [ACRCloud](https://www.acrcloud.com/)-era
2. Sortu kontua
3. Lortu API gakoa

### 6. Webhook Konfiguratu

Exekutatu `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot Probatu

Exekutatu `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Erabilera

1. Aurkitu bot-a Telegram-en
2. Bidali `/start` komandoa
3. Bidali Instagram Reels esteka
4. Itxaron musika ezagutzea

## Fitxategi Egitura

```
/
├── config.php              # Konfigurazio nagusia
├── database.php            # Datu-base klasea
├── instagram_handler.php   # Instagram prozesamendua
├── music_recognizer.php    # Musika ezagutzea
├── telegram_bot.php        # Telegram bot klasea
├── webhook.php            # Webhook kudeatzailea
├── setup.php              # Ezarpenak
├── test.php               # Bot probaketa
├── install.php            # Instalazioa
├── index.php              # Orri nagusia
└── README.md              # Dokumentazioa
```

## Onartutako API-ak

### Musika Ezagutzea
- **ACRCloud**: Musika ezagutze zerbitzu nagusia
- **Shazam**: ACRCloud alternatiba

### Instagram
- **Instagram Basic Display API**: Instagram edukiara sarbidea

## Aurreratutako Ezarpenak

### Fitxategi Mugak
`.htaccess` fitxategian:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Segurtasuna
- Babestu `config.php` sarbide publikoaren aurretik
- Erabili SSL ziurtagiri baliozkoa
- Aukeratu pasahitz sendoak

## Arazoak Konpontzea

### Arazo Ohikoak

1. **Datu-base Konexio Errorea**
   - Egiaztatu datu-basearen informazioa
   - Ziurtatu datu-basea sortu dela

2. **FFmpeg Errorea**
   - Instalatu FFmpeg
   - Ezarri FFmpeg bidea kodean

3. **API Errorea**
   - Egiaztatu API gakoak
   - Kontuan hartu API mugak

4. **Webhook Errorea**
   - Egiaztatu SSL ziurtagiria
   - Ezarri webhook URL zuzena

## Laguntza

Laguntza eta akats txostenetarako, jarri harremanetan garatzailearekin.

## Lizentzia

Proiektu hau MIT Lizentziapean dago lizentziatuta.
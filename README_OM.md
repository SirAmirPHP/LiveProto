# Telegram Musika Beeku Bot

Kuni Telegram bot musika beeku danda Instagram Reels irra. Fayyaawwan Instagram Reels link fudhachuun danda bot musika beeku danda.

## Qabxiiwwan

- 🎵 Musika beeku danda Instagram Reels
- 🎤 Artista fiinnaa fi musika fiinnaa agarsiisu
- 💿 Album qorannoo agarsiisu (yoo jiraate)
- 📅 Bara ba'ina agarsiisu
- 🎯 Amantiiwwan agarsiisu
- 💾 Seenaa database keessatti qabachuu
- 🔒 Eegumsa ol'aanaa fi qabxiiwwan eegumsa

## Filannoo

- PHP 7.4 ykn ol'aanaa
- MySQL 5.7 ykn ol'aanaa
- FFmpeg (sagalee video irraa baasuuf)
- PHP Dabalataawwan: curl, json, pdo, pdo_mysql
- SSL ragaa (webhook f)

## Galchi

### 1. Fayilaawwan Baasu

Fayilaawwan projektiin hundi cPanel host keessanii baasu.

### 2. Galchi Fudhachuu

`install.php` fudhachuu browser keessanii filannoo mirkaneessuuf.

### 3. Database Taa'uu

1. MySQL database uumu
2. `config.php` fooyyessuu fi database qorannoo galchi

### 4. Telegram Bot Uumu

1. [@BotFather](https://t.me/botfather) waliin Telegram keessatti dubbachuu
2. `/newbot` ajaja erguu
3. Bot maqaa fi fayyaa maqaa filachuu
4. Bot token dubbisuu
5. Token `config.php` keessatti galchi

### 5. APIs Taa'uu

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) deemu
2. Appliikeeshinii haaraa uumu
3. Instagram Basic Display dabaluu
4. API qabxii argachuu

#### ACRCloud API (Musika Beeku)
1. [ACRCloud](https://www.acrcloud.com/) deemu
2. Akkaawuntii uumu
3. API qabxii argachuu

### 6. Webhook Taa'uu

`setup.php` fudhachuu:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot Mirkaneessuu

`test.php` fudhachuu:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Fayyadama

1. Bot Telegram keessatti argachuu
2. `/start` ajaja erguu
3. Instagram Reels link erguu
4. Musika beeku eeguu

## Fayila Qaama

```
/
├── config.php              # Taa'uu ijoo
├── database.php            # Database gosa
├── instagram_handler.php   # Instagram qindeessuu
├── music_recognizer.php    # Musika beeku
├── telegram_bot.php        # Telegram bot gosa
├── webhook.php            # Webhook qindeessaa
├── setup.php              # Taa'uu
├── test.php               # Bot mirkaneessuu
├── install.php            # Galchi
├── index.php              # Fuula ijoo
└── README.md              # Barreeffama
```

## APIs Deeggarsan

### Musika Beeku
- **ACRCloud**: Tajaajila ijoo musika beeku
- **Shazam**: ACRCloud filannoo

### Instagram
- **Instagram Basic Display API**: Instagram qabxiiwwan seensuu

## Taa'uu Guddina

### Fayila Darban
Fayila `.htaccess` keessatti:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Eegumsa
- `config.php` seensuu haalaa irraa eeguu
- SSL ragaa dhugaa fayyadamu
- Jecha iccitii cimaa filachuu

## Rakkoo Foyyessuu

### Rakkoowwan Beekama

1. **Database Walqabatee Jallina**
   - Database qorannoo mirkaneessuu
   - Database uumame jiraachuu mirkaneessuu

2. **FFmpeg Jallina**
   - FFmpeg galchi
   - FFmpeg kara koodii keessatti taa'uu

3. **API Jallina**
   - API qabxiiwwan mirkaneessuu
   - API darbanii yaaduu

4. **Webhook Jallina**
   - SSL ragaa mirkaneessuu
   - Webhook URL sirrii taa'uu

## Deeggarsa

Deeggarsa fi jallina beeksisaan, qindeessaa waliin walqabatee.

## Hayyama

Projektiin kun MIT Hayyama jalatti jira.
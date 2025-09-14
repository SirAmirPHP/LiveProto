# Telegram Musika Aqoonsi Bot

Kan Telegram bot wuxuu awood u leeyahay inuu aqoonsado musika ka soo baxa Instagram Reels. Isticmaalayaasha waxay awood u yihiin inay diran xiriiriyeyaasha Instagram Reels botkuna wuxuu aqoonsan doonaa magaca heesta iyo fanaanka.

## Sifooyinka

- 🎵 Aqoonsi musika ka soo baxa Instagram Reels
- 🎤 Muujinta magaca fanaanka iyo heesta
- 💿 Muujinta macluumaadka album-ka (haddii ay jiraan)
- 📅 Muujinta sanadka daabacaadda
- 🎯 Muujinta boqolkiiba kalsoonida
- 💾 Keydinta taariikhda database-ka
- 🔒 Amniga sare iyo ilaalinta xogta

## Shuruudaha

- PHP 7.4 ama ka sarreysa
- MySQL 5.7 ama ka sarreysa
- FFmpeg (si loo soo saaro codka video-ga)
- PHP Dheeraadka: curl, json, pdo, pdo_mysql
- SSL shahaadada (webhook-ka)

## Rakibidda

### 1. Soo Geli Faylalka

Soo geli dhammaan faylalka mashruuca cPanel host-kaaga.

### 2. Fulinta Rakibidda

Fulinta `install.php` browser-kaaga si aad u xaqiijiso shuruudaha.

### 3. Habaynta Database

1. Abuur MySQL database
2. Wax ka beddel `config.php` oo geli macluumaadka database-ka

### 4. Abuur Telegram Bot

1. La hadal [@BotFather](https://t.me/botfather) Telegram-ka
2. Dir amarka `/newbot`
3. Dooro magaca bot-ka iyo magaca isticmaalaha
4. Qor bot token-ka
5. Gelinta token-ka `config.php`-ka

### 5. Habaynta APIs

#### Instagram Basic Display API
1. Tag [Facebook Developers](https://developers.facebook.com/)
2. Abuur codsi cusub
3. Ku dar Instagram Basic Display
4. Hel fure API

#### ACRCloud API (Aqoonsi Musika)
1. Tag [ACRCloud](https://www.acrcloud.com/)
2. Abuur akoon
3. Hel fure API

### 6. Habaynta Webhook

Fulinta `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Tijaabi Bot

Fulinta `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Isticmaalka

1. Hel bot-ka Telegram-ka
2. Dir amarka `/start`
3. Dir xiriiriye Instagram Reels
4. Sug aqoonsiga musika

## Qaabka Faylalka

```
/
├── config.php              # Habaynta ugu muhiimsan
├── database.php            # Fasalka database-ka
├── instagram_handler.php   # Habaynta Instagram
├── music_recognizer.php    # Aqoonsi musika
├── telegram_bot.php        # Fasalka Telegram bot
├── webhook.php            # Maamulaha webhook
├── setup.php              # Habaynta
├── test.php               # Tijaabada bot-ka
├── install.php            # Rakibidda
├── index.php              # Bogga ugu muhiimsan
└── README.md              # Dukumentaysi
```

## APIs La Taageerayo

### Aqoonsi Musika
- **ACRCloud**: Adeegga ugu muhiimsan ee aqoonsiga musika
- **Shazam**: Beddelka ACRCloud

### Instagram
- **Instagram Basic Display API**: Helitaanka waxyaabaha Instagram

## Habaynta Horumarinta

### Xadka Faylalka
Faylka `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Amniga
- Ilaali `config.php` helitaanka dadweynaha
- Isticmaal shahaadada SSL saxda ah
- Dooro erayga sirta ah oo xoog leh

## Xalinta Dhibaatooyinka

### Dhibaatooyinka Caadiga

1. **Qaladka Xidhiidhka Database**
   - Xaqiiji macluumaadka database-ka
   - Hubi in database-ka la abuuro

2. **Qaladka FFmpeg**
   - Rakib FFmpeg
   - Deji jidka FFmpeg koodka

3. **Qaladka API**
   - Xaqiiji furayaasha API
   - Tixgeli xadka API

4. **Qaladka Webhook**
   - Xaqiiji shahaadada SSL
   - Deji URL-ka webhook-ka si sax ah

## Taageero

Taageero iyo warbixinta qaladka, la xidhiidh horumaraha.

## Liisanka

Mashruucan wuxuu ku jiraa Liisanka MIT.
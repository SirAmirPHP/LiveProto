# Telegram Musika Gano Bot

Eyi Telegram bot le gba musika lati Instagram Reels. Awọn olumulo le fi awọn ọna asopọ Instagram Reels ranṣẹ ki bot yoo mọ orukọ orin ati akọrin.

## Awọn ẹya ara

- 🎵 Gano musika lati Instagram Reels
- 🎤 Ṣe afihan orukọ akọrin ati orin
- 💿 Ṣe afihan alaye album (ti o ba wa)
- 📅 Ṣe afihan ọdun iwe
- 🎯 Ṣe afihan ogorun igbagbọ
- 💾 Fi itan pa mọ ninu database
- 🔒 Giga aabo ati idabobo data

## Awọn ibeere

- PHP 7.4 tabi oke
- MySQL 5.7 tabi oke
- FFmpeg (lati ya ohun kọrin jade lati fidio)
- PHP Awọn afikun: curl, json, pdo, pdo_mysql
- SSL iwe ẹri (fun webhook)

## Fi sori

### 1. Gbe Awọn faili

Gbe gbogbo awọn faili iṣẹ sori cPanel host rẹ.

### 2. Mu Fi sori ṣiṣẹ

Mu `install.php` ṣiṣẹ ninu browser rẹ lati jẹrisi awọn ibeere.

### 3. Ṣeto Database

1. Ṣẹda MySQL database
2. Ṣatunkọ `config.php` ki o fi alaye database sinu

### 4. Ṣẹda Telegram Bot

1. Sọrọ pẹlu [@BotFather](https://t.me/botfather) lori Telegram
2. Fi aṣẹ `/newbot` ranṣẹ
3. Yan orukọ bot ati orukọ olumulo
4. Daakọ token bot
5. Fi token sinu `config.php`

### 5. Ṣeto APIs

#### Instagram Basic Display API
1. Lọ si [Facebook Developers](https://developers.facebook.com/)
2. Ṣẹda ohun elo tuntun
3. Fi Instagram Basic Display kun
4. Gba API bọtini

#### ACRCloud API (Gano Musika)
1. Lọ si [ACRCloud](https://www.acrcloud.com/)
2. Ṣẹda akọọnti
3. Gba API bọtini

### 6. Ṣeto Webhook

Mu `setup.php` ṣiṣẹ:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Danwo Bot

Mu `test.php` ṣiṣẹ:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Lilo

1. Wa bot lori Telegram
2. Fi aṣẹ `/start` ranṣẹ
3. Fi ọna asopọ Instagram Reels ranṣẹ
4. Duro fun gano musika

## Ipilẹ Faili

```
/
├── config.php              # Eto akọkọ
├── database.php            # Ẹka database
├── instagram_handler.php   # Iṣakoso Instagram
├── music_recognizer.php    # Gano musika
├── telegram_bot.php        # Ẹka Telegram bot
├── webhook.php            # Olusakoso webhook
├── setup.php              # Eto
├── test.php               # Idanwo bot
├── install.php            # Fi sori
├── index.php              # Oju-iwe akọkọ
└── README.md              # Iwe itọnisọna
```

## Awọn API ti A Ṣe atilẹyin

### Gano Musika
- **ACRCloud**: Iṣẹ akọkọ gano musika
- **Shazam**: Aiyipada ACRCloud

### Instagram
- **Instagram Basic Display API**: Wiwọle si akoonu Instagram

## Eto Giga

### Awọn aala Faili
Ninu faili `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Aabo
- Daabobo `config.php` lati wiwọle gbogbo eniyan
- Lo iwe ẹri SSL ti o tọ
- Yan awọn ọrọ aṣirin ti o lagbara

## Yiyan Awọn Iṣoro

### Awọn Iṣoro Wọpọ

1. **Aṣiṣe Igbasilẹ Database**
   - Jẹrisi alaye database
   - Rii daju pe database ti ṣẹda

2. **Aṣiṣe FFmpeg**
   - Fi FFmpeg sori
   - Ṣeto ọna FFmpeg ninu koodu

3. **Aṣiṣe API**
   - Jẹrisi awọn bọtini API
   - Ṣe laakaye awọn aala API

4. **Aṣiṣe Webhook**
   - Jẹrisi iwe ẹri SSL
   - Ṣeto URL webhook ni ọtun

## Atilẹyin

Fun atilẹyin ati awọn iroyin aṣiṣe, kan si oludagbasoke.

## Iwe ẹti

Iṣẹ yii ni a fi sori Iwe ẹti MIT.
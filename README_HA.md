# Telegram Musika Gano Bot

Wannan Telegram bot na iya gano musika daga Instagram Reels. Masu amfani za su iya aika hanyoyin Instagram Reels kuma bot zai gano sunan waƙa da mawaƙi.

## Siffofi

- 🎵 Gano musika daga Instagram Reels
- 🎤 Nuna sunan mawaƙi da waƙa
- 💿 Nuna bayanin kundi (idan akwai)
- 📅 Nuna shekarar bugawa
- 🎯 Nuna kashi na amincewa
- 💾 Adana tarihi a cikin database
- 🔒 Babban tsaro da kariyar bayanai

## Bukatu

- PHP 7.4 ko sama da haka
- MySQL 5.7 ko sama da haka
- FFmpeg (don fitar da sauti daga bidiyo)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL takardar shaida (don webhook)

## Shigarwa

### 1. Loda Fayiloli

Loda duk fayilolin aikin a kan cPanel host ɗin ku.

### 2. Aiwatar da Shigarwa

Aiwatar da `install.php` a cikin burauzar ku don tabbatar da bukatu.

### 3. Saita Database

1. Ƙirƙiri MySQL database
2. Gyara `config.php` kuma shigar da bayanin database

### 4. Ƙirƙiri Telegram Bot

1. Yi magana da [@BotFather](https://t.me/botfather) a Telegram
2. Aika umarni `/newbot`
3. Zaɓi sunan bot da sunan mai amfani
4. Kwafi token na bot
5. Shigar da token a cikin `config.php`

### 5. Saita APIs

#### Instagram Basic Display API
1. Je zuwa [Facebook Developers](https://developers.facebook.com/)
2. Ƙirƙiri sabon aikace-aikace
3. Ƙara Instagram Basic Display
4. Sami maɓallin API

#### ACRCloud API (Gano Musika)
1. Je zuwa [ACRCloud](https://www.acrcloud.com/)
2. Ƙirƙiri asusun
3. Sami maɓallin API

### 6. Saita Webhook

Aiwatar da `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Gwada Bot

Aiwatar da `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Amfani

1. Nemo bot a Telegram
2. Aika umarni `/start`
3. Aika hanyar Instagram Reels
4. Jira gano musika

## Tsarin Fayil

```
/
├── config.php              # Babban saitin
├── database.php            # Aji na database
├── instagram_handler.php   # Sarrafa Instagram
├── music_recognizer.php    # Gano musika
├── telegram_bot.php        # Aji na Telegram bot
├── webhook.php            # Mai sarrafa webhook
├── setup.php              # Saitin
├── test.php               # Gwajin bot
├── install.php            # Shigarwa
├── index.php              # Shafi na farko
└── README.md              # Takardun bayani
```

## APIs da Ake Taimakawa

### Gano Musika
- **ACRCloud**: Babban sabis na gano musika
- **Shazam**: Madadin ACRCloud

### Instagram
- **Instagram Basic Display API**: Shiga abun ciki na Instagram

## Saitin Ci Gaba

### Iyakoki na Fayil
A cikin fayil `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Tsaro
- Kare `config.php` daga shiga jama'a
- Yi amfani da ingantaccen takardar shaida ta SSL
- Zaɓi kalmar sirri mai ƙarfi

## Warware Matsaloli

### Matsalolin Gama Gari

1. **Kuskuren Haɗin Database**
   - Tabbatar da bayanin database
   - Tabbatar database an ƙirƙira

2. **Kuskuren FFmpeg**
   - Shigar da FFmpeg
   - Saita hanyar FFmpeg a cikin code

3. **Kuskuren API**
   - Tabbatar da maɓallan API
   - Yi la'akari da iyakokin API

4. **Kuskuren Webhook**
   - Tabbatar da takardar shaida ta SSL
   - Saita URL na webhook daidai

## Taimako

Don taimako da rahotanni na kuskure, tuntuɓi mai haɓakawa.

## Lasisi

Wannan aikin yana ƙarƙashin Lasisin MIT.
# Bot ya Telegram ya Kutambua Muziki

Hii bot ya Telegram inaweza kutambua muziki kutoka Instagram Reels. Watumiaji wanaweza kutuma viungo vya Instagram Reels na bot itatambua jina la wimbo na msanii.

## Vipengele

- 🎵 Kutambua muziki kutoka Instagram Reels
- 🎤 Kuonyesha jina la msanii na wimbo
- 💿 Kuonyesha taarifa za albamu (ikiwa inapatikana)
- 📅 Kuonyesha mwaka wa kuchapishwa
- 🎯 Kuonyesha asilimia ya kujiamini
- 💾 Kuhifadhi historia katika database
- 🔒 Usalama wa juu na ulinzi wa data

## Mahitaji

- PHP 7.4 au zaidi
- MySQL 5.7 au zaidi
- FFmpeg (kutoa sauti kutoka video)
- Vipengele vya PHP: curl, json, pdo, pdo_mysql
- Cheti cha SSL (kwa webhook)

## Usanidi

### 1. Pakia Faili

Pakia faili zote za mradi kwenye host yako ya cPanel.

### 2. Tekeleza Usanidi

Tekeleza `install.php` kwenye kivinjari chako ili kuthibitisha mahitaji.

### 3. Sanidi Database

1. Unda database ya MySQL
2. Hariri `config.php` na ingiza taarifa za database

### 4. Unda Bot ya Telegram

1. Zungumza na [@BotFather](https://t.me/botfather) kwenye Telegram
2. Tuma amri `/newbot`
3. Chagua jina la bot na jina la mtumiaji
4. Nakili token ya bot
5. Ingiza token kwenye `config.php`

### 5. Sanidi APIs

#### Instagram Basic Display API
1. Nenda [Facebook Developers](https://developers.facebook.com/)
2. Unda programu mpya
3. Ongeza Instagram Basic Display
4. Pata ufunguo wa API

#### ACRCloud API (Kutambua Muziki)
1. Nenda [ACRCloud](https://www.acrcloud.com/)
2. Unda akaunti
3. Pata ufunguo wa API

### 6. Sanidi Webhook

Tekeleza `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Jaribu Bot

Tekeleza `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Matumizi

1. Tafuta bot kwenye Telegram
2. Tuma amri `/start`
3. Tuma kiungo cha Instagram Reels
4. Subiri kutambua muziki

## Muundo wa Faili

```
/
├── config.php              # Usanidi mkuu
├── database.php            # Darasa la database
├── instagram_handler.php   # Uchakataji wa Instagram
├── music_recognizer.php    # Kutambua muziki
├── telegram_bot.php        # Darasa la bot ya Telegram
├── webhook.php            # Msimamizi wa webhook
├── setup.php              # Usanidi
├── test.php               # Jaribio la bot
├── install.php            # Usanidi
├── index.php              # Ukurasa mkuu
└── README.md              # Uandishi
```

## APIs Zinazoungwa Mkono

### Kutambua Muziki
- **ACRCloud**: Huduma kuu ya kutambua muziki
- **Shazam**: Mbadala wa ACRCloud

### Instagram
- **Instagram Basic Display API**: Ufikiaji wa maudhui ya Instagram

## Usanidi wa Juu

### Mipaka ya Faili
Kwenye faili `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Usalama
- Linda `config.php` dhidi ya ufikiaji wa umma
- Tumia cheti halali cha SSL
- Chagua nenosiri kali

## Kutatua Matatizo

### Matatizo ya Kawaida

1. **Hitilafu ya Muunganisho wa Database**
   - Thibitisha taarifa za database
   - Hakikisha database imeundwa

2. **Hitilafu ya FFmpeg**
   - Sakinisha FFmpeg
   - Weka njia ya FFmpeg kwenye kodi

3. **Hitilafu ya API**
   - Thibitisha funguo za API
   - Fikiria mipaka ya API

4. **Hitilafu ya Webhook**
   - Thibitisha cheti cha SSL
   - Weka URL ya webhook kwa usahihi

## Msaada

Kwa msaada na ripoti za hitilafu, wasiliana na msanidi.

## Leseni

Huu mradi umeidhinishwa chini ya Leseni ya MIT.
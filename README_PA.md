# ਟੈਲੀਗ੍ਰਾਮ ਸੰਗੀਤ ਪਛਾਣ ਬੋਟ

ਇਹ ਟੈਲੀਗ੍ਰਾਮ ਬੋਟ Instagram Reels ਤੋਂ ਸੰਗੀਤ ਦੀ ਪਛਾਣ ਕਰ ਸਕਦਾ ਹੈ। ਵਰਤੋਂਕਾਰ Instagram Reels ਲਿੰਕ ਭੇਜ ਸਕਦੇ ਹਨ ਅਤੇ ਬੋਟ ਗੀਤ ਦਾ ਨਾਮ ਅਤੇ ਕਲਾਕਾਰ ਨੂੰ ਪਛਾਣਦਾ ਹੈ।

## ਵਿਸ਼ੇਸ਼ਤਾਵਾਂ

- 🎵 Instagram Reels ਤੋਂ ਸੰਗੀਤ ਪਛਾਣ
- 🎤 ਕਲਾਕਾਰ ਅਤੇ ਗੀਤ ਦਾ ਨਾਮ ਪ੍ਰਦਰਸ਼ਿਤ ਕਰੋ
- 💿 ਐਲਬਮ ਜਾਣਕਾਰੀ ਪ੍ਰਦਰਸ਼ਿਤ ਕਰੋ (ਜੇ ਉਪਲਬਧ ਹੈ)
- 📅 ਪ੍ਰਕਾਸ਼ਨ ਸਾਲ ਪ੍ਰਦਰਸ਼ਿਤ ਕਰੋ
- 🎯 ਵਿਸ਼ਵਾਸ ਪ੍ਰਤੀਸ਼ਤ ਪ੍ਰਦਰਸ਼ਿਤ ਕਰੋ
- 💾 ਇਤਿਹਾਸ ਡੇਟਾਬੇਸ ਵਿੱਚ ਸੰਭਾਲੋ
- 🔒 ਉੱਚ ਸੁਰੱਖਿਆ ਅਤੇ ਡੇਟਾ ਸੁਰੱਖਿਆ

## ਲੋੜਾਂ

- PHP 7.4 ਜਾਂ ਉਸ ਤੋਂ ਵੱਧ
- MySQL 5.7 ਜਾਂ ਉਸ ਤੋਂ ਵੱਧ
- FFmpeg (ਵੀਡੀਓ ਤੋਂ ਆਡੀਓ ਕੱਢਣ ਲਈ)
- PHP ਐਕਸਟੈਨਸ਼ਨ: curl, json, pdo, pdo_mysql
- SSL ਸਰਟੀਫਿਕੇਟ (webhook ਲਈ)

## ਸਥਾਪਨਾ

### 1. ਫਾਈਲਾਂ ਅਪਲੋਡ ਕਰੋ

ਸਾਰੀਆਂ ਪ੍ਰੋਜੈਕਟ ਫਾਈਲਾਂ ਆਪਣੇ cPanel ਹੋਸਟ 'ਤੇ ਅਪਲੋਡ ਕਰੋ।

### 2. ਸਥਾਪਨਾ ਚਲਾਓ

ਲੋੜਾਂ ਦੀ ਜਾਂਚ ਕਰਨ ਲਈ `install.php` ਆਪਣੇ ਬ੍ਰਾਊਜ਼ਰ ਵਿੱਚ ਚਲਾਓ।

### 3. ਡੇਟਾਬੇਸ ਕੌਨਫਿਗਰ ਕਰੋ

1. MySQL ਡੇਟਾਬੇਸ ਬਣਾਓ
2. `config.php` ਸੰਪਾਦਨ ਕਰੋ ਅਤੇ ਡੇਟਾਬੇਸ ਜਾਣਕਾਰੀ ਦਰਜ ਕਰੋ

### 4. ਟੈਲੀਗ੍ਰਾਮ ਬੋਟ ਬਣਾਓ

1. ਟੈਲੀਗ੍ਰਾਮ ਵਿੱਚ [@BotFather](https://t.me/botfather) ਨਾਲ ਗੱਲ ਕਰੋ
2. `/newbot` ਕਮਾਂਡ ਭੇਜੋ
3. ਬੋਟ ਦਾ ਨਾਮ ਅਤੇ ਵਰਤੋਂਕਾਰ ਨਾਮ ਚੁਣੋ
4. ਬੋਟ ਟੋਕਨ ਕਾਪੀ ਕਰੋ
5. ਟੋਕਨ `config.php` ਵਿੱਚ ਦਰਜ ਕਰੋ

### 5. API ਕੌਨਫਿਗਰ ਕਰੋ

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) 'ਤੇ ਜਾਓ
2. ਨਵੀਂ ਐਪਲੀਕੇਸ਼ਨ ਬਣਾਓ
3. Instagram Basic Display ਸ਼ਾਮਲ ਕਰੋ
4. API ਕੁੰਜੀ ਪ੍ਰਾਪਤ ਕਰੋ

#### ACRCloud API (ਸੰਗੀਤ ਪਛਾਣ)
1. [ACRCloud](https://www.acrcloud.com/) 'ਤੇ ਜਾਓ
2. ਖਾਤਾ ਬਣਾਓ
3. API ਕੁੰਜੀ ਪ੍ਰਾਪਤ ਕਰੋ

### 6. Webhook ਕੌਨਫਿਗਰ ਕਰੋ

`setup.php` ਚਲਾਓ:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. ਬੋਟ ਟੈਸਟ ਕਰੋ

`test.php` ਚਲਾਓ:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## ਵਰਤੋਂ

1. ਟੈਲੀਗ੍ਰਾਮ ਵਿੱਚ ਬੋਟ ਲੱਭੋ
2. `/start` ਕਮਾਂਡ ਭੇਜੋ
3. Instagram Reels ਲਿੰਕ ਭੇਜੋ
4. ਸੰਗੀਤ ਪਛਾਣ ਲਈ ਉਡੀਕ ਕਰੋ

## ਫਾਈਲ ਢਾਂਚਾ

```
/
├── config.php              # ਮੁੱਖ ਕੌਨਫਿਗਰੇਸ਼ਨ
├── database.php            # ਡੇਟਾਬੇਸ ਕਲਾਸ
├── instagram_handler.php   # Instagram ਪ੍ਰੋਸੈਸਿੰਗ
├── music_recognizer.php    # ਸੰਗੀਤ ਪਛਾਣ
├── telegram_bot.php        # ਟੈਲੀਗ੍ਰਾਮ ਬੋਟ ਕਲਾਸ
├── webhook.php            # Webhook ਮੈਨੇਜਰ
├── setup.php              # ਕੌਨਫਿਗਰੇਸ਼ਨ
├── test.php               # ਬੋਟ ਟੈਸਟ
├── install.php            # ਸਥਾਪਨਾ
├── index.php              # ਮੁੱਖ ਪੰਨਾ
└── README.md              # ਦਸਤਾਵੇਜ਼ੀਕਰਣ
```

## ਸਹਾਇਕ API

### ਸੰਗੀਤ ਪਛਾਣ
- **ACRCloud**: ਮੁੱਖ ਸੰਗੀਤ ਪਛਾਣ ਸੇਵਾ
- **Shazam**: ACRCloud ਵਿਕਲਪ

### Instagram
- **Instagram Basic Display API**: Instagram ਸਮਗਰੀ ਤੱਕ ਪਹੁੰਚ

## ਉਨ੍ਹਤ ਕੌਨਫਿਗਰੇਸ਼ਨ

### ਫਾਈਲ ਸੀਮਾਵਾਂ
`.htaccess` ਫਾਈਲ ਵਿੱਚ:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### ਸੁਰੱਖਿਆ
- `config.php` ਨੂੰ ਜਨਤਕ ਪਹੁੰਚ ਤੋਂ ਸੁਰੱਖਿਤ ਕਰੋ
- ਵੈਧ SSL ਸਰਟੀਫਿਕੇਟ ਵਰਤੋ
- ਮਜ਼ਬੂਤ ਪਾਸਵਰਡ ਚੁਣੋ

## ਸਮੱਸਿਆਵਾਂ ਹੱਲ ਕਰਨਾ

### ਆਮ ਸਮੱਸਿਆਵਾਂ

1. **ਡੇਟਾਬੇਸ ਕਨੈਕਸ਼ਨ ਗਲਤੀ**
   - ਡੇਟਾਬੇਸ ਜਾਣਕਾਰੀ ਦੀ ਜਾਂਚ ਕਰੋ
   - ਡੇਟਾਬੇਸ ਬਣਾਇਆ ਗਿਆ ਹੈ ਇਸਦੀ ਪੁਸ਼ਟੀ ਕਰੋ

2. **FFmpeg ਗਲਤੀ**
   - FFmpeg ਇੰਸਟਾਲ ਕਰੋ
   - ਕੋਡ ਵਿੱਚ FFmpeg ਪਾਥ ਸੈੱਟ ਕਰੋ

3. **API ਗਲਤੀ**
   - API ਕੁੰਜੀਆਂ ਦੀ ਜਾਂਚ ਕਰੋ
   - API ਸੀਮਾਵਾਂ 'ਤੇ ਵਿਚਾਰ ਕਰੋ

4. **Webhook ਗਲਤੀ**
   - SSL ਸਰਟੀਫਿਕੇਟ ਦੀ ਜਾਂਚ ਕਰੋ
   - Webhook URL ਸਹੀ ਤਰੀਕੇ ਨਾਲ ਸੈੱਟ ਕਰੋ

## ਸਹਾਇਤਾ

ਸਹਾਇਤਾ ਅਤੇ ਗਲਤੀ ਰਿਪੋਰਟਾਂ ਲਈ, ਡਿਵੈਲਪਰ ਨਾਲ ਸੰਪਰਕ ਕਰੋ।

## ਲਾਇਸੈਂਸ

ਇਹ ਪ੍ਰੋਜੈਕਟ MIT ਲਾਇਸੈਂਸ ਹੇਠ ਲਾਇਸੈਂਸ ਕੀਤਾ ਗਿਆ ਹੈ।
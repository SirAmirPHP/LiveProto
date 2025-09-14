# ቴሌግራም ሙዚቃ አውታረ መረብ ቦት

እዚ ቴሌግራም ቦት ካብ Instagram Reels ሙዚቃ ክምውቅ ይኽእል እዩ። ተጠቃሚታት ካብ Instagram Reels ሊንክታት ክልእኩ ይኽእሉ እዮም። ቦቱ ናይ ደርፊ ስምን ናይ አርቲስትን ክምውቅ እዩ።

## ባህርያት

- 🎵 ካብ Instagram Reels ሙዚቃ አውታረ መረብ
- 🎤 ናይ አርቲስትን ናይ ደርፊ ስምን ምርኢት
- 💿 ናይ አልበም ሓበሬታ ምርኢት (እንተ ደለወ)
- 📅 ናይ ህትመት ዓመት ምርኢት
- 🎯 ናይ ምተማመን ሚእታዊ ምርኢት
- 💾 ታሪኽ ኣብ ዳታቤዝ ምሕዳስ
- 🔒 ላዕለዋይ ኣሰላምን ዳታ ምክልን

## ኣገዳሲ ነገራት

- PHP 7.4 ወይ ካብኡ ንላዕሊ
- MySQL 5.7 ወይ ካብኡ ንላዕሊ
- FFmpeg (ካብ ቪድዮ ድምጺ ምውጻእ)
- PHP ምልክታት: curl, json, pdo, pdo_mysql
- SSL ምስክር ወረቀት (ን webhook)

## ምትካእ

### 1. ፋይላት ምልካእ

ኩሉ ናይ ፕሮጀክት ፋይላት ኣብ cPanel ሆስትካ ምልካእ።

### 2. ምትካእ ምፍጻም

ኣገዳሲ ነገራት ንምርግጋፅ `install.php` ኣብ ናይካ ብራውዘር ምፍጻም።

### 3. ዳታቤዝ ምዋቃል

1. MySQL ዳታቤዝ ምፍጣር
2. `config.php` ምሕራይ እሞ ናይ ዳታቤዝ ሓበሬታ ምእታው
3. ናይ ዳታቤዝ ሓበሬታ ምእታው

### 4. ቴሌግራም ቦት ምፍጣር

1. ምስ [@BotFather](https://t.me/botfather) ኣብ ቴሌግራም ምዝራብ
2. `/newbot` ትዕዛዝ ምልካእ
3. ናይ ቦት ስምን ናይ ተጠቃሚ ስምን ምምራጽ
4. ናይ ቦት ቶከን ምቅዳስ
5. ቶከን ኣብ `config.php` ምእታው

### 5. APIs ምዋቃል

#### Instagram Basic Display API
1. ናብ [Facebook Developers](https://developers.facebook.com/) ምኻድ
2. ሓድሽ መተግበሪያ ምፍጣር
3. Instagram Basic Display ምውሳኽ
4. API ቁልፊ ምርካብ

#### ACRCloud API (ሙዚቃ አውታረ መረብ)
1. ናብ [ACRCloud](https://www.acrcloud.com/) ምኻድ
2. ኣካውንት ምፍጣር
3. API ቁልፊ ምርካብ

### 6. Webhook ምዋቃል

`setup.php` ምፍጻም:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. ቦት ምሞክሽ

`test.php` ምፍጻም:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## ኣጠቓቕማ

1. ቦት ኣብ ቴሌግራም ምርካብ
2. `/start` ትዕዛዝ ምልካእ
3. Instagram Reels ሊንክ ምልካእ
4. ንሙዚቃ አውታረ መረብ ምጽበት

## ናይ ፋይል ኣቃውማ

```
/
├── config.php              # ቀንዲ ምዋቃል
├── database.php            # ናይ ዳታቤዝ ክፍሊ
├── instagram_handler.php   # Instagram ምሕዳስ
├── music_recognizer.php    # ሙዚቃ አውታረ መረብ
├── telegram_bot.php        # ናይ ቴሌግራም ቦት ክፍሊ
├── webhook.php            # ናይ webhook ኣስተዳደሪ
├── setup.php              # ምዋቃል
├── test.php               # ናይ ቦት ምሞክሽ
├── install.php            # ምትካእ
├── index.php              # ቀንዲ ገጽ
└── README.md              # ሰነድ
```

## ዝሕግዝ APIs

### ሙዚቃ አውታረ መረብ
- **ACRCloud**: ቀንዲ ናይ ሙዚቃ አውታረ መረብ ኣገልግሎት
- **Shazam**: ACRCloud ኣማራጺ

### Instagram
- **Instagram Basic Display API**: ናብ Instagram ይዘት ምእታው

## ላዕለዋይ ምዋቃል

### ናይ ፋይላት ዶባታት
ኣብ `.htaccess` ፋይል:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### ኣሰላም
- `config.php` ካብ ህዝባዊ ምእታው ምክል
- ትክክለኛ SSL ምስክር ወረቀት ምጥቃዕ
- ሓያል ቃል-ምስጢር ምምራጽ

## ችግራት ምፍታሽ

### ዝርከብ ችግራት

1. **ናይ ዳታቤዝ ምትእኽኻብ ጌጋ**
   - ናይ ዳታቤዝ ሓበሬታ ምርግጋፅ
   - ዳታቤዝ ከም ዝተፈጥረ ምርግጋፅ

2. **FFmpeg ጌጋ**
   - FFmpeg ምትካእ
   - FFmpeg መንገዲ ኣብ ኮድ ምዋቃል

3. **API ጌጋ**
   - API ቁልፍታት ምርግጋፅ
   - API ዶባታት ምርኣይ

4. **Webhook ጌጋ**
   - SSL ምስክር ወረቀት ምርግጋፅ
   - webhook URL ብትክክል ምዋቃል

## ደገፍ

ንደገፍን ጌጋ ሪፖርትታትን፣ ምስ ማዳቀሪ ምትእኽኻብ።

## ፍቓድ

እዚ ፕሮጀክት ኣብ ትሕቲ MIT ፍቓድ እዩ።
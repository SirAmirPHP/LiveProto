# ቴሌግራም ሙዚቃ አውታረ መረብ ቦት

ይህ ቴሌግራም ቦት ከ Instagram Reels ሙዚቃን ማወቅ ይችላል። ተጠቃሚዎች Instagram Reels አገናኞችን ሊላኩ ይችላሉ እና ቦቱ የመሰን ስም እና አርቲስትን ያስታውቃል።

## ባህሪያት

- 🎵 ከ Instagram Reels ሙዚቃ አውታረ መረብ
- 🎤 የአርቲስት እና የመሰን ስም ማሳየት
- 💿 የአልበም መረጃ ማሳየት (ካለ)
- 📅 የህትመት ዓመት ማሳየት
- 🎯 የመተማመን መቶኛ ማሳየት
- 💾 ታሪክን በዳታቤዝ ውስጥ ማስቀመጥ
- 🔒 ከፍተኛ ደህንነት እና የዳታ ጥበቃ

## መስፈርቶች

- PHP 7.4 ወይም ከዚያ በላይ
- MySQL 5.7 ወይም ከዚያ በላይ
- FFmpeg (ከቪዲዮ ድምጽ ማውጣት)
- PHP ምስረታዎች: curl, json, pdo, pdo_mysql
- SSL የምስክር ወረቀት (ለ webhook)

## መጫን

### 1. ፋይሎችን ማስገባት

ሁሉንም የፕሮጀክት ፋይሎችን በ cPanel ሆስትዎ ላይ ያስገቡ።

### 2. መጫን ማስፈጸም

መስፈርቶችን ለማረጋገጥ `install.php` በአሳሽዎ ውስጥ ያስፈጽሙ።

### 3. ዳታቤዝ ማዋቀር

1. MySQL ዳታቤዝ ይፍጠሩ
2. `config.php` ያርትዑ እና የዳታቤዝ መረጃ ያስገቡ

### 4. ቴሌግራም ቦት መፍጠር

1. በቴሌግራም ውስጥ [@BotFather](https://t.me/botfather) ጋር ተነጋግሩ
2. `/newbot` ትዕዛዝ ይላኩ
3. የቦት ስም እና የተጠቃሚ ስም ይምረጡ
4. የቦት ቶከን ይቅዱ
5. ቶከንን በ `config.php` ውስጥ ያስገቡ

### 5. APIs ማዋቀር

#### Instagram Basic Display API
1. ወደ [Facebook Developers](https://developers.facebook.com/) ይሂዱ
2. አዲስ መተግበሪያ ይፍጠሩ
3. Instagram Basic Display ይጨምሩ
4. API ቁልፍ ያግኙ

#### ACRCloud API (ሙዚቃ አውታረ መረብ)
1. ወደ [ACRCloud](https://www.acrcloud.com/) ይሂዱ
2. አካውንት ይፍጠሩ
3. API ቁልፍ ያግኙ

### 6. Webhook ማዋቀር

`setup.php` ያስፈጽሙ:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. ቦት ማሞከር

`test.php` ያስፈጽሙ:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## አጠቃቀም

1. ቦቱን በቴሌግራም ውስጥ ያግኙ
2. `/start` ትዕዛዝ ይላኩ
3. Instagram Reels አገናኝ ይላኩ
4. ሙዚቃ አውታረ መረብ ይጠብቁ

## የፋይል መዋቅር

```
/
├── config.php              # ዋና ማዋቀር
├── database.php            # የዳታቤዝ ክፍል
├── instagram_handler.php   # Instagram ማስተካከል
├── music_recognizer.php    # ሙዚቃ አውታረ መረብ
├── telegram_bot.php        # የቴሌግራም ቦት ክፍል
├── webhook.php            # የ webhook አስተዳደር
├── setup.php              # ማዋቀር
├── test.php               # የቦት ማሞከር
├── install.php            # መጫን
├── index.php              # ዋና ገጽ
└── README.md              # ሰነድ
```

## የሚደገፉ APIs

### ሙዚቃ አውታረ መረብ
- **ACRCloud**: ዋና የሙዚቃ አውታረ መረብ አገልግሎት
- **Shazam**: ACRCloud አማራጭ

### Instagram
- **Instagram Basic Display API**: ወደ Instagram ይዘት መዳረሻ

## የላቀ ማዋቀር

### የፋይል ገደቦች
በ `.htaccess` ፋይል ውስጥ:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### ደህንነት
- `config.php`ን ከህዝባዊ መዳረሻ ይጠብቁ
- ትክክለኛ SSL የምስክር ወረቀት ይጠቀሙ
- ጠንካራ የይለፍ ቃላት ይምረጡ

## ችግሮችን መፍታት

### የተለመዱ ችግሮች

1. **የዳታቤዝ ግንኙነት ስህተት**
   - የዳታቤዝ መረጃን ያረጋግጡ
   - ዳታቤዝ እንደተፈጠረ ያረጋግጡ

2. **FFmpeg ስህተት**
   - FFmpeg ያስገቡ
   - FFmpeg መንገድን በኮድ ውስጥ ያዋቅሩ

3. **API ስህተት**
   - API ቁልፎችን ያረጋግጡ
   - API ገደቦችን ያስቡ

4. **Webhook ስህተት**
   - SSL የምስክር ወረቀትን ያረጋግጡ
   - webhook URLን በትክክል ያዋቅሩ

## ድጋፍ

ለድጋፍ እና ስህተት ሪፖርቶች፣ ከማዳቀሪው ጋር ያግኙ።

## ፈቃድ

ይህ ፕሮጀክት በ MIT ፈቃድ ስር የተፈቀደ ነው።
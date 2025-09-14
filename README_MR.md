# टेलिग्राम संगीत ओळख बॉट

हा टेलिग्राम बॉट Instagram Reels मधून संगीत ओळखू शकतो. वापरकर्ते Instagram Reels लिंक पाठवू शकतात आणि बॉट गाण्याचे नाव आणि कलाकार ओळखतो.

## वैशिष्ट्ये

- 🎵 Instagram Reels मधून संगीत ओळख
- 🎤 कलाकार आणि गाण्याचे नाव प्रदर्शित करा
- 💿 अल्बम माहिती प्रदर्शित करा (उपलब्ध असल्यास)
- 📅 प्रकाशन वर्ष प्रदर्शित करा
- 🎯 विश्वास टक्केवारी प्रदर्शित करा
- 💾 इतिहास डेटाबेसमध्ये संग्रहित करा
- 🔒 उच्च सुरक्षा आणि डेटा संरक्षण

## आवश्यकता

- PHP 7.4 किंवा त्यापेक्षा जास्त
- MySQL 5.7 किंवा त्यापेक्षा जास्त
- FFmpeg (व्हिडिओमधून ऑडिओ काढण्यासाठी)
- PHP एक्सटेंशन: curl, json, pdo, pdo_mysql
- SSL प्रमाणपत्र (webhook साठी)

## स्थापना

### 1. फाइल अपलोड करा

सर्व प्रोजेक्ट फाइल आपल्या cPanel होस्टवर अपलोड करा.

### 2. स्थापना चालवा

आवश्यकता तपासण्यासाठी `install.php` आपल्या ब्राउझरमध्ये चालवा.

### 3. डेटाबेस कॉन्फिगर करा

1. MySQL डेटाबेस तयार करा
2. `config.php` संपादित करा आणि डेटाबेस माहिती प्रविष्ट करा

### 4. टेलिग्राम बॉट तयार करा

1. टेलिग्राममध्ये [@BotFather](https://t.me/botfather) शी बोला
2. `/newbot` आदेश पाठवा
3. बॉटचे नाव आणि वापरकर्ता नाव निवडा
4. बॉट टोकन कॉपी करा
5. टोकन `config.php` मध्ये प्रविष्ट करा

### 5. API कॉन्फिगर करा

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) वर जा
2. नवीन अनुप्रयोग तयार करा
3. Instagram Basic Display जोडा
4. API की मिळवा

#### ACRCloud API (संगीत ओळख)
1. [ACRCloud](https://www.acrcloud.com/) वर जा
2. खाते तयार करा
3. API की मिळवा

### 6. Webhook कॉन्फिगर करा

`setup.php` चालवा:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. बॉट चाचणी करा

`test.php` चालवा:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## वापर

1. टेलिग्राममध्ये बॉट शोधा
2. `/start` आदेश पाठवा
3. Instagram Reels लिंक पाठवा
4. संगीत ओळखीसाठी प्रतीक्षा करा

## फाइल रचना

```
/
├── config.php              # मुख्य कॉन्फिगरेशन
├── database.php            # डेटाबेस वर्ग
├── instagram_handler.php   # Instagram प्रक्रिया
├── music_recognizer.php    # संगीत ओळख
├── telegram_bot.php        # टेलिग्राम बॉट वर्ग
├── webhook.php            # Webhook व्यवस्थापक
├── setup.php              # कॉन्फिगरेशन
├── test.php               # बॉट चाचणी
├── install.php            # स्थापना
├── index.php              # मुख्य पृष्ठ
└── README.md              # दस्तऐवजीकरण
```

## समर्थित API

### संगीत ओळख
- **ACRCloud**: मुख्य संगीत ओळख सेवा
- **Shazam**: ACRCloud पर्याय

### Instagram
- **Instagram Basic Display API**: Instagram सामग्रीमध्ये प्रवेश

## प्रगत कॉन्फिगरेशन

### फाइल मर्यादा
`.htaccess` फाइलमध्ये:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### सुरक्षा
- `config.php` ला सार्वजनिक प्रवेशापासून संरक्षित करा
- वैध SSL प्रमाणपत्र वापरा
- मजबूत पासवर्ड निवडा

## समस्या सोडवणे

### सामान्य समस्या

1. **डेटाबेस कनेक्शन त्रुटी**
   - डेटाबेस माहिती तपासा
   - डेटाबेस तयार केले आहे याची खात्री करा

2. **FFmpeg त्रुटी**
   - FFmpeg स्थापित करा
   - कोडमध्ये FFmpeg पाथ सेट करा

3. **API त्रुटी**
   - API की तपासा
   - API मर्यादा विचारात घ्या

4. **Webhook त्रुटी**
   - SSL प्रमाणपत्र तपासा
   - Webhook URL योग्यरित्या सेट करा

## समर्थन

समर्थन आणि त्रुटी अहवालांसाठी, डेव्हलपरशी संपर्क साधा.

## परवाना

हा प्रोजेक्ट MIT परवान्याखाली परवानाकृत आहे.
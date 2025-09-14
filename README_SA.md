# टेलिग्राम संगीत पहचान बॉट

यह टेलिग्राम बॉट Instagram Reels से संगीत पहचान सकता है। उपयोगकर्ता Instagram Reels लिंक भेज सकते हैं और बॉट गाने का नाम और कलाकार को पहचानता है।

## विशेषताएं

- 🎵 Instagram Reels से संगीत पहचान
- 🎤 कलाकार और गाने का नाम प्रदर्शित करना
- 💿 एल्बम जानकारी प्रदर्शित करना (यदि उपलब्ध)
- 📅 प्रकाशन वर्ष प्रदर्शित करना
- 🎯 विश्वास प्रतिशत प्रदर्शित करना
- 💾 इतिहास डेटाबेस में संग्रहीत करना
- 🔒 उच्च सुरक्षा और डेटा सुरक्षा

## आवश्यकताएं

- PHP 7.4 या अधिक
- MySQL 5.7 या अधिक
- FFmpeg (वीडियो से ऑडियो निकालने के लिए)
- PHP एक्सटेंशन: curl, json, pdo, pdo_mysql
- SSL प्रमाणपत्र (webhook के लिए)

## स्थापना

### 1. फाइलें अपलोड करें

सभी प्रोजेक्ट फाइलें अपने cPanel होस्ट पर अपलोड करें।

### 2. स्थापना चलाएं

आवश्यकताओं की जांच के लिए `install.php` अपने ब्राउज़र में चलाएं।

### 3. डेटाबेस कॉन्फ़िगर करें

1. MySQL डेटाबेस बनाएं
2. `config.php` संपादित करें और डेटाबेस जानकारी दर्ज करें

### 4. टेलिग्राम बॉट बनाएं

1. टेलिग्राम में [@BotFather](https://t.me/botfather) से बात करें
2. `/newbot` कमांड भेजें
3. बॉट का नाम और उपयोगकर्ता नाम चुनें
4. बॉट टोकन कॉपी करें
5. टोकन `config.php` में दर्ज करें

### 5. API कॉन्फ़िगर करें

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) पर जाएं
2. नया एप्लिकेशन बनाएं
3. Instagram Basic Display जोड़ें
4. API कुंजी प्राप्त करें

#### ACRCloud API (संगीत पहचान)
1. [ACRCloud](https://www.acrcloud.com/) पर जाएं
2. खाता बनाएं
3. API कुंजी प्राप्त करें

### 6. Webhook कॉन्फ़िगर करें

`setup.php` चलाएं:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. बॉट टेस्ट करें

`test.php` चलाएं:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## उपयोग

1. टेलिग्राम में बॉट खोजें
2. `/start` कमांड भेजें
3. Instagram Reels लिंक भेजें
4. संगीत पहचान के लिए प्रतीक्षा करें

## फाइल संरचना

```
/
├── config.php              # मुख्य कॉन्फ़िगरेशन
├── database.php            # डेटाबेस क्लास
├── instagram_handler.php   # Instagram प्रसंस्करण
├── music_recognizer.php    # संगीत पहचान
├── telegram_bot.php        # टेलिग्राम बॉट क्लास
├── webhook.php            # Webhook प्रबंधक
├── setup.php              # कॉन्फ़िगरेशन
├── test.php               # बॉट टेस्ट
├── install.php            # स्थापना
├── index.php              # मुख्य पृष्ठ
└── README.md              # दस्तावेजीकरण
```

## समर्थित API

### संगीत पहचान
- **ACRCloud**: मुख्य संगीत पहचान सेवा
- **Shazam**: ACRCloud विकल्प

### Instagram
- **Instagram Basic Display API**: Instagram सामग्री तक पहुंच

## उन्नत कॉन्फ़िगरेशन

### फाइल सीमाएं
`.htaccess` फाइल में:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### सुरक्षा
- `config.php` को सार्वजनिक पहुंच से सुरक्षित करें
- वैध SSL प्रमाणपत्र का उपयोग करें
- मजबूत पासवर्ड चुनें

## समस्या समाधान

### सामान्य समस्याएं

1. **डेटाबेस कनेक्शन त्रुटि**
   - डेटाबेस जानकारी की जांच करें
   - डेटाबेस बनाया गया है इसकी पुष्टि करें

2. **FFmpeg त्रुटि**
   - FFmpeg स्थापित करें
   - कोड में FFmpeg पथ सेट करें

3. **API त्रुटि**
   - API कुंजियों की जांच करें
   - API सीमाओं पर विचार करें

4. **Webhook त्रुटि**
   - SSL प्रमाणपत्र की जांच करें
   - Webhook URL को सही तरीके से सेट करें

## समर्थन

समर्थन और त्रुटि रिपोर्ट्स के लिए, डेवलपर से संपर्क करें।

## लाइसेंस

यह प्रोजेक्ट MIT लाइसेंस के तहत लाइसेंस किया गया है।
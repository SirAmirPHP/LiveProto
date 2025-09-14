# টেলিগ্ৰাম সংগীত চিনাক্তকৰণ বট

এই টেলিগ্ৰাম বটে Instagram Reels ৰ পৰা সংগীত চিনাক্ত কৰিব পাৰে। ব্যৱহাৰকাৰীসকলে Instagram Reels লিংক পঠিয়াব পাৰে আৰু বটে গীতৰ নাম আৰু শিল্পীক চিনাক্ত কৰে।

## বৈশিষ্ট্য

- 🎵 Instagram Reels ৰ পৰা সংগীত চিনাক্তকৰণ
- 🎤 শিল্পী আৰু গীতৰ নাম প্ৰদৰ্শন
- 💿 এলবামৰ তথ্য প্ৰদৰ্শন (যদি উপলব্ধ)
- 📅 প্ৰকাশনৰ বছৰ প্ৰদৰ্শন
- 🎯 আস্থাৰ শতাংশ প্ৰদৰ্শন
- 💾 ইতিহাস ডেটাবেছত সংৰক্ষণ
- 🔒 উচ্চ নিৰাপত্তা আৰু ডেটা সুৰক্ষা

## প্ৰয়োজনীয়তা

- PHP 7.4 বা তদুপৰি
- MySQL 5.7 বা তদুপৰি
- FFmpeg (ভিডিঅ'ৰ পৰা অডিঅ' বাহিৰ কৰিবলৈ)
- PHP এক্সটেনশ্যন: curl, json, pdo, pdo_mysql
- SSL প্ৰমাণপত্ৰ (webhook ৰ বাবে)

## ইনষ্টলেচন

### 1. ফাইল আপলোড কৰক

সকলো প্ৰজেক্ট ফাইল আপোনাৰ cPanel হোষ্টত আপলোড কৰক।

### 2. ইনষ্টলেচন চলাওক

প্ৰয়োজনীয়তা পৰীক্ষা কৰিবলৈ `install.php` আপোনাৰ ব্ৰাউজাৰত চলাওক।

### 3. ডেটাবেছ কনফিগাৰ কৰক

1. MySQL ডেটাবেছ সৃষ্টি কৰক
2. `config.php` সম্পাদনা কৰক আৰু ডেটাবেছ তথ্য প্ৰবেশ কৰক

### 4. টেলিগ্ৰাম বট সৃষ্টি কৰক

1. টেলিগ্ৰামত [@BotFather](https://t.me/botfather) ৰ সৈতে কথা পাতক
2. `/newbot` আদেশ পঠিয়াওক
3. বটৰ নাম আৰু ব্যৱহাৰকাৰীৰ নাম বাছক
4. বট টোকেন কপি কৰক
5. টোকেন `config.php` ত প্ৰবেশ কৰক

### 5. API কনফিগাৰ কৰক

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) লৈ যাওক
2. নতুন এপ্লিকেচন সৃষ্টি কৰক
3. Instagram Basic Display যোগ কৰক
4. API চাবি প্ৰাপ্ত কৰক

#### ACRCloud API (সংগীত চিনাক্তকৰণ)
1. [ACRCloud](https://www.acrcloud.com/) লৈ যাওক
2. একাউণ্ট সৃষ্টি কৰক
3. API চাবি প্ৰাপ্ত কৰক

### 6. Webhook কনফিগাৰ কৰক

`setup.php` চলাওক:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. বট টেষ্ট কৰক

`test.php` চলাওক:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## ব্যৱহাৰ

1. টেলিগ্ৰামত বট বিচাৰক
2. `/start` আদেশ পঠিয়াওক
3. Instagram Reels লিংক পঠিয়াওক
4. সংগীত চিনাক্তকৰণৰ বাবে অপেক্ষা কৰক

## ফাইল গঠন

```
/
├── config.php              # মুখ্য কনফিগাৰেচন
├── database.php            # ডেটাবেছ ক্লাচ
├── instagram_handler.php   # Instagram প্ৰচেছিং
├── music_recognizer.php    # সংগীত চিনাক্তকৰণ
├── telegram_bot.php        # টেলিগ্ৰাম বট ক্লাচ
├── webhook.php            # Webhook মেনেজাৰ
├── setup.php              # কনফিগাৰেচন
├── test.php               # বট টেষ্ট
├── install.php            # ইনষ্টলেচন
├── index.php              # মুখ্য পৃষ্ঠা
└── README.md              # ডকুমেন্টেচন
```

## সমৰ্থিত API

### সংগীত চিনাক্তকৰণ
- **ACRCloud**: মুখ্য সংগীত চিনাক্তকৰণ সেৱা
- **Shazam**: ACRCloud বিকল্প

### Instagram
- **Instagram Basic Display API**: Instagram কন্টেন্টত প্ৰৱেশ

## উন্নত কনফিগাৰেচন

### ফাইল সীমা
`.htaccess` ফাইলত:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### নিৰাপত্তা
- `config.php` ৰ পৰা ৰাজহুৱা প্ৰৱেশ ৰক্ষা কৰক
- বৈধ SSL প্ৰমাণপত্ৰ ব্যৱহাৰ কৰক
- শক্তিশালী পাছৱৰ্ড বাছক

## সমস্যা সমাধান

### সাধাৰণ সমস্যা

1. **ডেটাবেছ কানেকচন ত্ৰুটি**
   - ডেটাবেছ তথ্য পৰীক্ষা কৰক
   - ডেটাবেছ সৃষ্টি হৈছে নিশ্চিত কৰক

2. **FFmpeg ত্ৰুটি**
   - FFmpeg ইনষ্টল কৰক
   - কোডত FFmpeg পাথ ছেট কৰক

3. **API ত্ৰুটি**
   - API চাবি পৰীক্ষা কৰক
   - API সীমা বিবেচনা কৰক

4. **Webhook ত্ৰুটি**
   - SSL প্ৰমাণপত্ৰ পৰীক্ষা কৰক
   - Webhook URL সঠিকভাৱে ছেট কৰক

## সহায়তা

সহায়তা আৰু ত্ৰুটি ৰিপোৰ্টৰ বাবে, ডেভেলপাৰৰ সৈতে যোগাযোগ কৰক।

## লাইচেন্স

এই প্ৰজেক্ট MIT লাইচেন্সৰ অধীনত লাইচেন্স কৰা হৈছে।
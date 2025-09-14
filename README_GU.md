# ટેલિગ્રામ સંગીત ઓળખ બોટ

આ ટેલિગ્રામ બોટ Instagram Reels માંથી સંગીત ઓળખી શકે છે. વપરાશકર્તાઓ Instagram Reels લિંક્સ મોકલી શકે છે અને બોટ ગીતનું નામ અને કલાકારને ઓળખે છે.

## વિશેષતાઓ

- 🎵 Instagram Reels માંથી સંગીત ઓળખ
- 🎤 કલાકાર અને ગીતનું નામ પ્રદર્શિત કરો
- 💿 આલ્બમ માહિતી પ્રદર્શિત કરો (જો ઉપલબ્ધ હોય)
- 📅 પ્રકાશન વર્ષ પ્રદર્શિત કરો
- 🎯 વિશ્વાસ ટકાવારી પ્રદર્શિત કરો
- 💾 ઇતિહાસ ડેટાબેઝમાં સંગ્રહિત કરો
- 🔒 ઉચ્ચ સુરક્ષા અને ડેટા સુરક્ષા

## આવશ્યકતાઓ

- PHP 7.4 અથવા વધુ
- MySQL 5.7 અથવા વધુ
- FFmpeg (વિડિયોમાંથી ઓડિયો કાઢવા માટે)
- PHP એક્સ્ટેન્શન્સ: curl, json, pdo, pdo_mysql
- SSL પ્રમાણપત્ર (webhook માટે)

## સ્થાપના

### 1. ફાઇલો અપલોડ કરો

બધા પ્રોજેક્ટ ફાઇલો તમારા cPanel હોસ્ટ પર અપલોડ કરો.

### 2. સ્થાપના ચલાવો

આવશ્યકતાઓ ચકાસવા માટે `install.php` તમારા બ્રાઉઝરમાં ચલાવો.

### 3. ડેટાબેઝ કોન્ફિગર કરો

1. MySQL ડેટાબેઝ બનાવો
2. `config.php` એડિટ કરો અને ડેટાબેઝ માહિતી દાખલ કરો

### 4. ટેલિગ્રામ બોટ બનાવો

1. ટેલિગ્રામમાં [@BotFather](https://t.me/botfather) સાથે વાત કરો
2. `/newbot` આદેશ મોકલો
3. બોટનું નામ અને વપરાશકર્તા નામ પસંદ કરો
4. બોટ ટોકન કોપી કરો
5. ટોકન `config.php` માં દાખલ કરો

### 5. API કોન્ફિગર કરો

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) પર જાઓ
2. નવી એપ્લિકેશન બનાવો
3. Instagram Basic Display ઉમેરો
4. API કી મેળવો

#### ACRCloud API (સંગીત ઓળખ)
1. [ACRCloud](https://www.acrcloud.com/) પર જાઓ
2. એકાઉન્ટ બનાવો
3. API કી મેળવો

### 6. Webhook કોન્ફિગર કરો

`setup.php` ચલાવો:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. બોટ ટેસ્ટ કરો

`test.php` ચલાવો:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## ઉપયોગ

1. ટેલિગ્રામમાં બોટ શોધો
2. `/start` આદેશ મોકલો
3. Instagram Reels લિંક મોકલો
4. સંગીત ઓળખ માટે રાહ જુઓ

## ફાઇલ માળખું

```
/
├── config.php              # મુખ્ય કોન્ફિગરેશન
├── database.php            # ડેટાબેઝ ક્લાસ
├── instagram_handler.php   # Instagram પ્રોસેસિંગ
├── music_recognizer.php    # સંગીત ઓળખ
├── telegram_bot.php        # ટેલિગ્રામ બોટ ક્લાસ
├── webhook.php            # Webhook મેનેજર
├── setup.php              # કોન્ફિગરેશન
├── test.php               # બોટ ટેસ્ટ
├── install.php            # સ્થાપના
├── index.php              # મુખ્ય પેજ
└── README.md              # દસ્તાવેજીકરણ
```

## સપોર્ટેડ API

### સંગીત ઓળખ
- **ACRCloud**: મુખ્ય સંગીત ઓળખ સેવા
- **Shazam**: ACRCloud વિકલ્પ

### Instagram
- **Instagram Basic Display API**: Instagram કન્ટેન્ટ પર એક્સેસ

## એડવાન્સ્ડ કોન્ફિગરેશન

### ફાઇલ મર્યાદાઓ
`.htaccess` ફાઇલમાં:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### સુરક્ષા
- `config.php` ને પબ્લિક એક્સેસથી સુરક્ષિત કરો
- માન્ય SSL પ્રમાણપત્ર વાપરો
- મજબૂત પાસવર્ડ પસંદ કરો

## સમસ્યાઓ ઉકેલવી

### સામાન્ય સમસ્યાઓ

1. **ડેટાબેઝ કનેક્શન એરર**
   - ડેટાબેઝ માહિતી ચકાસો
   - ડેટાબેઝ બનાવવામાં આવ્યું છે તેની ખાતરી કરો

2. **FFmpeg એરર**
   - FFmpeg ઇન્સ્ટોલ કરો
   - કોડમાં FFmpeg પાથ સેટ કરો

3. **API એરર**
   - API કીઓ ચકાસો
   - API મર્યાદાઓ ધ્યાનમાં લો

4. **Webhook એરર**
   - SSL પ્રમાણપત્ર ચકાસો
   - Webhook URL સાચી રીતે સેટ કરો

## સપોર્ટ

સપોર્ટ અને એરર રિપોર્ટ્સ માટે, ડેવલપર સાથે સંપર્ક કરો.

## લાઇસન્સ

આ પ્રોજેક્ટ MIT લાઇસન્સ હેઠળ લાઇસન્સ કરવામાં આવ્યું છે.
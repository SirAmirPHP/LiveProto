# Bot Telegram ar gyfer Adnabod Cerddoriaeth

Gall y bot Telegram hwn adnabod cerddoriaeth o Instagram Reels. Gall defnyddwyr anfon dolenni Instagram Reels a bydd y bot yn adnabod enw'r gân a'r artist.

## Nodweddion

- 🎵 Adnabod cerddoriaeth o Instagram Reels
- 🎤 Dangos enw'r artist a'r gân
- 💿 Dangos gwybodaeth am yr albwm (os ar gael)
- 📅 Dangos blwyddyn y rhyddhad
- 🎯 Dangos canran hyder
- 💾 Cadw hanes yn y gronfa ddata
- 🔒 Diogelwch uchel a diogelu data

## Gofynion

- PHP 7.4 neu uwch
- MySQL 5.7 neu uwch
- FFmpeg (i echdynnu sain o fideo)
- PHP Extensions: curl, json, pdo, pdo_mysql
- Tystysgrif SSL (ar gyfer webhook)

## Gosod

### 1. Uwchlwytho Ffeiliau

Uwchlwythwch holl ffeiliau'r prosiect i'ch gwesteiwr cPanel.

### 2. Rhedeg y Gosod

Rhedegwch `install.php` yn eich porwr i wirio'r gofynion.

### 3. Gosod y Gronfa Ddata

1. Creu cronfa ddata MySQL
2. Golygu `config.php` a rhoi gwybodaeth y gronfa ddata

### 4. Creu Bot Telegram

1. Sgwrsio gyda [@BotFather](https://t.me/botfather) ar Telegram
2. Anfon gorchymyn `/newbot`
3. Dewis enw'r bot a'r enw defnyddiwr
4. Copïo tocyn y bot
5. Rhoi'r tocyn yn `config.php`

### 5. Gosod API

#### Instagram Basic Display API
1. Mynd i [Facebook Developers](https://developers.facebook.com/)
2. Creu cais newydd
3. Ychwanegu Instagram Basic Display
4. Cael allwedd API

#### ACRCloud API (Adnabod Cerddoriaeth)
1. Mynd i [ACRCloud](https://www.acrcloud.com/)
2. Creu cyfrif
3. Cael allwedd API

### 6. Gosod Webhook

Rhedeg `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Profi'r Bot

Rhedeg `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Defnydd

1. Dod o hyd i'r bot ar Telegram
2. Anfon gorchymyn `/start`
3. Anfon dolyn Instagram Reels
4. Aros am adnabod cerddoriaeth

## Strwythur Ffeiliau

```
/
├── config.php              # Cyfluniad prif
├── database.php            # Dosbarth y gronfa ddata
├── instagram_handler.php   # Prosesu Instagram
├── music_recognizer.php    # Adnabod cerddoriaeth
├── telegram_bot.php        # Dosbarth bot Telegram
├── webhook.php            # Rheolwr webhook
├── setup.php              # Gosodiadau
├── test.php               # Profi'r bot
├── install.php            # Gosod
├── index.php              # Tudalen brif
└── README.md              # Dogfennau
```

## API Cefnogol

### Adnabod Cerddoriaeth
- **ACRCloud**: Gwasanaeth prif adnabod cerddoriaeth
- **Shazam**: Dewis arall i ACRCloud

### Instagram
- **Instagram Basic Display API**: Mynediad i gynnwys Instagram

## Gosodiadau Uwch

### Cyfyngiadau Ffeiliau
Yn ffeil `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Diogelwch
- Diogelu `config.php` rhag mynediad cyhoeddus
- Defnyddio tystysgrif SSL ddilys
- Dewis cyfrineiriau cryf

## Datrys Problemau

### Problemau Cyffredin

1. **Gwall Cysylltiad Gronfa Ddata**
   - Gwirio gwybodaeth y gronfa ddata
   - Sicrhau bod y gronfa ddata wedi'i chreu

2. **Gwall FFmpeg**
   - Gosod FFmpeg
   - Gosod llwybr FFmpeg yn y cod

3. **Gwall API**
   - Gwirio allweddi API
   - Ystyried cyfyngiadau API

4. **Gwall Webhook**
   - Gwirio'r dystysgrif SSL
   - Gosod URL webhook cywir

## Cymorth

Ar gyfer cymorth ac adrodd ar wallau, cysylltwch â'r datblygwr.

## Trwydded

Mae'r prosiect hwn yn cael ei drwyddedu o dan Drwydded MIT.
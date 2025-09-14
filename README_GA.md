# Bot Telegram do Aithint Ceoil

Is féidir leis an mbot Telegram seo ceol a aithint ó Instagram Reels. Is féidir le húsáideoirí naisc Instagram Reels a sheoladh agus aithneoidh an bot ainm an amhráin agus an t-ealaíontóir.

## Gnéithe

- 🎵 Aithint ceoil ó Instagram Reels
- 🎤 Taispeáin ainm an ealaíontóra agus an amhráin
- 💿 Taispeáin eolas an albaim (más ar fáil)
- 📅 Taispeáin bliain an eisiúna
- 🎯 Taispeáin céatadán muiníne
- 💾 Sábháil stair sa bhunachar sonraí
- 🔒 Slándáil ard agus cosaint sonraí

## Riachtanais

- PHP 7.4 nó níos airde
- MySQL 5.7 nó níos airde
- FFmpeg (chun fuaime a bhaint as físeán)
- PHP Extensions: curl, json, pdo, pdo_mysql
- Teastas SSL (do webhook)

## Suiteáil

### 1. Comhaid a Uaslódáil

Uaslódáil gach comhad den tionscadal chuig do óstach cPanel.

### 2. Suiteáil a Rith

Rith `install.php` i do bhrabhsálaí chun na riachtanais a sheiceáil.

### 3. Bunachar Sonraí a Shocrú

1. Cruthaigh bunachar sonraí MySQL
2. Cuir `config.php` in eagar agus cuir isteach eolas an bhunachair sonraí

### 4. Bot Telegram a Chruthú

1. Comhrá le [@BotFather](https://t.me/botfather) ar Telegram
2. Seol ordú `/newbot`
3. Roghnaigh ainm an bhot agus ainm úsáideora
4. Cóipeáil token an bhot
5. Cuir isteach an token i `config.php`

### 5. APIanna a Shocrú

#### Instagram Basic Display API
1. Téigh go [Facebook Developers](https://developers.facebook.com/)
2. Cruthaigh feidhmchlár nua
3. Cuir Instagram Basic Display leis
4. Faigh eochair API

#### ACRCloud API (Aithint Ceoil)
1. Téigh go [ACRCloud](https://www.acrcloud.com/)
2. Cruthaigh cuntas
3. Faigh eochair API

### 6. Webhook a Shocrú

Rith `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot a Thástáil

Rith `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Úsáid

1. Faigh an bot ar Telegram
2. Seol ordú `/start`
3. Seol nasc Instagram Reels
4. Fan ar aithint ceoil

## Struchtúr Comhad

```
/
├── config.php              # Príomhchumraíocht
├── database.php            # Aicme bunachair sonraí
├── instagram_handler.php   # Próiseáil Instagram
├── music_recognizer.php    # Aithint ceoil
├── telegram_bot.php        # Aicme bot Telegram
├── webhook.php            # Bainisteoir webhook
├── setup.php              # Socruithe
├── test.php               # Tástáil bot
├── install.php            # Suiteáil
├── index.php              # Príomhleathanach
└── README.md              # Doiciméadú
```

## APIanna Tacaíochta

### Aithint Ceoil
- **ACRCloud**: Príomhsheirbhís aithint ceoil
- **Shazam**: Rogha eile seachas ACRCloud

### Instagram
- **Instagram Basic Display API**: Rochtain ar ábhar Instagram

## Socruithe Casta

### Teorainneacha Comhad
I gcomhad `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Slándáil
- Cosain `config.php` ó rochtain phoiblí
- Úsáid teastas SSL bailí
- Roghnaigh pasfhocail láidre

## Réiteach Fadhbanna

### Fadhbanna Coitianta

1. **Earráid Nasc Bunachair Sonraí**
   - Seiceáil eolas an bhunachair sonraí
   - Cinntigh go bhfuil an bunachar sonraí cruthaithe

2. **Earráid FFmpeg**
   - Suiteáil FFmpeg
   - Socrú cosán FFmpeg sa chód

3. **Earráid API**
   - Seiceáil eochracha API
   - Smaoinigh ar theorainneacha API

4. **Earráid Webhook**
   - Seiceáil teastas SSL
   - Socrú URL webhook ceart

## Tacaíocht

Le haghaidh tacaíochta agus tuairiscí ar fhabhtanna, déan teagmháil leis an bhforbróir le do thoil.

## Ceadúnas

Tá an tionscadal seo ceadúnaithe faoi Cheadúnas MIT.
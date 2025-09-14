# Telegram Mūzikas Atpazīšanas Bot

Šis Telegram bots var identificēt mūziku no Instagram Reels. Lietotāji var nosūtīt Instagram Reels saites un bots identificēs dziesmas nosaukumu un izpildītāju.

## Funkcijas

- 🎵 Mūzikas atpazīšana no Instagram Reels
- 🎤 Izpildītāja un dziesmas nosaukuma rādīšana
- 💿 Albuma informācijas rādīšana (ja pieejama)
- 📅 Izdošanas gada rādīšana
- 🎯 Uzticamības procenta rādīšana
- 💾 Vēstures saglabāšana datubāzē
- 🔒 Augsta drošība un datu aizsardzība

## Prasības

- PHP 7.4 vai augstāks
- MySQL 5.7 vai augstāks
- FFmpeg (audio izvilkšanai no video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL sertifikāts (webhook)

## Instalācija

### 1. Failu Augšupielāde

Augšupielādējiet visus projekta failus uz savu cPanel hostu.

### 2. Instalācijas Palaidšana

Palaidiet `install.php` savā pārlūkprogrammā, lai pārbaudītu prasības.

### 3. Datubāzes Iestatīšana

1. Izveidojiet MySQL datubāzi
2. Rediģējiet `config.php` un ievadiet datubāzes informāciju

### 4. Telegram Bota Izveidošana

1. Sarunājieties ar [@BotFather](https://t.me/botfather) Telegram
2. Nosūtiet `/newbot` komandu
3. Izvēlieties bota nosaukumu un lietotājvārdu
4. Nokopējiet bota tokenu
5. Ievadiet tokenu `config.php`

### 5. API Iestatīšana

#### Instagram Basic Display API
1. Dodieties uz [Facebook Developers](https://developers.facebook.com/)
2. Izveidojiet jaunu lietotni
3. Pievienojiet Instagram Basic Display
4. Iegūstiet API atslēgu

#### ACRCloud API (Mūzikas Atpazīšana)
1. Dodieties uz [ACRCloud](https://www.acrcloud.com/)
2. Izveidojiet kontu
3. Iegūstiet API atslēgu

### 6. Webhook Iestatīšana

Palaidiet `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bota Testēšana

Palaidiet `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Lietošana

1. Atrodiet botu Telegram
2. Nosūtiet `/start` komandu
3. Nosūtiet Instagram Reels saiti
4. Gaidiet mūzikas atpazīšanu

## Failu Struktūra

```
/
├── config.php              # Galvenā konfigurācija
├── database.php            # Datubāzes klase
├── instagram_handler.php   # Instagram apstrāde
├── music_recognizer.php    # Mūzikas atpazīšana
├── telegram_bot.php        # Telegram bota klase
├── webhook.php            # Webhook apstrādātājs
├── setup.php              # Iestatījumi
├── test.php               # Bota testēšana
├── install.php            # Instalācija
├── index.php              # Galvenā lapa
└── README.md              # Dokumentācija
```

## Atbalstītie API

### Mūzikas Atpazīšana
- **ACRCloud**: Galvenais mūzikas atpazīšanas pakalpojums
- **Shazam**: ACRCloud alternatīva

### Instagram
- **Instagram Basic Display API**: Piekļuve Instagram saturam

## Papildu Iestatījumi

### Failu Ierobežojumi
`.htaccess` failā:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Drošība
- Aizsargājiet `config.php` no publiskas piekļuves
- Izmantojiet derīgu SSL sertifikātu
- Izvēlieties spēcīgas paroles

## Problēmu Risināšana

### Biežas Problēmas

1. **Datubāzes Savienojuma Kļūda**
   - Pārbaudiet datubāzes informāciju
   - Pārliecinieties, ka datubāze ir izveidota

2. **FFmpeg Kļūda**
   - Instalējiet FFmpeg
   - Iestatiet FFmpeg ceļu kodā

3. **API Kļūda**
   - Pārbaudiet API atslēgas
   - Apsveriet API ierobežojumus

4. **Webhook Kļūda**
   - Pārbaudiet SSL sertifikātu
   - Iestatiet pareizo webhook URL

## Atbalsts

Atbalstam un kļūdu ziņošanai lūdzu sazinieties ar izstrādātāju.

## Licence

Šis projekts ir licencēts saskaņā ar MIT licenci.
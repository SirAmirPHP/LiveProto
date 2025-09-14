# Telegram Muusika Tuvastamise Bot

See Telegram bot saab tuvastada muusikat Instagram Reels-ist. Kasutajad saavad saata Instagram Reels linke ja bot tuvastab laulu nime ja esitaja.

## Funktsioonid

- 🎵 Muusika tuvastamine Instagram Reels-ist
- 🎤 Esitaja ja laulu nime kuvamine
- 💿 Albumi teabe kuvamine (kui saadaval)
- 📅 Väljaandmise aasta kuvamine
- 🎯 Usaldusväärsuse protsendi kuvamine
- 💾 Ajaloo salvestamine andmebaasi
- 🔒 Kõrge turvalisus ja andmete kaitse

## Nõuded

- PHP 7.4 või kõrgem
- MySQL 5.7 või kõrgem
- FFmpeg (audio eraldamiseks videost)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL sertifikaat (webhook jaoks)

## Paigaldamine

### 1. Failide Üleslaadimine

Laadige kõik projekti failid üles oma cPanel hostile.

### 2. Paigalduse Käivitamine

Käivitage `install.php` oma brauseris nõuete kontrollimiseks.

### 3. Andmebaasi Seadistamine

1. Looge MySQL andmebaas
2. Redigeerige `config.php` ja sisestage andmebaasi teave

### 4. Telegram Boti Loomine

1. Vestelge [@BotFather](https://t.me/botfather)-iga Telegramis
2. Saadake `/newbot` käsk
3. Valige boti nimi ja kasutajanimi
4. Kopeerige boti token
5. Sisestage token `config.php`-sse

### 5. API-de Seadistamine

#### Instagram Basic Display API
1. Minge [Facebook Developers](https://developers.facebook.com/)-ile
2. Looge uus rakendus
3. Lisage Instagram Basic Display
4. Hankige API võti

#### ACRCloud API (Muusika Tuvastamine)
1. Minge [ACRCloud](https://www.acrcloud.com/)-ile
2. Looge konto
3. Hankige API võti

### 6. Webhook Seadistamine

Käivitage `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Boti Testimine

Käivitage `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Kasutamine

1. Leidke bot Telegramis
2. Saadake `/start` käsk
3. Saadake Instagram Reels link
4. Oodake muusika tuvastamist

## Failide Struktuur

```
/
├── config.php              # Peamine konfiguratsioon
├── database.php            # Andmebaasi klass
├── instagram_handler.php   # Instagram töötlemine
├── music_recognizer.php    # Muusika tuvastamine
├── telegram_bot.php        # Telegram boti klass
├── webhook.php            # Webhook käsitleja
├── setup.php              # Seaded
├── test.php               # Boti testimine
├── install.php            # Paigaldamine
├── index.php              # Pealeht
└── README.md              # Dokumentatsioon
```

## Toetatud API-d

### Muusika Tuvastamine
- **ACRCloud**: Peamine muusika tuvastamise teenus
- **Shazam**: ACRCloud alternatiiv

### Instagram
- **Instagram Basic Display API**: Juurdepääs Instagram sisule

## Täpsemad Seaded

### Failide Piirangud
`.htaccess` failis:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Turvalisus
- Kaitse `config.php` avaliku juurdepääsu eest
- Kasutage kehtivat SSL sertifikaati
- Valige tugevad paroolid

## Probleemide Lahendamine

### Levinud Probleemid

1. **Andmebaasi Ühenduse Viga**
   - Kontrollige andmebaasi teavet
   - Veenduge, et andmebaas on loodud

2. **FFmpeg Viga**
   - Installige FFmpeg
   - Määrake FFmpeg tee koodis

3. **API Viga**
   - Kontrollige API võtmeid
   - Arvestage API piirangutega

4. **Webhook Viga**
   - Kontrollige SSL sertifikaati
   - Määrake õige webhook URL

## Tugi

Toe ja vigade raporteerimise jaoks võtke ühendust arendajaga.

## Litsents

See projekt on litsentsitud MIT litsentsi all.
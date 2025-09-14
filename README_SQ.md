# Bot Telegram për Njohjen e Muzikës

Ky bot Telegram mund të identifikojë muzikën nga Instagram Reels. Përdoruesit mund të dërgojnë lidhje Instagram Reels dhe boti do të identifikojë emrin e këngës dhe artistin.

## Funksionet

- 🎵 Njohja e muzikës nga Instagram Reels
- 🎤 Shfaqja e emrit të artistit dhe këngës
- 💿 Shfaqja e informacioneve të albumit (nëse janë të disponueshme)
- 📅 Shfaqja e vitit të lëshimit
- 🎯 Shfaqja e përqindjes së besimit
- 💾 Ruajtja e historisë në bazën e të dhënave
- 🔒 Siguria e lartë dhe mbrojtja e të dhënave

## Kërkesat

- PHP 7.4 ose më e lartë
- MySQL 5.7 ose më e lartë
- FFmpeg (për nxjerrjen e audios nga video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- Certifikata SSL (për webhook)

## Instalimi

### 1. Ngarkimi i Skedarëve

Ngarkoni të gjitha skedarët e projektit në hostin tuaj cPanel.

### 2. Ekzekutimi i Instalimit

Ekzekutoni `install.php` në shfletuesin tuaj për të kontrolluar kërkesat.

### 3. Konfigurimi i Bazës së të Dhënave

1. Krijoni bazën e të dhënave MySQL
2. Redaktoni `config.php` dhe futni informacionet e bazës së të dhënave

### 4. Krijimi i Bot Telegram

1. Bisedoni me [@BotFather](https://t.me/botfather) në Telegram
2. Dërgoni komandën `/newbot`
3. Zgjidhni emrin e botit dhe emrin e përdoruesit
4. Kopjoni tokenin e botit
5. Futni tokenin në `config.php`

### 5. Konfigurimi i API

#### Instagram Basic Display API
1. Shkoni te [Facebook Developers](https://developers.facebook.com/)
2. Krijoni një aplikacion të ri
3. Shtoni Instagram Basic Display
4. Merrni çelësin API

#### ACRCloud API (Njohja e Muzikës)
1. Shkoni te [ACRCloud](https://www.acrcloud.com/)
2. Krijoni një llogari
3. Merrni çelësin API

### 6. Konfigurimi i Webhook

Ekzekutoni `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testimi i Botit

Ekzekutoni `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Përdorimi

1. Gjeni botin në Telegram
2. Dërgoni komandën `/start`
3. Dërgoni lidhjen Instagram Reels
4. Prisni për njohjen e muzikës

## Struktura e Skedarëve

```
/
├── config.php              # Konfigurimi kryesor
├── database.php            # Klasa e bazës së të dhënave
├── instagram_handler.php   # Përpunimi i Instagram
├── music_recognizer.php    # Njohja e muzikës
├── telegram_bot.php        # Klasa e bot Telegram
├── webhook.php            # Menaxheri i webhook
├── setup.php              # Cilësimet
├── test.php               # Testimi i botit
├── install.php            # Instalimi
├── index.php              # Faqja kryesore
└── README.md              # Dokumentacioni
```

## API të Mbështetura

### Njohja e Muzikës
- **ACRCloud**: Shërbimi kryesor i njohjes së muzikës
- **Shazam**: Alternativa për ACRCloud

### Instagram
- **Instagram Basic Display API**: Qasja në përmbajtjen e Instagram

## Cilësimet e Avancuara

### Kufizimet e Skedarëve
Në skedarin `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Siguria
- Mbrojini `config.php` nga qasja publike
- Përdorni certifikatën SSL të vlefshme
- Zgjidhni fjalëkalime të forta

## Zgjidhja e Problemeve

### Problemet e Zakonshme

1. **Gabimi i Lidhjes me Bazën e të Dhënave**
   - Kontrolloni informacionet e bazës së të dhënave
   - Sigurohuni që baza e të dhënave është krijuar

2. **Gabimi FFmpeg**
   - Instaloni FFmpeg
   - Vendosni rrugën e FFmpeg në kod

3. **Gabimi API**
   - Kontrolloni çelësat API
   - Konsideroni kufizimet e API

4. **Gabimi Webhook**
   - Kontrolloni certifikatën SSL
   - Vendosni URL-në e saktë të webhook

## Mbështetja

Për mbështetje dhe raportimin e gabimeve, ju lutemi kontaktoni zhvilluesin.

## Licenca

Ky projekt është i licencuar nën Licencën MIT.
# Telegram Bot pro Rozpoznávání Hudby

Tento Telegram bot může identifikovat hudbu z Instagram Reels. Uživatelé mohou posílat odkazy Instagram Reels a bot identifikuje název písně a umělce.

## Funkce

- 🎵 Rozpoznávání hudby z Instagram Reels
- 🎤 Zobrazení umělce a názvu písně
- 💿 Zobrazení informací o albu (pokud je k dispozici)
- 📅 Zobrazení roku vydání
- 🎯 Zobrazení procenta spolehlivosti
- 💾 Uložení historie do databáze
- 🔒 Vysoká bezpečnost a ochrana dat

## Požadavky

- PHP 7.4 nebo vyšší
- MySQL 5.7 nebo vyšší
- FFmpeg (pro extrakci zvuku z videa)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL certifikát (pro webhook)

## Instalace

### 1. Nahrání Souborů

Nahrajte všechny soubory projektu na váš cPanel host.

### 2. Spuštění Instalace

Spusťte `install.php` ve vašem prohlížeči pro kontrolu požadavků.

### 3. Nastavení Databáze

1. Vytvořte MySQL databázi
2. Upravte `config.php` a zadejte informace o databázi

### 4. Vytvoření Telegram Bota

1. Chatujte s [@BotFather](https://t.me/botfather) na Telegramu
2. Pošlete příkaz `/newbot`
3. Vyberte název bota a uživatelské jméno
4. Zkopírujte token bota
5. Zadejte token do `config.php`

### 5. Nastavení API

#### Instagram Basic Display API
1. Přejděte na [Facebook Developers](https://developers.facebook.com/)
2. Vytvořte novou aplikaci
3. Přidejte Instagram Basic Display
4. Získejte API klíč

#### ACRCloud API (Rozpoznávání Hudby)
1. Přejděte na [ACRCloud](https://www.acrcloud.com/)
2. Vytvořte účet
3. Získejte API klíč

### 6. Nastavení Webhook

Spusťte `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testování Bota

Spusťte `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Použití

1. Najděte bota na Telegramu
2. Pošlete příkaz `/start`
3. Pošlete odkaz Instagram Reels
4. Čekejte na rozpoznání hudby

## Struktura Souborů

```
/
├── config.php              # Hlavní konfigurace
├── database.php            # Třída databáze
├── instagram_handler.php   # Zpracování Instagram
├── music_recognizer.php    # Rozpoznávání hudby
├── telegram_bot.php        # Třída Telegram bota
├── webhook.php            # Handler webhook
├── setup.php              # Nastavení
├── test.php               # Testování bota
├── install.php            # Instalace
├── index.php              # Hlavní stránka
└── README.md              # Dokumentace
```

## Podporované API

### Rozpoznávání Hudby
- **ACRCloud**: Hlavní služba rozpoznávání hudby
- **Shazam**: Alternativa k ACRCloud

### Instagram
- **Instagram Basic Display API**: Přístup k obsahu Instagram

## Pokročilé Nastavení

### Limity Souborů
V souboru `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Bezpečnost
- Chraňte `config.php` před veřejným přístupem
- Používejte platný SSL certifikát
- Vyberte silná hesla

## Řešení Problémů

### Běžné Problémy

1. **Chyba Připojení k Databázi**
   - Zkontrolujte informace o databázi
   - Ujistěte se, že je databáze vytvořena

2. **Chyba FFmpeg**
   - Nainstalujte FFmpeg
   - Nastavte cestu FFmpeg v kódu

3. **Chyba API**
   - Zkontrolujte API klíče
   - Zvažte omezení API

4. **Chyba Webhook**
   - Zkontrolujte SSL certifikát
   - Nastavte správnou URL webhook

## Podpora

Pro podporu a hlášení chyb kontaktujte vývojáře.

## Licence

Tento projekt je licencován pod MIT licencí.
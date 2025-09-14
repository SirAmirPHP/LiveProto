# Telegram Bot pre Rozpoznávanie Hudby

Tento Telegram bot môže identifikovať hudbu z Instagram Reels. Používatelia môžu posielať odkazy Instagram Reels a bot identifikuje názov piesne a umelca.

## Funkcie

- 🎵 Rozpoznávanie hudby z Instagram Reels
- 🎤 Zobrazenie umelca a názvu piesne
- 💿 Zobrazenie informácií o albume (ak je k dispozícii)
- 📅 Zobrazenie roku vydania
- 🎯 Zobrazenie percenta spoľahlivosti
- 💾 Uloženie histórie do databázy
- 🔒 Vysoká bezpečnosť a ochrana údajov

## Požiadavky

- PHP 7.4 alebo vyššie
- MySQL 5.7 alebo vyššie
- FFmpeg (pre extrakciu zvuku z videa)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL certifikát (pre webhook)

## Inštalácia

### 1. Nahratie Súborov

Nahrajte všetky súbory projektu na váš cPanel host.

### 2. Spustenie Inštalácie

Spustite `install.php` vo vašom prehliadači pre kontrolu požiadaviek.

### 3. Nastavenie Databázy

1. Vytvorte MySQL databázu
2. Upravte `config.php` a zadajte informácie o databáze

### 4. Vytvorenie Telegram Bota

1. Chatujte s [@BotFather](https://t.me/botfather) na Telegrame
2. Pošlite príkaz `/newbot`
3. Vyberte názov bota a používateľské meno
4. Skopírujte token bota
5. Zadajte token do `config.php`

### 5. Nastavenie API

#### Instagram Basic Display API
1. Prejdite na [Facebook Developers](https://developers.facebook.com/)
2. Vytvorte novú aplikáciu
3. Pridajte Instagram Basic Display
4. Získajte API kľúč

#### ACRCloud API (Rozpoznávanie Hudby)
1. Prejdite na [ACRCloud](https://www.acrcloud.com/)
2. Vytvorte účet
3. Získajte API kľúč

### 6. Nastavenie Webhook

Spustite `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testovanie Bota

Spustite `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Použitie

1. Nájdite bota na Telegrame
2. Pošlite príkaz `/start`
3. Pošlite odkaz Instagram Reels
4. Čakajte na rozpoznanie hudby

## Štruktúra Súborov

```
/
├── config.php              # Hlavná konfigurácia
├── database.php            # Trieda databázy
├── instagram_handler.php   # Spracovanie Instagram
├── music_recognizer.php    # Rozpoznávanie hudby
├── telegram_bot.php        # Trieda Telegram bota
├── webhook.php            # Handler webhook
├── setup.php              # Nastavenia
├── test.php               # Testovanie bota
├── install.php            # Inštalácia
├── index.php              # Hlavná stránka
└── README.md              # Dokumentácia
```

## Podporované API

### Rozpoznávanie Hudby
- **ACRCloud**: Hlavná služba rozpoznávania hudby
- **Shazam**: Alternatíva k ACRCloud

### Instagram
- **Instagram Basic Display API**: Prístup k obsahu Instagram

## Pokročilé Nastavenia

### Limity Súborov
V súbore `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Bezpečnosť
- Chráňte `config.php` pred verejným prístupom
- Používajte platný SSL certifikát
- Vyberte silné heslá

## Riešenie Problémov

### Bežné Problémy

1. **Chyba Pripojenia k Databáze**
   - Skontrolujte informácie o databáze
   - Uistite sa, že je databáza vytvorená

2. **Chyba FFmpeg**
   - Nainštalujte FFmpeg
   - Nastavte cestu FFmpeg v kóde

3. **Chyba API**
   - Skontrolujte API kľúče
   - Zvážte obmedzenia API

4. **Chyba Webhook**
   - Skontrolujte SSL certifikát
   - Nastavte správnu URL webhook

## Podpora

Pre podporu a hlásenie chýb kontaktujte vývojára.

## Licencia

Tento projekt je licencovaný pod MIT licenciou.
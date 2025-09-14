# Telegram Zene Felismerő Bot

Ez a Telegram bot képes zenét azonosítani Instagram Reels-ből. A felhasználók Instagram Reels linkeket küldhetnek, és a bot azonosítja a dal nevét és az előadót.

## Funkciók

- 🎵 Zene felismerés Instagram Reels-ből
- 🎤 Előadó és dal nevének megjelenítése
- 💿 Album információinak megjelenítése (ha elérhető)
- 📅 Megjelenítési év megjelenítése
- 🎯 Bizalmi százalék megjelenítése
- 💾 Előzmények mentése adatbázisba
- 🔒 Magas biztonság és adatvédelem

## Követelmények

- PHP 7.4 vagy magasabb
- MySQL 5.7 vagy magasabb
- FFmpeg (hang kinyeréséhez videóból)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL tanúsítvány (webhook-hoz)

## Telepítés

### 1. Fájlok Feltöltése

Töltse fel a projekt összes fájlját a cPanel host-ra.

### 2. Telepítés Futtatása

Futtassa `install.php`-t a böngészőben a követelmények ellenőrzéséhez.

### 3. Adatbázis Beállítása

1. MySQL adatbázis létrehozása
2. `config.php` szerkesztése és adatbázis információk megadása

### 4. Telegram Bot Létrehozása

1. Beszélgetés [@BotFather](https://t.me/botfather)-rel Telegramon
2. `/newbot` parancs küldése
3. Bot név és felhasználónév kiválasztása
4. Bot token másolása
5. Token megadása `config.php`-ben

### 5. API-k Beállítása

#### Instagram Basic Display API
1. Látogasson a [Facebook Developers](https://developers.facebook.com/)-ra
2. Új alkalmazás létrehozása
3. Instagram Basic Display hozzáadása
4. API kulcs beszerzése

#### ACRCloud API (Zene Felismerés)
1. Látogasson a [ACRCloud](https://www.acrcloud.com/)-ra
2. Fiók létrehozása
3. API kulcs beszerzése

### 6. Webhook Beállítása

`setup.php` futtatása:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot Tesztelése

`test.php` futtatása:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Használat

1. Bot megkeresése Telegramon
2. `/start` parancs küldése
3. Instagram Reels link küldése
4. Zene felismerésre várás

## Fájl Struktúra

```
/
├── config.php              # Fő konfiguráció
├── database.php            # Adatbázis osztály
├── instagram_handler.php   # Instagram feldolgozás
├── music_recognizer.php    # Zene felismerés
├── telegram_bot.php        # Telegram bot osztály
├── webhook.php            # Webhook kezelő
├── setup.php              # Beállítások
├── test.php               # Bot tesztelés
├── install.php            # Telepítés
├── index.php              # Főoldal
└── README.md              # Dokumentáció
```

## Támogatott API-k

### Zene Felismerés
- **ACRCloud**: Fő zene felismerési szolgáltatás
- **Shazam**: ACRCloud alternatíva

### Instagram
- **Instagram Basic Display API**: Instagram tartalom elérése

## Fejlett Beállítások

### Fájl Korlátok
`.htaccess` fájlban:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Biztonság
- `config.php` védelme nyilvános hozzáférés ellen
- Érvényes SSL tanúsítvány használata
- Erős jelszavak választása

## Hibaelhárítás

### Gyakori Problémák

1. **Adatbázis Kapcsolati Hiba**
   - Adatbázis információk ellenőrzése
   - Biztosítás arról, hogy az adatbázis létrejött

2. **FFmpeg Hiba**
   - FFmpeg telepítése
   - FFmpeg útvonal beállítása a kódban

3. **API Hiba**
   - API kulcsok ellenőrzése
   - API korlátok mérlegelése

4. **Webhook Hiba**
   - SSL tanúsítvány ellenőrzése
   - Helyes webhook URL beállítása

## Támogatás

Támogatásért és hibajelentésekért kérjük, lépjen kapcsolatba a fejlesztővel.

## Licenc

Ez a projekt MIT licenc alatt licencelt.
# Telegram Musik-Erkennungs-Bot

Dieser Telegram-Bot kann Musik aus Instagram Reels identifizieren. Benutzer können Instagram Reels-Links senden und der Bot wird den Song-Namen und Künstler identifizieren.

## Funktionen

- 🎵 Musikerkennung aus Instagram Reels
- 🎤 Anzeige von Künstler- und Song-Namen
- 💿 Anzeige von Album-Informationen (falls verfügbar)
- 📅 Anzeige des Veröffentlichungsjahres
- 🎯 Anzeige des Vertrauensprozentsatzes
- 💾 Speicherung des Verlaufs in der Datenbank
- 🔒 Hohe Sicherheit und Datenschutz

## Anforderungen

- PHP 7.4 oder höher
- MySQL 5.7 oder höher
- FFmpeg (zum Extrahieren von Audio aus Video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL-Zertifikat (für Webhook)

## Installation

### 1. Dateien hochladen

Laden Sie alle Projektdateien auf Ihren cPanel-Host hoch.

### 2. Installation ausführen

Führen Sie `install.php` in Ihrem Browser aus, um die Anforderungen zu überprüfen.

### 3. Datenbank einrichten

1. MySQL-Datenbank erstellen
2. `config.php` bearbeiten und Datenbankinformationen eingeben

### 4. Telegram-Bot erstellen

1. Mit [@BotFather](https://t.me/botfather) auf Telegram chatten
2. `/newbot`-Befehl senden
3. Bot-Namen und Benutzernamen wählen
4. Bot-Token kopieren
5. Token in `config.php` eingeben

### 5. APIs einrichten

#### Instagram Basic Display API
1. Zu [Facebook Developers](https://developers.facebook.com/) gehen
2. Neue Anwendung erstellen
3. Instagram Basic Display hinzufügen
4. API-Schlüssel erhalten

#### ACRCloud API (Musikerkennung)
1. Zu [ACRCloud](https://www.acrcloud.com/) gehen
2. Konto erstellen
3. API-Schlüssel erhalten

### 6. Webhook einrichten

`setup.php` ausführen:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Bot testen

`test.php` ausführen:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Verwendung

1. Bot auf Telegram finden
2. `/start`-Befehl senden
3. Instagram Reels-Link senden
4. Auf Musikerkennung warten

## Dateistruktur

```
/
├── config.php              # Hauptkonfiguration
├── database.php            # Datenbankklasse
├── instagram_handler.php   # Instagram-Verarbeitung
├── music_recognizer.php    # Musikerkennung
├── telegram_bot.php        # Telegram-Bot-Klasse
├── webhook.php            # Webhook-Handler
├── setup.php              # Einrichtung
├── test.php               # Bot-Tests
├── install.php            # Installation
├── index.php              # Hauptseite
└── README.md              # Dokumentation
```

## Unterstützte APIs

### Musikerkennung
- **ACRCloud**: Hauptmusikerkennungsdienst
- **Shazam**: ACRCloud-Alternative

### Instagram
- **Instagram Basic Display API**: Zugriff auf Instagram-Inhalte

## Erweiterte Einstellungen

### Dateigrenzen
In `.htaccess`-Datei:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sicherheit
- `config.php` vor öffentlichem Zugriff schützen
- Gültiges SSL-Zertifikat verwenden
- Starke Passwörter wählen

## Fehlerbehebung

### Häufige Probleme

1. **Datenbankverbindungsfehler**
   - Datenbankinformationen überprüfen
   - Sicherstellen, dass Datenbank erstellt wurde

2. **FFmpeg-Fehler**
   - FFmpeg installieren
   - FFmpeg-Pfad im Code festlegen

3. **API-Fehler**
   - API-Schlüssel überprüfen
   - API-Grenzen berücksichtigen

4. **Webhook-Fehler**
   - SSL-Zertifikat überprüfen
   - Korrekte Webhook-URL festlegen

## Support

Für Support und Fehlermeldungen wenden Sie sich bitte an den Entwickler.

## Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert.
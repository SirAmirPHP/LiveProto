# Bot Telegram do Rozpoznawania Muzyki

Ten bot Telegram może identyfikować muzykę z Instagram Reels. Użytkownicy mogą wysyłać linki Instagram Reels, a bot zidentyfikuje nazwę piosenki i artystę.

## Funkcje

- 🎵 Rozpoznawanie muzyki z Instagram Reels
- 🎤 Wyświetlanie nazwy artysty i piosenki
- 💿 Wyświetlanie informacji o albumie (jeśli dostępne)
- 📅 Wyświetlanie roku wydania
- 🎯 Wyświetlanie procentu pewności
- 💾 Zapisywanie historii w bazie danych
- 🔒 Wysokie bezpieczeństwo i ochrona danych

## Wymagania

- PHP 7.4 lub wyższy
- MySQL 5.7 lub wyższy
- FFmpeg (do wyodrębniania audio z wideo)
- PHP Extensions: curl, json, pdo, pdo_mysql
- Certyfikat SSL (dla webhook)

## Instalacja

### 1. Przesłanie Plików

Prześlij wszystkie pliki projektu na swój host cPanel.

### 2. Uruchomienie Instalacji

Uruchom `install.php` w przeglądarce, aby sprawdzić wymagania.

### 3. Konfiguracja Bazy Danych

1. Utwórz bazę danych MySQL
2. Edytuj `config.php` i wprowadź informacje o bazie danych

### 4. Utworzenie Bota Telegram

1. Porozmawiaj z [@BotFather](https://t.me/botfather) na Telegram
2. Wyślij komendę `/newbot`
3. Wybierz nazwę bota i nazwę użytkownika
4. Skopiuj token bota
5. Wprowadź token w `config.php`

### 5. Konfiguracja API

#### Instagram Basic Display API
1. Przejdź do [Facebook Developers](https://developers.facebook.com/)
2. Utwórz nową aplikację
3. Dodaj Instagram Basic Display
4. Uzyskaj klucz API

#### ACRCloud API (Rozpoznawanie Muzyki)
1. Przejdź do [ACRCloud](https://www.acrcloud.com/)
2. Utwórz konto
3. Uzyskaj klucz API

### 6. Konfiguracja Webhook

Uruchom `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testowanie Bota

Uruchom `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Użycie

1. Znajdź bota na Telegram
2. Wyślij komendę `/start`
3. Wyślij link Instagram Reels
4. Czekaj na rozpoznanie muzyki

## Struktura Plików

```
/
├── config.php              # Konfiguracja główna
├── database.php            # Klasa bazy danych
├── instagram_handler.php   # Przetwarzanie Instagram
├── music_recognizer.php    # Rozpoznawanie muzyki
├── telegram_bot.php        # Klasa bota Telegram
├── webhook.php            # Obsługa webhook
├── setup.php              # Ustawienia
├── test.php               # Testowanie bota
├── install.php            # Instalacja
├── index.php              # Strona główna
└── README.md              # Dokumentacja
```

## Obsługiwane API

### Rozpoznawanie Muzyki
- **ACRCloud**: Główna usługa rozpoznawania muzyki
- **Shazam**: Alternatywa dla ACRCloud

### Instagram
- **Instagram Basic Display API**: Dostęp do treści Instagram

## Ustawienia Zaawansowane

### Limity Plików
W pliku `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Bezpieczeństwo
- Chroń `config.php` przed dostępem publicznym
- Używaj ważnego certyfikatu SSL
- Wybierz silne hasła

## Rozwiązywanie Problemów

### Częste Problemy

1. **Błąd Połączenia z Bazą Danych**
   - Sprawdź informacje o bazie danych
   - Upewnij się, że baza danych została utworzona

2. **Błąd FFmpeg**
   - Zainstaluj FFmpeg
   - Ustaw ścieżkę FFmpeg w kodzie

3. **Błąd API**
   - Sprawdź klucze API
   - Rozważ ograniczenia API

4. **Błąd Webhook**
   - Sprawdź certyfikat SSL
   - Ustaw poprawny URL webhook

## Wsparcie

Aby uzyskać wsparcie i zgłaszać błędy, skontaktuj się z deweloperem.

## Licencja

Ten projekt jest licencjonowany na licencji MIT.
# Bot Telegram pentru Recunoașterea Muzicii

Acest bot Telegram poate identifica muzica din Instagram Reels. Utilizatorii pot trimite linkuri Instagram Reels și botul va identifica numele piesei și artistul.

## Funcții

- 🎵 Recunoașterea muzicii din Instagram Reels
- 🎤 Afișarea numelui artistului și piesei
- 💿 Afișarea informațiilor despre album (dacă este disponibil)
- 📅 Afișarea anului de lansare
- 🎯 Afișarea procentului de încredere
- 💾 Salvarea istoricului în baza de date
- 🔒 Securitate înaltă și protecția datelor

## Cerințe

- PHP 7.4 sau mai mare
- MySQL 5.7 sau mai mare
- FFmpeg (pentru extragerea audio din video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- Certificat SSL (pentru webhook)

## Instalare

### 1. Încărcarea Fișierelor

Încărcați toate fișierele proiectului pe hostul cPanel.

### 2. Rularea Instalării

Rulați `install.php` în browser pentru a verifica cerințele.

### 3. Configurarea Bazei de Date

1. Creați baza de date MySQL
2. Editați `config.php` și introduceți informațiile bazei de date

### 4. Crearea Botului Telegram

1. Discutați cu [@BotFather](https://t.me/botfather) pe Telegram
2. Trimiteți comanda `/newbot`
3. Alegeți numele botului și numele de utilizator
4. Copiați tokenul botului
5. Introduceți tokenul în `config.php`

### 5. Configurarea API-urilor

#### Instagram Basic Display API
1. Accesați [Facebook Developers](https://developers.facebook.com/)
2. Creați o aplicație nouă
3. Adăugați Instagram Basic Display
4. Obțineți cheia API

#### ACRCloud API (Recunoașterea Muzicii)
1. Accesați [ACRCloud](https://www.acrcloud.com/)
2. Creați un cont
3. Obțineți cheia API

### 6. Configurarea Webhook

Rulați `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testarea Botului

Rulați `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Utilizare

1. Găsiți botul pe Telegram
2. Trimiteți comanda `/start`
3. Trimiteți linkul Instagram Reels
4. Așteptați recunoașterea muzicii

## Structura Fișierelor

```
/
├── config.php              # Configurația principală
├── database.php            # Clasa bazei de date
├── instagram_handler.php   # Procesarea Instagram
├── music_recognizer.php    # Recunoașterea muzicii
├── telegram_bot.php        # Clasa botului Telegram
├── webhook.php            # Handler-ul webhook
├── setup.php              # Setările
├── test.php               # Testarea botului
├── install.php            # Instalarea
├── index.php              # Pagina principală
└── README.md              # Documentația
```

## API-uri Suportate

### Recunoașterea Muzicii
- **ACRCloud**: Serviciul principal de recunoaștere a muzicii
- **Shazam**: Alternativa la ACRCloud

### Instagram
- **Instagram Basic Display API**: Accesul la conținutul Instagram

## Setări Avansate

### Limitele Fișierelor
În fișierul `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Securitate
- Protejați `config.php` de accesul public
- Folosiți un certificat SSL valid
- Alegeți parole puternice

## Rezolvarea Problemelor

### Probleme Comune

1. **Eroare de Conectare la Baza de Date**
   - Verificați informațiile bazei de date
   - Asigurați-vă că baza de date este creată

2. **Eroare FFmpeg**
   - Instalați FFmpeg
   - Setați calea FFmpeg în cod

3. **Eroare API**
   - Verificați cheile API
   - Luați în considerare limitările API

4. **Eroare Webhook**
   - Verificați certificatul SSL
   - Setați URL-ul webhook corect

## Suport

Pentru suport și raportarea erorilor, vă rugăm să contactați dezvoltatorul.

## Licență

Acest proiect este licențiat sub Licența MIT.
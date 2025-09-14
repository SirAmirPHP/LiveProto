# Bot Telegram per Riconoscimento Musicale

Questo bot Telegram può identificare la musica dai Reels di Instagram. Gli utenti possono inviare link di Instagram Reels e il bot identificherà il nome della canzone e l'artista.

## Caratteristiche

- 🎵 Riconoscimento musicale dai Reels di Instagram
- 🎤 Mostrare nome dell'artista e della canzone
- 💿 Mostrare informazioni dell'album (se disponibili)
- 📅 Mostrare anno di uscita
- 🎯 Mostrare percentuale di confidenza
- 💾 Salvare cronologia nel database
- 🔒 Alta sicurezza e protezione dei dati

## Requisiti

- PHP 7.4 o superiore
- MySQL 5.7 o superiore
- FFmpeg (per estrarre audio dal video)
- Estensioni PHP: curl, json, pdo, pdo_mysql
- Certificato SSL (per webhook)

## Installazione

### 1. Caricare File

Carica tutti i file del progetto sul tuo host cPanel.

### 2. Eseguire Installazione

Esegui `install.php` nel tuo browser per verificare i requisiti.

### 3. Configurare Database

1. Creare database MySQL
2. Modificare `config.php` e inserire informazioni del database

### 4. Creare Bot Telegram

1. Chattare con [@BotFather](https://t.me/botfather) su Telegram
2. Inviare comando `/newbot`
3. Scegliere nome del bot e username
4. Copiare token del bot
5. Inserire token in `config.php`

### 5. Configurare APIs

#### Instagram Basic Display API
1. Andare su [Facebook Developers](https://developers.facebook.com/)
2. Creare nuova applicazione
3. Aggiungere Instagram Basic Display
4. Ottenere chiave API

#### ACRCloud API (Riconoscimento Musicale)
1. Andare su [ACRCloud](https://www.acrcloud.com/)
2. Creare account
3. Ottenere chiave API

### 6. Configurare Webhook

Eseguire `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testare Bot

Eseguire `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Utilizzo

1. Trovare il bot su Telegram
2. Inviare comando `/start`
3. Inviare link Instagram Reels
4. Aspettare identificazione musicale

## Struttura File

```
/
├── config.php              # Configurazione principale
├── database.php            # Classe database
├── instagram_handler.php   # Elaborazione Instagram
├── music_recognizer.php    # Riconoscimento musicale
├── telegram_bot.php        # Classe bot Telegram
├── webhook.php            # Gestore webhook
├── setup.php              # Configurazione
├── test.php               # Test bot
├── install.php            # Installazione
├── index.php              # Pagina principale
└── README.md              # Documentazione
```

## APIs Supportate

### Riconoscimento Musicale
- **ACRCloud**: Servizio principale di riconoscimento musicale
- **Shazam**: Alternativa ad ACRCloud

### Instagram
- **Instagram Basic Display API**: Accesso al contenuto Instagram

## Impostazioni Avanzate

### Limiti File
Nel file `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sicurezza
- Proteggere `config.php` dall'accesso pubblico
- Usare certificato SSL valido
- Scegliere password forti

## Risoluzione Problemi

### Problemi Comuni

1. **Errore Connessione Database**
   - Verificare informazioni database
   - Assicurarsi che il database sia creato

2. **Errore FFmpeg**
   - Installare FFmpeg
   - Impostare percorso FFmpeg nel codice

3. **Errore API**
   - Verificare chiavi API
   - Considerare limiti API

4. **Errore Webhook**
   - Verificare certificato SSL
   - Impostare URL webhook corretta

## Supporto

Per supporto e segnalazione bug, contattare lo sviluppatore.

## Licenza

Questo progetto è concesso in licenza sotto la Licenza MIT.
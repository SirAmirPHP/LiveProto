# Bot de Telegram per a Reconèixer Música

Aquest bot de Telegram pot reconèixer música des d'Instagram Reels. Els usuaris poden enviar enllaços d'Instagram Reels i el bot identificarà el nom de la cançó i l'artista.

## Característiques

- 🎵 Reconèixement de música des d'Instagram Reels
- 🎤 Mostra el nom de l'artista i la cançó
- 💿 Mostra informació de l'àlbum (si està disponible)
- 📅 Mostra l'any de publicació
- 🎯 Mostra el percentatge de confiança
- 💾 Guarda l'historial a la base de dades
- 🔒 Alta seguretat i protecció de dades

## Requisits

- PHP 7.4 o superior
- MySQL 5.7 o superior
- FFmpeg (per extreure àudio del vídeo)
- Extensions PHP: curl, json, pdo, pdo_mysql
- Certificat SSL (per webhook)

## Instal·lació

### 1. Pujar Fitxers

Puja tots els fitxers del projecte al teu host cPanel.

### 2. Executar Instal·lació

Executa `install.php` al teu navegador per verificar els requisits.

### 3. Configurar Base de Dades

1. Crea una base de dades MySQL
2. Edita `config.php` i introdueix la informació de la base de dades

### 4. Crear Bot de Telegram

1. Parla amb [@BotFather](https://t.me/botfather) a Telegram
2. Envia la comanda `/newbot`
3. Escull el nom i nom d'usuari del bot
4. Copia el token del bot
5. Introdueix el token a `config.php`

### 5. Configurar APIs

#### Instagram Basic Display API
1. Vés a [Facebook Developers](https://developers.facebook.com/)
2. Crea una nova aplicació
3. Afegeix Instagram Basic Display
4. Obtén la clau API

#### ACRCloud API (Reconèixement de Música)
1. Vés a [ACRCloud](https://www.acrcloud.com/)
2. Crea un compte
3. Obtén la clau API

### 6. Configurar Webhook

Executa `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Provar Bot

Executa `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Ús

1. Troba el bot a Telegram
2. Envia la comanda `/start`
3. Envia un enllaç d'Instagram Reels
4. Espera el reconèixement de música

## Estructura de Fitxers

```
/
├── config.php              # Configuració principal
├── database.php            # Classe de base de dades
├── instagram_handler.php   # Processament d'Instagram
├── music_recognizer.php    # Reconèixement de música
├── telegram_bot.php        # Classe del bot de Telegram
├── webhook.php            # Gestor de webhook
├── setup.php              # Configuració
├── test.php               # Prova del bot
├── install.php            # Instal·lació
├── index.php              # Pàgina principal
└── README.md              # Documentació
```

## APIs Suportades

### Reconèixement de Música
- **ACRCloud**: Servei principal de reconèixement de música
- **Shazam**: Alternativa a ACRCloud

### Instagram
- **Instagram Basic Display API**: Accés al contingut d'Instagram

## Configuració Avançada

### Límits de Fitxers
Al fitxer `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Seguretat
- Protegeix `config.php` de l'accés públic
- Utilitza un certificat SSL vàlid
- Escull contrasenyes segures

## Solucionar Problemes

### Problemes Comuns

1. **Error de Connexió a Base de Dades**
   - Verifica la informació de la base de dades
   - Assegura't que la base de dades està creada

2. **Error de FFmpeg**
   - Instal·la FFmpeg
   - Estableix la ruta de FFmpeg al codi

3. **Error d'API**
   - Verifica les claus API
   - Considera els límits d'API

4. **Error de Webhook**
   - Verifica el certificat SSL
   - Estableix la URL del webhook correctament

## Suport

Per a suport i informes d'errors, contacta amb el desenvolupador.

## Llicència

Aquest projecte està llicenciat sota la Llicència MIT.
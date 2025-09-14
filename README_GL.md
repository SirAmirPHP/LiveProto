# Bot de Telegram para Recoñecer Música

Este bot de Telegram pode recoñecer música desde Instagram Reels. Os usuarios poden enviar ligazóns de Instagram Reels e o bot identificará o nome da canción e o artista.

## Características

- 🎵 Recoñecemento de música desde Instagram Reels
- 🎤 Mostra o nome do artista e a canción
- 💿 Mostra información do álbum (se está dispoñible)
- 📅 Mostra o ano de publicación
- 🎯 Mostra a porcentaxe de confianza
- 💾 Garda o historial na base de datos
- 🔒 Alta seguridade e protección de datos

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- FFmpeg (para extraer audio do vídeo)
- Extensións PHP: curl, json, pdo, pdo_mysql
- Certificado SSL (para webhook)

## Instalación

### 1. Subir Ficheiros

Sube todos os ficheiros do proxecto ao teu host cPanel.

### 2. Executar Instalación

Executa `install.php` no teu navegador para verificar os requisitos.

### 3. Configurar Base de Datos

1. Crea unha base de datos MySQL
2. Edita `config.php` e introduce a información da base de datos

### 4. Crear Bot de Telegram

1. Fala con [@BotFather](https://t.me/botfather) en Telegram
2. Envía a comanda `/newbot`
3. Escolle o nome e nome de usuario do bot
4. Copia o token do bot
5. Introduce o token en `config.php`

### 5. Configurar APIs

#### Instagram Basic Display API
1. Vai a [Facebook Developers](https://developers.facebook.com/)
2. Crea unha nova aplicación
3. Engade Instagram Basic Display
4. Obtén a chave API

#### ACRCloud API (Recoñecemento de Música)
1. Vai a [ACRCloud](https://www.acrcloud.com/)
2. Crea unha conta
3. Obtén a chave API

### 6. Configurar Webhook

Executa `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Probar Bot

Executa `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Uso

1. Atopa o bot en Telegram
2. Envía a comanda `/start`
3. Envía unha ligazón de Instagram Reels
4. Espera o recoñecemento de música

## Estrutura de Ficheiros

```
/
├── config.php              # Configuración principal
├── database.php            # Clase de base de datos
├── instagram_handler.php   # Procesamento de Instagram
├── music_recognizer.php    # Recoñecemento de música
├── telegram_bot.php        # Clase do bot de Telegram
├── webhook.php            # Xestor de webhook
├── setup.php              # Configuración
├── test.php               # Proba do bot
├── install.php            # Instalación
├── index.php              # Páxina principal
└── README.md              # Documentación
```

## APIs Soportadas

### Recoñecemento de Música
- **ACRCloud**: Servizo principal de recoñecemento de música
- **Shazam**: Alternativa a ACRCloud

### Instagram
- **Instagram Basic Display API**: Acceso ao contido de Instagram

## Configuración Avanzada

### Límites de Ficheiros
No ficheiro `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Seguridade
- Protexe `config.php` do acceso público
- Usa un certificado SSL válido
- Escolle contrasinais seguros

## Solucionar Problemas

### Problemas Comúns

1. **Error de Conexión a Base de Datos**
   - Verifica a información da base de datos
   - Asegúrate de que a base de datos está creada

2. **Error de FFmpeg**
   - Instala FFmpeg
   - Establece a ruta de FFmpeg no código

3. **Error de API**
   - Verifica as chaves API
   - Considera os límites de API

4. **Error de Webhook**
   - Verifica o certificado SSL
   - Establece a URL do webhook correctamente

## Soporte

Para soporte e informes de erros, contacta co desenvolvedor.

## Licenza

Este proxecto está licenciado baixo a Licenza MIT.
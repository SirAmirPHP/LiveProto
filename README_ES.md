# Bot de Telegram para Reconocimiento de Música

Este bot de Telegram puede identificar música desde Instagram Reels. Los usuarios pueden enviar enlaces de Instagram Reels y el bot identificará el nombre de la canción y el artista.

## Características

- 🎵 Reconocimiento de música desde Instagram Reels
- 🎤 Mostrar nombre del artista y la canción
- 💿 Mostrar información del álbum (si está disponible)
- 📅 Mostrar año de lanzamiento
- 🎯 Mostrar porcentaje de confianza
- 💾 Guardar historial en base de datos
- 🔒 Alta seguridad y protección de datos

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- FFmpeg (para extraer audio del video)
- Extensiones PHP: curl, json, pdo, pdo_mysql
- Certificado SSL (para webhook)

## Instalación

### 1. Subir Archivos

Sube todos los archivos del proyecto a tu host cPanel.

### 2. Ejecutar Instalación

Ejecuta `install.php` en tu navegador para verificar los requisitos.

### 3. Configurar Base de Datos

1. Crear base de datos MySQL
2. Editar `config.php` e ingresar información de la base de datos

### 4. Crear Bot de Telegram

1. Chatear con [@BotFather](https://t.me/botfather) en Telegram
2. Enviar comando `/newbot`
3. Elegir nombre del bot y username
4. Copiar token del bot
5. Ingresar token en `config.php`

### 5. Configurar APIs

#### Instagram Basic Display API
1. Ir a [Facebook Developers](https://developers.facebook.com/)
2. Crear nueva aplicación
3. Agregar Instagram Basic Display
4. Obtener clave API

#### ACRCloud API (Reconocimiento de Música)
1. Ir a [ACRCloud](https://www.acrcloud.com/)
2. Crear cuenta
3. Obtener clave API

### 6. Configurar Webhook

Ejecutar `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Probar Bot

Ejecutar `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Uso

1. Encontrar el bot en Telegram
2. Enviar comando `/start`
3. Enviar enlace de Instagram Reels
4. Esperar identificación de música

## Estructura de Archivos

```
/
├── config.php              # Configuración principal
├── database.php            # Clase de base de datos
├── instagram_handler.php   # Procesamiento de Instagram
├── music_recognizer.php    # Reconocimiento de música
├── telegram_bot.php        # Clase del bot de Telegram
├── webhook.php            # Manejador de webhook
├── setup.php              # Configuración
├── test.php               # Pruebas del bot
├── install.php            # Instalación
├── index.php              # Página principal
└── README.md              # Documentación
```

## APIs Soportadas

### Reconocimiento de Música
- **ACRCloud**: Servicio principal de reconocimiento de música
- **Shazam**: Alternativa a ACRCloud

### Instagram
- **Instagram Basic Display API**: Acceso al contenido de Instagram

## Configuraciones Avanzadas

### Límites de Archivos
En archivo `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Seguridad
- Proteger `config.php` del acceso público
- Usar certificado SSL válido
- Elegir contraseñas seguras

## Solución de Problemas

### Problemas Comunes

1. **Error de Conexión a Base de Datos**
   - Verificar información de la base de datos
   - Asegurar que la base de datos esté creada

2. **Error de FFmpeg**
   - Instalar FFmpeg
   - Establecer ruta de FFmpeg en el código

3. **Error de API**
   - Verificar claves API
   - Considerar límites de API

4. **Error de Webhook**
   - Verificar certificado SSL
   - Establecer URL de webhook correcta

## Soporte

Para soporte y reportes de errores, por favor contactar al desarrollador.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.
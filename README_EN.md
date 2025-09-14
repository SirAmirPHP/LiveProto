# Telegram Music Recognition Bot

This Telegram bot can identify music from Instagram Reels. Users can send Instagram Reels links and the bot will identify the song name and artist.

## Features

- 🎵 Music recognition from Instagram Reels
- 🎤 Display artist and song name
- 💿 Show album information (if available)
- 📅 Show release year
- 🎯 Show confidence percentage
- 💾 Save history in database
- 🔒 High security and data protection

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- FFmpeg (for audio extraction from video)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL Certificate (for webhook)

## Installation

### 1. Upload Files

Upload all project files to your cPanel host.

### 2. Run Installation

Run `install.php` in your browser to check requirements.

### 3. Setup Database

1. Create MySQL database
2. Edit `config.php` and enter database information

### 4. Create Telegram Bot

1. Chat with [@BotFather](https://t.me/botfather) on Telegram
2. Send `/newbot` command
3. Choose bot name and username
4. Copy bot token
5. Enter token in `config.php`

### 5. Setup APIs

#### Instagram Basic Display API
1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create new application
3. Add Instagram Basic Display
4. Get API key

#### ACRCloud API (Music Recognition)
1. Go to [ACRCloud](https://www.acrcloud.com/)
2. Create account
3. Get API key

### 6. Setup Webhook

Run `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Test Bot

Run `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Usage

1. Find the bot on Telegram
2. Send `/start` command
3. Send Instagram Reels link
4. Wait for music identification

## File Structure

```
/
├── config.php              # Main configuration
├── database.php            # Database class
├── instagram_handler.php   # Instagram processing
├── music_recognizer.php    # Music recognition
├── telegram_bot.php        # Telegram bot class
├── webhook.php            # Webhook handler
├── setup.php              # Setup
├── test.php               # Bot testing
├── install.php            # Installation
├── index.php              # Main page
└── README.md              # Documentation
```

## Supported APIs

### Music Recognition
- **ACRCloud**: Main music recognition service
- **Shazam**: ACRCloud alternative

### Instagram
- **Instagram Basic Display API**: Access to Instagram content

## Advanced Settings

### File Limits
In `.htaccess` file:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Security
- Protect `config.php` from public access
- Use valid SSL certificate
- Choose strong passwords

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database information
   - Ensure database is created

2. **FFmpeg Error**
   - Install FFmpeg
   - Set FFmpeg path in code

3. **API Error**
   - Check API keys
   - Consider API limits

4. **Webhook Error**
   - Check SSL certificate
   - Set correct webhook URL

## Support

For support and bug reports, please contact the developer.

## License

This project is licensed under the MIT License.
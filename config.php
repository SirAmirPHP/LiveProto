<?php
/**
 * تنظیمات ربات تلگرام
 * Telegram Bot Configuration
 */

// توکن ربات خود را از @BotFather دریافت کنید
// Get your bot token from @BotFather
define('BOT_TOKEN', 'YOUR_BOT_TOKEN_HERE');

// آدرس وب‌هوک ربات (آدرس کامل فایل bot.php)
// Webhook URL (full URL to bot.php file)
define('WEBHOOK_URL', 'https://yourdomain.com/bot.php');

// مسیر فایل‌های دیتابیس
// Database file paths
define('CHANNELS_FILE', 'channels.txt');
define('DATABASE_FILE', 'database.json');

// Instagram oEmbed / Meta App credentials (optional but recommended for reliability)
if (!defined('FB_APP_ID')) define('FB_APP_ID', '');
if (!defined('FB_APP_SECRET')) define('FB_APP_SECRET', '');
// Override oEmbed endpoint if needed
if (!defined('INSTAGRAM_OEMBED_ENDPOINT')) define('INSTAGRAM_OEMBED_ENDPOINT', 'https://graph.facebook.com/v19.0/instagram_oembed');

// ACRCloud credentials (optional, for advanced recognition if you add audio extraction)
if (!defined('ACRCLOUD_HOST')) define('ACRCLOUD_HOST', '');
if (!defined('ACRCLOUD_ACCESS_KEY')) define('ACRCLOUD_ACCESS_KEY', '');
if (!defined('ACRCLOUD_ACCESS_SECRET')) define('ACRCLOUD_ACCESS_SECRET', '');

// تنظیمات اضافی
// Additional settings
define('BOT_NAME', 'Channel Manager Bot');
define('ADMIN_USER_ID', null); // شناسه عددی ادمین اصلی (اختیاری)

// تنظیمات امنیتی
// Security settings
define('ALLOWED_IPS', []); // لیست IP های مجاز (خالی = همه)
define('MAX_CHANNELS_PER_USER', 10); // حداکثر تعداد کانال برای هر کاربر

// تنظیمات لاگ
// Logging settings
define('ENABLE_LOGGING', true);
define('LOG_FILE', 'bot.log');

// تنظیمات پیام‌ها
// Message settings
define('DEFAULT_LANGUAGE', 'fa'); // fa = فارسی, en = انگلیسی
define('TIMEZONE', 'Asia/Tehran');

// تنظیم منطقه زمانی
date_default_timezone_set(TIMEZONE);

// تابع لاگ
function logMessage($message) {
    if (ENABLE_LOGGING) {
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[$timestamp] $message" . PHP_EOL;
        file_put_contents(LOG_FILE, $log_entry, FILE_APPEND | LOCK_EX);
    }
}

// تابع بررسی IP مجاز
function isAllowedIP($ip) {
    if (empty(ALLOWED_IPS)) {
        return true;
    }
    return in_array($ip, ALLOWED_IPS);
}

// تابع بررسی تعداد کانال‌های کاربر
function checkUserChannelLimit($user_id) {
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    $user_channels = 0;
    
    foreach ($database['channels'] as $channel_id => $owner_id) {
        if ($owner_id == $user_id) {
            $user_channels++;
        }
    }
    
    return $user_channels < MAX_CHANNELS_PER_USER;
}
?>
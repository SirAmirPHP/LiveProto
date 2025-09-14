<?php
/**
 * فایل راه‌اندازی و تست ربات
 * Bot Setup and Test File
 */

require_once 'config.php';

echo "<h1>🤖 راه‌اندازی ربات مدیریت کانال</h1>";

// بررسی تنظیمات
echo "<h2>📋 بررسی تنظیمات</h2>";

if (BOT_TOKEN === 'YOUR_BOT_TOKEN_HERE') {
    echo "❌ توکن ربات تنظیم نشده است. لطفاً در فایل config.php توکن ربات را وارد کنید.<br>";
} else {
    echo "✅ توکن ربات تنظیم شده است.<br>";
}

if (WEBHOOK_URL === 'https://yourdomain.com/bot.php') {
    echo "❌ آدرس وب‌هوک تنظیم نشده است. لطفاً در فایل config.php آدرس صحیح را وارد کنید.<br>";
} else {
    echo "✅ آدرس وب‌هوک تنظیم شده است.<br>";
}

// تست اتصال به API تلگرام
echo "<h2>🔗 تست اتصال به API تلگرام</h2>";

$response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/getMe");
$data = json_decode($response, true);

if ($data['ok']) {
    $bot_info = $data['result'];
    echo "✅ اتصال به API موفقیت‌آمیز بود.<br>";
    echo "نام ربات: " . $bot_info['first_name'] . "<br>";
    echo "نام کاربری: @" . $bot_info['username'] . "<br>";
    echo "شناسه ربات: " . $bot_info['id'] . "<br>";
} else {
    echo "❌ خطا در اتصال به API: " . $data['description'] . "<br>";
}

// تنظیم وب‌هوک
echo "<h2>🔧 تنظیم وب‌هوک</h2>";

if (isset($_GET['set_webhook'])) {
    $webhook_url = WEBHOOK_URL;
    $response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/setWebhook?url=" . urlencode($webhook_url));
    $data = json_decode($response, true);
    
    if ($data['ok']) {
        echo "✅ وب‌هوک با موفقیت تنظیم شد.<br>";
        echo "آدرس وب‌هوک: " . $webhook_url . "<br>";
    } else {
        echo "❌ خطا در تنظیم وب‌هوک: " . $data['description'] . "<br>";
    }
} else {
    echo '<a href="?set_webhook=1" style="background: #0088cc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">تنظیم وب‌هوک</a><br>';
}

// بررسی وضعیت وب‌هوک
echo "<h2>📊 وضعیت وب‌هوک</h2>";

$response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/getWebhookInfo");
$data = json_decode($response, true);

if ($data['ok']) {
    $webhook_info = $data['result'];
    echo "آدرس وب‌هوک: " . $webhook_info['url'] . "<br>";
    echo "تعداد پیام‌های در انتظار: " . $webhook_info['pending_update_count'] . "<br>";
    
    if (isset($webhook_info['last_error_date'])) {
        echo "❌ آخرین خطا: " . $webhook_info['last_error_message'] . "<br>";
        echo "تاریخ خطا: " . date('Y-m-d H:i:s', $webhook_info['last_error_date']) . "<br>";
    } else {
        echo "✅ هیچ خطایی گزارش نشده است.<br>";
    }
}

// بررسی فایل‌های دیتابیس
echo "<h2>💾 وضعیت فایل‌های دیتابیس</h2>";

if (file_exists(DATABASE_FILE)) {
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    $channel_count = count($database['channels']);
    echo "✅ فایل دیتابیس موجود است.<br>";
    echo "تعداد کانال‌های ثبت شده: " . $channel_count . "<br>";
} else {
    echo "⚠️ فایل دیتابیس موجود نیست. در اولین استفاده ایجاد خواهد شد.<br>";
}

if (file_exists(CHANNELS_FILE)) {
    $channels = file_get_contents(CHANNELS_FILE);
    $channel_lines = substr_count($channels, "\n");
    echo "✅ فایل کانال‌ها موجود است.<br>";
    echo "تعداد خطوط: " . $channel_lines . "<br>";
} else {
    echo "⚠️ فایل کانال‌ها موجود نیست. در اولین استفاده ایجاد خواهد شد.<br>";
}

// بررسی مجوزهای فایل
echo "<h2>🔐 بررسی مجوزهای فایل</h2>";

$files_to_check = ['bot.php', 'config.php', DATABASE_FILE, CHANNELS_FILE];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms_octal = substr(sprintf('%o', $perms), -4);
        echo "فایل $file: $perms_octal<br>";
    }
}

// دستورات مفید
echo "<h2>🛠️ دستورات مفید</h2>";
echo '<div style="background: #f0f0f0; padding: 15px; border-radius: 5px; font-family: monospace;">';
echo "حذف وب‌هوک: <a href='https://api.telegram.org/bot" . BOT_TOKEN . "/deleteWebhook' target='_blank'>کلیک کنید</a><br>";
echo "اطلاعات ربات: <a href='https://api.telegram.org/bot" . BOT_TOKEN . "/getMe' target='_blank'>کلیک کنید</a><br>";
echo "وضعیت وب‌هوک: <a href='https://api.telegram.org/bot" . BOT_TOKEN . "/getWebhookInfo' target='_blank'>کلیک کنید</a><br>";
echo '</div>';

// راهنمای استفاده
echo "<h2>📖 راهنمای استفاده</h2>";
echo '<div style="background: #e8f4fd; padding: 15px; border-radius: 5px;">';
echo "<ol>";
echo "<li>ربات را در تلگرام استارت کنید: <code>/start</code></li>";
echo "<li>روی 'افزودن ربات به کانال' کلیک کنید</li>";
echo "<li>ربات را به کانال خود اضافه کنید و به عنوان ادمین تنظیم کنید</li>";
echo "<li>از 'مدیریت کانال' برای تنظیم کپشن و حذف کانال استفاده کنید</li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><small>توسعه داده شده برای هاست cPanel - قابل استفاده با PHP 7.4+</small></p>";
?>
<?php
require_once 'telegram_bot.php';

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

try {
    $bot = new TelegramBot();
    
    echo "<h2>تنظیمات ربات تلگرام</h2>";
    
    // تنظیم webhook
    echo "<h3>تنظیم Webhook:</h3>";
    $webhookResult = $bot->setWebhook();
    if ($webhookResult['ok']) {
        echo "<p style='color: green;'>✅ Webhook با موفقیت تنظیم شد</p>";
    } else {
        echo "<p style='color: red;'>❌ خطا در تنظیم Webhook: " . $webhookResult['description'] . "</p>";
    }
    
    // تست اتصال به دیتابیس
    echo "<h3>تست اتصال دیتابیس:</h3>";
    try {
        $db = new Database();
        echo "<p style='color: green;'>✅ اتصال به دیتابیس موفق</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ خطا در اتصال به دیتابیس: " . $e->getMessage() . "</p>";
    }
    
    // نمایش اطلاعات ربات
    echo "<h3>اطلاعات ربات:</h3>";
    echo "<p><strong>Bot Token:</strong> " . (BOT_TOKEN ? 'تنظیم شده' : 'تنظیم نشده') . "</p>";
    echo "<p><strong>Webhook URL:</strong> " . WEBHOOK_URL . "</p>";
    
    // دستورات مفید
    echo "<h3>دستورات مفید:</h3>";
    echo "<p>برای حذف webhook: <code>setup.php?password=your_password&action=delete_webhook</code></p>";
    echo "<p>برای تست ربات: <code>test.php?password=your_password</code></p>";
    
    // حذف webhook
    if (isset($_GET['action']) && $_GET['action'] === 'delete_webhook') {
        echo "<h3>حذف Webhook:</h3>";
        $deleteResult = $bot->deleteWebhook();
        if ($deleteResult['ok']) {
            echo "<p style='color: green;'>✅ Webhook با موفقیت حذف شد</p>";
        } else {
            echo "<p style='color: red;'>❌ خطا در حذف Webhook: " . $deleteResult['description'] . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ خطا: " . $e->getMessage() . "</p>";
}
?>
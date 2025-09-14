<?php
require_once 'telegram_bot.php';

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

try {
    $bot = new TelegramBot();
    
    echo "<h2>تست ربات تلگرام</h2>";
    
    // تست ارسال پیام
    $testChatId = 'YOUR_CHAT_ID'; // تغییر دهید
    if ($testChatId && $testChatId !== 'YOUR_CHAT_ID') {
        echo "<h3>تست ارسال پیام:</h3>";
        $bot->sendMessage($testChatId, "🧪 این یک پیام تست است!");
        echo "<p style='color: green;'>✅ پیام تست ارسال شد</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ برای تست ارسال پیام، CHAT_ID را تنظیم کنید</p>";
    }
    
    // تست شناسایی آهنگ
    echo "<h3>تست شناسایی آهنگ:</h3>";
    echo "<p>برای تست کامل، لینک ریلز اینستاگرام را در ربات ارسال کنید</p>";
    
    // نمایش آمار
    echo "<h3>آمار استفاده:</h3>";
    try {
        $db = new Database();
        $pdo = $db->getConnection();
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM processed_videos");
        $total = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as users FROM processed_videos");
        $users = $stmt->fetch()['users'];
        
        echo "<p><strong>تعداد کل ویدیوهای پردازش شده:</strong> $total</p>";
        echo "<p><strong>تعداد کاربران منحصر به فرد:</strong> $users</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ خطا در دریافت آمار: " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ خطا: " . $e->getMessage() . "</p>";
}
?>
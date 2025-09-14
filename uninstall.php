<?php
/**
 * فایل حذف نصب ربات
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

// تایید حذف
if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
    ?>
    <!DOCTYPE html>
    <html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>حذف نصب ربات</title>
        <style>
            body { 
                font-family: 'Tahoma', sans-serif; 
                margin: 0; 
                padding: 20px; 
                background: #f5f5f5; 
            }
            .container { 
                max-width: 600px; 
                margin: 0 auto; 
                background: white; 
                padding: 30px; 
                border-radius: 10px; 
                box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
                text-align: center;
            }
            .warning {
                background: #fff3cd;
                color: #856404;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
                border: 1px solid #ffeaa7;
            }
            .btn {
                display: inline-block;
                padding: 12px 25px;
                text-decoration: none;
                border-radius: 5px;
                margin: 10px;
                font-weight: bold;
            }
            .btn-danger {
                background: #dc3545;
                color: white;
            }
            .btn-secondary {
                background: #6c757d;
                color: white;
            }
            .btn:hover {
                opacity: 0.8;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>⚠️ حذف نصب ربات</h1>
            
            <div class="warning">
                <h3>هشدار!</h3>
                <p>این عمل تمام داده‌های ربات را حذف خواهد کرد:</p>
                <ul style="text-align: right;">
                    <li>تمام رکوردهای دیتابیس</li>
                    <li>تاریخچه ویدیوهای پردازش شده</li>
                    <li>اطلاعات کاربران</li>
                    <li>تنظیمات ربات</li>
                </ul>
                <p><strong>این عمل غیرقابل بازگشت است!</strong></p>
            </div>
            
            <p>آیا مطمئن هستید که می‌خواهید ربات را حذف کنید؟</p>
            
            <a href="?password=<?php echo $adminPassword; ?>&confirm=yes" class="btn btn-danger">✅ بله، حذف کن</a>
            <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">❌ لغو</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// حذف نصب
try {
    echo "<h2>حذف نصب ربات شناسایی آهنگ</h2>";
    
    // حذف جداول دیتابیس
    echo "<h3>حذف جداول دیتابیس:</h3>";
    try {
        require_once 'config.php';
        require_once 'database.php';
        $db = new Database();
        $pdo = $db->getConnection();
        
        $tables = ['processed_videos', 'user_sessions'];
        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS $table");
            echo "<p style='color: green;'>✅ جدول $table حذف شد</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ خطا در حذف جداول: " . $e->getMessage() . "</p>";
    }
    
    // حذف فایل‌های موقت
    echo "<h3>حذف فایل‌های موقت:</h3>";
    $tempDir = sys_get_temp_dir();
    $files = glob($tempDir . '/instagram_*');
    $files = array_merge($files, glob($tempDir . '/audio_*'));
    $files = array_merge($files, glob($tempDir . '/shazam_*'));
    
    $deletedCount = 0;
    foreach ($files as $file) {
        if (file_exists($file) && unlink($file)) {
            $deletedCount++;
        }
    }
    echo "<p style='color: green;'>✅ $deletedCount فایل موقت حذف شد</p>";
    
    // حذف فایل‌های پشتیبان
    echo "<h3>حذف فایل‌های پشتیبان:</h3>";
    $backupFiles = glob('backup_*.sql');
    $deletedBackups = 0;
    foreach ($backupFiles as $file) {
        if (file_exists($file) && unlink($file)) {
            $deletedBackups++;
        }
    }
    echo "<p style='color: green;'>✅ $deletedBackups فایل پشتیبان حذف شد</p>";
    
    // حذف webhook
    echo "<h3>حذف Webhook:</h3>";
    try {
        $bot = new TelegramBot();
        $result = $bot->deleteWebhook();
        if ($result['ok']) {
            echo "<p style='color: green;'>✅ Webhook حذف شد</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ خطا در حذف Webhook: " . $result['description'] . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠️ خطا در حذف Webhook: " . $e->getMessage() . "</p>";
    }
    
    // حذف فایل‌های پروژه
    echo "<h3>حذف فایل‌های پروژه:</h3>";
    $filesToDelete = [
        'config.php',
        'database.php',
        'instagram_handler.php',
        'music_recognizer.php',
        'telegram_bot.php',
        'webhook.php',
        'setup.php',
        'test.php',
        'admin.php',
        'backup.php',
        'api.php',
        'cron.php',
        'version.php',
        'uninstall.php',
        '.htaccess'
    ];
    
    $deletedFiles = 0;
    foreach ($filesToDelete as $file) {
        if (file_exists($file) && unlink($file)) {
            $deletedFiles++;
            echo "<p style='color: green;'>✅ $file حذف شد</p>";
        }
    }
    
    echo "<h3>خلاصه حذف:</h3>";
    echo "<p>✅ جداول دیتابیس حذف شدند</p>";
    echo "<p>✅ $deletedCount فایل موقت حذف شد</p>";
    echo "<p>✅ $deletedBackups فایل پشتیبان حذف شد</p>";
    echo "<p>✅ $deletedFiles فایل پروژه حذف شد</p>";
    echo "<p>✅ Webhook حذف شد</p>";
    
    echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3>✅ حذف نصب کامل شد!</h3>";
    echo "<p>ربات شناسایی آهنگ با موفقیت حذف شد. تمام داده‌ها و فایل‌ها پاک شدند.</p>";
    echo "</div>";
    
    echo "<p><a href='index.php'>بازگشت به صفحه اصلی</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ خطا در حذف نصب: " . $e->getMessage() . "</p>";
}
?>
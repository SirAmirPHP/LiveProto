<?php
/**
 * فایل به‌روزرسانی ربات
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

// بررسی نسخه فعلی
$currentVersion = '1.0.0';
$latestVersion = '1.0.0'; // این مقدار باید از سرور دریافت شود

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>به‌روزرسانی ربات</title>
    <style>
        body { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #333; 
            text-align: center; 
            margin-bottom: 30px;
        }
        .version-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .update-available {
            background: #d1ecf1;
            color: #0c5460;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #bee5eb;
        }
        .no-update {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #c3e6cb;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            font-weight: bold;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .changelog {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .changelog h3 {
            margin-top: 0;
            color: #495057;
        }
        .changelog ul {
            margin: 10px 0;
            padding-right: 20px;
        }
        .changelog li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 به‌روزرسانی ربات شناسایی آهنگ</h1>
        
        <div class="version-info">
            <h3>📋 اطلاعات نسخه</h3>
            <p><strong>نسخه فعلی:</strong> <?php echo $currentVersion; ?></p>
            <p><strong>آخرین نسخه:</strong> <?php echo $latestVersion; ?></p>
            <p><strong>تاریخ بررسی:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        
        <?php if (version_compare($currentVersion, $latestVersion, '<')): ?>
            <div class="update-available">
                <h3>🆕 به‌روزرسانی موجود است!</h3>
                <p>نسخه جدید <?php echo $latestVersion; ?> در دسترس است. توصیه می‌شود ربات را به‌روزرسانی کنید.</p>
            </div>
            
            <div class="changelog">
                <h3>📝 تغییرات نسخه <?php echo $latestVersion; ?>:</h3>
                <ul>
                    <li>بهبود عملکرد شناسایی آهنگ</li>
                    <li>اضافه شدن پشتیبانی از API های جدید</li>
                    <li>رفع باگ‌های گزارش شده</li>
                    <li>بهبود امنیت سیستم</li>
                    <li>بهینه‌سازی استفاده از حافظه</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="?password=<?php echo $adminPassword; ?>&action=update" class="btn btn-primary">🔄 به‌روزرسانی کن</a>
                <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">❌ لغو</a>
            </div>
            
        <?php else: ?>
            <div class="no-update">
                <h3>✅ ربات به‌روز است!</h3>
                <p>ربات شما در آخرین نسخه قرار دارد و نیازی به به‌روزرسانی نیست.</p>
            </div>
            
            <div style="text-align: center;">
                <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">بازگشت به پنل مدیریت</a>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['action']) && $_GET['action'] === 'update'): ?>
            <div style="background: #fff3cd; color: #856404; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3>⚠️ توجه!</h3>
                <p>به‌روزرسانی خودکار در حال حاضر پشتیبانی نمی‌شود. لطفاً مراحل زیر را دنبال کنید:</p>
                <ol>
                    <li>از دیتابیس پشتیبان تهیه کنید</li>
                    <li>فایل‌های جدید را آپلود کنید</li>
                    <li>تنظیمات را بررسی کنید</li>
                    <li>ربات را تست کنید</li>
                </ol>
            </div>
        <?php endif; ?>
        
        <div class="changelog">
            <h3>📚 راهنمای به‌روزرسانی دستی:</h3>
            <ol>
                <li><strong>پشتیبان‌گیری:</strong> از دیتابیس و فایل‌ها پشتیبان تهیه کنید</li>
                <li><strong>دانلود:</strong> آخرین نسخه را از مخزن دانلود کنید</li>
                <li><strong>آپلود:</strong> فایل‌های جدید را آپلود کنید</li>
                <li><strong>تنظیمات:</strong> فایل config.php را بررسی کنید</li>
                <li><strong>تست:</strong> ربات را تست کنید</li>
            </ol>
        </div>
    </div>
</body>
</html>
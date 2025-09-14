<?php
/**
 * بررسی امنیت سیستم
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

// بررسی امنیت
function checkSecurity() {
    $issues = [];
    $warnings = [];
    $recommendations = [];
    
    // بررسی فایل‌های حساس
    $sensitiveFiles = ['config.php', 'database.php', '.htaccess'];
    foreach ($sensitiveFiles as $file) {
        if (file_exists($file)) {
            if (is_readable($file)) {
                $issues[] = "فایل $file قابل خواندن است";
            }
        } else {
            $warnings[] = "فایل $file یافت نشد";
        }
    }
    
    // بررسی مجوزهای فایل‌ها
    $files = glob('*.php');
    foreach ($files as $file) {
        $perms = fileperms($file);
        if ($perms & 0x0004) { // world readable
            $warnings[] = "فایل $file برای همه قابل خواندن است";
        }
    }
    
    // بررسی تنظیمات PHP
    if (ini_get('display_errors')) {
        $warnings[] = "نمایش خطاها فعال است";
    }
    
    if (ini_get('log_errors') == 0) {
        $issues[] = "ثبت خطاها غیرفعال است";
    }
    
    // بررسی SSL
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
        $issues[] = "SSL فعال نیست";
    }
    
    // بررسی نسخه PHP
    if (version_compare(PHP_VERSION, '7.4.0', '<')) {
        $issues[] = "نسخه PHP قدیمی است: " . PHP_VERSION;
    }
    
    // بررسی extension های امنیتی
    $securityExtensions = ['openssl', 'hash', 'filter'];
    foreach ($securityExtensions as $ext) {
        if (!extension_loaded($ext)) {
            $warnings[] = "Extension $ext نصب نشده است";
        }
    }
    
    // بررسی دیتابیس
    try {
        require_once 'config.php';
        require_once 'database.php';
        $db = new Database();
        $pdo = $db->getConnection();
        
        // بررسی وجود جداول
        $tables = ['processed_videos', 'user_sessions'];
        foreach ($tables as $table) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() == 0) {
                $warnings[] = "جدول $table وجود ندارد";
            }
        }
        
    } catch (Exception $e) {
        $issues[] = "خطا در اتصال به دیتابیس: " . $e->getMessage();
    }
    
    // بررسی فایل‌های موقت
    $tempDir = sys_get_temp_dir();
    $tempFiles = glob($tempDir . '/instagram_*');
    $tempFiles = array_merge($tempFiles, glob($tempDir . '/audio_*'));
    $tempFiles = array_merge($tempFiles, glob($tempDir . '/shazam_*'));
    
    if (count($tempFiles) > 100) {
        $warnings[] = "تعداد زیادی فایل موقت وجود دارد: " . count($tempFiles);
    }
    
    // توصیه‌ها
    $recommendations[] = "از رمزهای عبور قوی استفاده کنید";
    $recommendations[] = "فایل‌های حساس را از دسترسی عمومی محافظت کنید";
    $recommendations[] = "لاگ‌ها را به طور منظم بررسی کنید";
    $recommendations[] = "سیستم را به‌روز نگه دارید";
    $recommendations[] = "از فایروال استفاده کنید";
    $recommendations[] = "پشتیبان‌گیری منظم انجام دهید";
    
    return [
        'issues' => $issues,
        'warnings' => $warnings,
        'recommendations' => $recommendations
    ];
}

$security = checkSecurity();

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بررسی امنیت سیستم</title>
    <style>
        body { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            max-width: 1000px; 
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
        .security-section {
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }
        .security-issues {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .security-warnings {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeaa7;
        }
        .security-recommendations {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }
        .security-good {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .security-section h3 {
            margin-top: 0;
            font-size: 1.2em;
        }
        .security-section ul {
            margin: 10px 0;
            padding-right: 20px;
        }
        .security-section li {
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
            font-size: 14px;
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
        .security-score {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .score-number {
            font-size: 3em;
            font-weight: bold;
            margin: 10px 0;
        }
        .score-good { color: #28a745; }
        .score-warning { color: #ffc107; }
        .score-danger { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔒 بررسی امنیت سیستم</h1>
        
        <?php
        $totalIssues = count($security['issues']) + count($security['warnings']);
        $score = max(0, 100 - ($totalIssues * 10));
        $scoreClass = $score >= 80 ? 'score-good' : ($score >= 60 ? 'score-warning' : 'score-danger');
        ?>
        
        <div class="security-score">
            <h3>امتیاز امنیت</h3>
            <div class="score-number <?php echo $scoreClass; ?>"><?php echo $score; ?></div>
            <p>از 100</p>
        </div>
        
        <?php if (!empty($security['issues'])): ?>
            <div class="security-section security-issues">
                <h3>❌ مشکلات امنیتی</h3>
                <ul>
                    <?php foreach ($security['issues'] as $issue): ?>
                        <li><?php echo htmlspecialchars($issue); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($security['warnings'])): ?>
            <div class="security-section security-warnings">
                <h3>⚠️ هشدارهای امنیتی</h3>
                <ul>
                    <?php foreach ($security['warnings'] as $warning): ?>
                        <li><?php echo htmlspecialchars($warning); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (empty($security['issues']) && empty($security['warnings'])): ?>
            <div class="security-section security-good">
                <h3>✅ سیستم امن است</h3>
                <p>هیچ مشکل امنیتی جدی یافت نشد. سیستم در وضعیت خوبی قرار دارد.</p>
            </div>
        <?php endif; ?>
        
        <div class="security-section security-recommendations">
            <h3>💡 توصیه‌های امنیتی</h3>
            <ul>
                <?php foreach ($security['recommendations'] as $recommendation): ?>
                    <li><?php echo htmlspecialchars($recommendation); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="?password=<?php echo $adminPassword; ?>&action=fix" class="btn btn-primary">🔧 رفع مشکلات</a>
            <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">بازگشت به پنل مدیریت</a>
        </div>
        
        <?php if (isset($_GET['action']) && $_GET['action'] === 'fix'): ?>
            <div class="security-section security-recommendations">
                <h3>🔧 اقدامات اصلاحی</h3>
                <p>برای رفع مشکلات امنیتی، مراحل زیر را دنبال کنید:</p>
                <ol>
                    <li><strong>تنظیم مجوزهای فایل:</strong>
                        <code>chmod 600 config.php</code>
                    </li>
                    <li><strong>غیرفعال کردن نمایش خطاها:</strong>
                        <code>ini_set('display_errors', 0);</code>
                    </li>
                    <li><strong>فعال کردن ثبت خطاها:</strong>
                        <code>ini_set('log_errors', 1);</code>
                    </li>
                    <li><strong>تنظیم .htaccess:</strong>
                        <pre>Options -Indexes
ServerSignature Off
&lt;Files "config.php"&gt;
    Order Allow,Deny
    Deny from all
&lt;/Files&gt;</pre>
                    </li>
                    <li><strong>پاکسازی فایل‌های موقت:</strong>
                        <a href="cron.php" class="btn btn-primary">اجرای پاکسازی</a>
                    </li>
                </ol>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
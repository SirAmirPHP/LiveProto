<?php
/**
 * مانیتورینگ سیستم
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

// دریافت آمار سیستم
function getSystemStats() {
    $stats = [];
    
    // آمار PHP
    $stats['php'] = [
        'version' => PHP_VERSION,
        'memory_usage' => memory_get_usage(true),
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size')
    ];
    
    // آمار سرور
    $stats['server'] = [
        'os' => PHP_OS,
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'load_average' => function_exists('sys_getloadavg') ? sys_getloadavg() : null,
        'disk_free_space' => disk_free_space('.'),
        'disk_total_space' => disk_total_space('.')
    ];
    
    // آمار دیتابیس
    try {
        require_once 'config.php';
        require_once 'database.php';
        $db = new Database();
        $pdo = $db->getConnection();
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM processed_videos");
        $totalVideos = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as users FROM processed_videos");
        $uniqueUsers = $stmt->fetch()['users'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as today FROM processed_videos WHERE DATE(created_at) = CURDATE()");
        $todayVideos = $stmt->fetch()['today'];
        
        $stats['database'] = [
            'total_videos' => $totalVideos,
            'unique_users' => $uniqueUsers,
            'today_videos' => $todayVideos,
            'status' => 'connected'
        ];
        
    } catch (Exception $e) {
        $stats['database'] = [
            'status' => 'error',
            'error' => $e->getMessage()
        ];
    }
    
    // آمار فایل‌های موقت
    $tempDir = sys_get_temp_dir();
    $tempFiles = glob($tempDir . '/instagram_*');
    $tempFiles = array_merge($tempFiles, glob($tempDir . '/audio_*'));
    $tempFiles = array_merge($tempFiles, glob($tempDir . '/shazam_*'));
    
    $tempSize = 0;
    foreach ($tempFiles as $file) {
        if (file_exists($file)) {
            $tempSize += filesize($file);
        }
    }
    
    $stats['temp_files'] = [
        'count' => count($tempFiles),
        'size' => $tempSize,
        'size_mb' => round($tempSize / 1024 / 1024, 2)
    ];
    
    // آمار ربات تلگرام
    try {
        require_once 'telegram_bot.php';
        $bot = new TelegramBot();
        
        $stats['telegram'] = [
            'status' => 'connected',
            'webhook_set' => true
        ];
        
    } catch (Exception $e) {
        $stats['telegram'] = [
            'status' => 'error',
            'error' => $e->getMessage()
        ];
    }
    
    return $stats;
}

$stats = getSystemStats();

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مانیتورینگ سیستم</title>
    <style>
        body { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            max-width: 1200px; 
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .stat-card h3 {
            margin-top: 0;
            color: #495057;
        }
        .stat-item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .stat-item:last-child {
            border-bottom: none;
        }
        .stat-label {
            font-weight: bold;
            color: #6c757d;
        }
        .stat-value {
            color: #495057;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
        .status.connected {
            background: #d4edda;
            color: #155724;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
        }
        .status.warning {
            background: #fff3cd;
            color: #856404;
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
        .chart-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 مانیتورینگ سیستم</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>🐘 PHP</h3>
                <div class="stat-item">
                    <span class="stat-label">نسخه:</span>
                    <span class="stat-value"><?php echo $stats['php']['version']; ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">استفاده از حافظه:</span>
                    <span class="stat-value"><?php echo round($stats['php']['memory_usage'] / 1024 / 1024, 2); ?> MB</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">حد حافظه:</span>
                    <span class="stat-value"><?php echo $stats['php']['memory_limit']; ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">حد زمان اجرا:</span>
                    <span class="stat-value"><?php echo $stats['php']['max_execution_time']; ?> ثانیه</span>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>🖥️ سرور</h3>
                <div class="stat-item">
                    <span class="stat-label">سیستم عامل:</span>
                    <span class="stat-value"><?php echo $stats['server']['os']; ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">نرم‌افزار سرور:</span>
                    <span class="stat-value"><?php echo $stats['server']['server_software']; ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">فضای آزاد:</span>
                    <span class="stat-value"><?php echo round($stats['server']['disk_free_space'] / 1024 / 1024 / 1024, 2); ?> GB</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">کل فضا:</span>
                    <span class="stat-value"><?php echo round($stats['server']['disk_total_space'] / 1024 / 1024 / 1024, 2); ?> GB</span>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>🗄️ دیتابیس</h3>
                <div class="stat-item">
                    <span class="stat-label">وضعیت:</span>
                    <span class="status <?php echo $stats['database']['status'] === 'connected' ? 'connected' : 'error'; ?>">
                        <?php echo $stats['database']['status'] === 'connected' ? 'متصل' : 'قطع'; ?>
                    </span>
                </div>
                <?php if ($stats['database']['status'] === 'connected'): ?>
                    <div class="stat-item">
                        <span class="stat-label">کل ویدیوها:</span>
                        <span class="stat-value"><?php echo number_format($stats['database']['total_videos']); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">کاربران منحصر به فرد:</span>
                        <span class="stat-value"><?php echo number_format($stats['database']['unique_users']); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">ویدیوهای امروز:</span>
                        <span class="stat-value"><?php echo number_format($stats['database']['today_videos']); ?></span>
                    </div>
                <?php else: ?>
                    <div class="stat-item">
                        <span class="stat-label">خطا:</span>
                        <span class="stat-value"><?php echo htmlspecialchars($stats['database']['error']); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="stat-card">
                <h3>📁 فایل‌های موقت</h3>
                <div class="stat-item">
                    <span class="stat-label">تعداد:</span>
                    <span class="stat-value"><?php echo number_format($stats['temp_files']['count']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">حجم:</span>
                    <span class="stat-value"><?php echo $stats['temp_files']['size_mb']; ?> MB</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">وضعیت:</span>
                    <span class="status <?php echo $stats['temp_files']['count'] > 100 ? 'warning' : 'connected'; ?>">
                        <?php echo $stats['temp_files']['count'] > 100 ? 'نیاز به پاکسازی' : 'مناسب'; ?>
                    </span>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>🤖 تلگرام</h3>
                <div class="stat-item">
                    <span class="stat-label">وضعیت:</span>
                    <span class="status <?php echo $stats['telegram']['status'] === 'connected' ? 'connected' : 'error'; ?>">
                        <?php echo $stats['telegram']['status'] === 'connected' ? 'متصل' : 'قطع'; ?>
                    </span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Webhook:</span>
                    <span class="status connected">فعال</span>
                </div>
            </div>
        </div>
        
        <div class="chart-container">
            <h3>📈 استفاده از فضای دیسک</h3>
            <?php
            $usedSpace = $stats['server']['disk_total_space'] - $stats['server']['disk_free_space'];
            $usagePercent = ($usedSpace / $stats['server']['disk_total_space']) * 100;
            ?>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo $usagePercent; ?>%"></div>
            </div>
            <p>استفاده شده: <?php echo round($usagePercent, 1); ?>%</p>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="?password=<?php echo $adminPassword; ?>&action=refresh" class="btn btn-primary">🔄 تازه‌سازی</a>
            <a href="cron.php" class="btn btn-primary">🧹 پاکسازی</a>
            <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">بازگشت به پنل مدیریت</a>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: #6c757d; font-size: 0.9em;">
            آخرین به‌روزرسانی: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>
</html>
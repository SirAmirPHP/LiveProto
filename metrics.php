<?php
/**
 * متریک‌های سیستم
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

require_once 'database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // آمار کلی
    $stats = [];
    
    // تعداد کل ویدیوهای پردازش شده
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM processed_videos");
    $stats['total_videos'] = $stmt->fetch()['total'];
    
    // تعداد کاربران منحصر به فرد
    $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as users FROM processed_videos");
    $stats['unique_users'] = $stmt->fetch()['users'];
    
    // آمار روزانه (30 روز گذشته)
    $stmt = $pdo->query("
        SELECT DATE(created_at) as date, COUNT(*) as count 
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) 
        GROUP BY DATE(created_at) 
        ORDER BY date DESC
    ");
    $stats['daily'] = $stmt->fetchAll();
    
    // آمار ساعتی (24 ساعت گذشته)
    $stmt = $pdo->query("
        SELECT HOUR(created_at) as hour, COUNT(*) as count 
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR) 
        GROUP BY HOUR(created_at) 
        ORDER BY hour
    ");
    $stats['hourly'] = $stmt->fetchAll();
    
    // محبوب‌ترین آهنگ‌ها
    $stmt = $pdo->query("
        SELECT music_title, artist_name, COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NOT NULL 
        GROUP BY music_title, artist_name 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stats['popular_songs'] = $stmt->fetchAll();
    
    // آمار کاربران فعال
    $stmt = $pdo->query("
        SELECT user_id, COUNT(*) as count 
        FROM processed_videos 
        GROUP BY user_id 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stats['active_users'] = $stmt->fetchAll();
    
    // آمار دقت شناسایی
    $stmt = $pdo->query("
        SELECT 
            AVG(confidence) as avg_confidence,
            MIN(confidence) as min_confidence,
            MAX(confidence) as max_confidence,
            COUNT(*) as total_with_confidence
        FROM processed_videos 
        WHERE confidence IS NOT NULL
    ");
    $confidenceStats = $stmt->fetch();
    $stats['confidence'] = $confidenceStats;
    
    // آمار ماهانه
    $stmt = $pdo->query("
        SELECT 
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as count 
        FROM processed_videos 
        GROUP BY YEAR(created_at), MONTH(created_at) 
        ORDER BY year DESC, month DESC
    ");
    $stats['monthly'] = $stmt->fetchAll();
    
    // آمار هفتگی
    $stmt = $pdo->query("
        SELECT 
            YEAR(created_at) as year,
            WEEK(created_at) as week,
            COUNT(*) as count 
        FROM processed_videos 
        GROUP BY YEAR(created_at), WEEK(created_at) 
        ORDER BY year DESC, week DESC
    ");
    $stats['weekly'] = $stmt->fetchAll();
    
    // آمار هنرمندان
    $stmt = $pdo->query("
        SELECT artist_name, COUNT(*) as count 
        FROM processed_videos 
        WHERE artist_name IS NOT NULL 
        GROUP BY artist_name 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stats['artists'] = $stmt->fetchAll();
    
    // آمار آلبوم‌ها
    $stmt = $pdo->query("
        SELECT 
            SUBSTRING_INDEX(music_title, ' - ', 1) as album,
            COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NOT NULL 
        GROUP BY album 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stats['albums'] = $stmt->fetchAll();
    
    // آمار خطاها
    $stmt = $pdo->query("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NULL 
        GROUP BY DATE(created_at) 
        ORDER BY date DESC
    ");
    $stats['errors'] = $stmt->fetchAll();
    
    // آمار موفقیت
    $stmt = $pdo->query("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NOT NULL 
        GROUP BY DATE(created_at) 
        ORDER BY date DESC
    ");
    $stats['success'] = $stmt->fetchAll();
    
    // محاسبه نرخ موفقیت
    $totalVideos = $stats['total_videos'];
    $successfulVideos = $pdo->query("SELECT COUNT(*) as count FROM processed_videos WHERE music_title IS NOT NULL")->fetch()['count'];
    $stats['success_rate'] = $totalVideos > 0 ? round(($successfulVideos / $totalVideos) * 100, 2) : 0;
    
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
        'size_mb' => round($tempSize / 1024 / 1024, 2)
    ];
    
    // آمار سیستم
    $stats['system'] = [
        'php_version' => PHP_VERSION,
        'memory_usage' => memory_get_usage(true),
        'memory_limit' => ini_get('memory_limit'),
        'disk_free' => disk_free_space('.'),
        'disk_total' => disk_total_space('.'),
        'load_average' => function_exists('sys_getloadavg') ? sys_getloadavg() : null
    ];
    
    // تنظیم header
    header('Content-Type: application/json; charset=utf-8');
    
    // خروجی JSON
    echo json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
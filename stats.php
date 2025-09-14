<?php
/**
 * آمار تفصیلی
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
    
    // دریافت پارامترها
    $period = $_GET['period'] ?? '30'; // 7, 30, 90, 365
    $groupBy = $_GET['group_by'] ?? 'day'; // day, week, month
    
    // تنظیم گروه‌بندی
    $dateFormat = match($groupBy) {
        'day' => '%Y-%m-%d',
        'week' => '%Y-%u',
        'month' => '%Y-%m',
        default => '%Y-%m-%d'
    };
    
    // آمار کلی
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_videos,
            COUNT(DISTINCT user_id) as unique_users,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful_videos,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed_videos,
            AVG(confidence) as avg_confidence,
            MIN(created_at) as first_video,
            MAX(created_at) as last_video
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
    ");
    $stmt->execute([$period]);
    $overview = $stmt->fetch();
    
    // آمار زمانی
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(created_at, ?) as period,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed,
            AVG(confidence) as avg_confidence
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        GROUP BY DATE_FORMAT(created_at, ?)
        ORDER BY period
    ");
    $stmt->execute([$dateFormat, $period, $dateFormat]);
    $timeSeries = $stmt->fetchAll();
    
    // آمار هنرمندان
    $stmt = $pdo->prepare("
        SELECT 
            artist_name,
            COUNT(*) as count,
            AVG(confidence) as avg_confidence,
            MIN(created_at) as first_recognized,
            MAX(created_at) as last_recognized
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) 
        AND artist_name IS NOT NULL
        GROUP BY artist_name 
        ORDER BY count DESC 
        LIMIT 50
    ");
    $stmt->execute([$period]);
    $artists = $stmt->fetchAll();
    
    // آمار آهنگ‌ها
    $stmt = $pdo->prepare("
        SELECT 
            music_title,
            artist_name,
            COUNT(*) as count,
            AVG(confidence) as avg_confidence,
            MIN(created_at) as first_recognized,
            MAX(created_at) as last_recognized
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) 
        AND music_title IS NOT NULL
        GROUP BY music_title, artist_name 
        ORDER BY count DESC 
        LIMIT 50
    ");
    $stmt->execute([$period]);
    $songs = $stmt->fetchAll();
    
    // آمار کاربران
    $stmt = $pdo->prepare("
        SELECT 
            user_id,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed,
            AVG(confidence) as avg_confidence,
            MIN(created_at) as first_video,
            MAX(created_at) as last_video
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        GROUP BY user_id 
        ORDER BY count DESC 
        LIMIT 50
    ");
    $stmt->execute([$period]);
    $users = $stmt->fetchAll();
    
    // آمار ساعتی
    $stmt = $pdo->prepare("
        SELECT 
            HOUR(created_at) as hour,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        GROUP BY HOUR(created_at) 
        ORDER BY hour
    ");
    $stmt->execute([$period]);
    $hourly = $stmt->fetchAll();
    
    // آمار روزهای هفته
    $stmt = $pdo->prepare("
        SELECT 
            DAYOFWEEK(created_at) as day_of_week,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        GROUP BY DAYOFWEEK(created_at) 
        ORDER BY day_of_week
    ");
    $stmt->execute([$period]);
    $weekly = $stmt->fetchAll();
    
    // آمار دقت
    $stmt = $pdo->prepare("
        SELECT 
            CASE 
                WHEN confidence >= 0.9 THEN '90-100%'
                WHEN confidence >= 0.8 THEN '80-89%'
                WHEN confidence >= 0.7 THEN '70-79%'
                WHEN confidence >= 0.6 THEN '60-69%'
                ELSE 'زیر 60%'
            END as confidence_range,
            COUNT(*) as count
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) 
        AND confidence IS NOT NULL
        GROUP BY confidence_range
        ORDER BY confidence
    ");
    $stmt->execute([$period]);
    $confidence = $stmt->fetchAll();
    
    // آمار خطاها
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) 
        AND music_title IS NULL
        GROUP BY DATE(created_at) 
        ORDER BY date
    ");
    $stmt->execute([$period]);
    $errors = $stmt->fetchAll();
    
    // آمار موفقیت
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) 
        AND music_title IS NOT NULL
        GROUP BY DATE(created_at) 
        ORDER BY date
    ");
    $stmt->execute([$period]);
    $success = $stmt->fetchAll();
    
    // محاسبه نرخ موفقیت
    $successRate = $overview['total_videos'] > 0 ? 
        round(($overview['successful_videos'] / $overview['total_videos']) * 100, 2) : 0;
    
    // محاسبه نرخ خطا
    $errorRate = $overview['total_videos'] > 0 ? 
        round(($overview['failed_videos'] / $overview['total_videos']) * 100, 2) : 0;
    
    // آمار مقایسه‌ای
    $prevPeriod = $period * 2;
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_videos,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful_videos,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed_videos
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        AND created_at < DATE_SUB(NOW(), INTERVAL ? DAY)
    ");
    $stmt->execute([$prevPeriod, $period]);
    $prevOverview = $stmt->fetch();
    
    // محاسبه تغییرات
    $changes = [
        'total_videos' => $prevOverview['total_videos'] > 0 ? 
            round((($overview['total_videos'] - $prevOverview['total_videos']) / $prevOverview['total_videos']) * 100, 2) : 0,
        'successful_videos' => $prevOverview['successful_videos'] > 0 ? 
            round((($overview['successful_videos'] - $prevOverview['successful_videos']) / $prevOverview['successful_videos']) * 100, 2) : 0,
        'failed_videos' => $prevOverview['failed_videos'] > 0 ? 
            round((($overview['failed_videos'] - $prevOverview['failed_videos']) / $prevOverview['failed_videos']) * 100, 2) : 0
    ];
    
    // تنظیم header
    header('Content-Type: application/json; charset=utf-8');
    
    // خروجی JSON
    echo json_encode([
        'period' => [
            'days' => $period,
            'group_by' => $groupBy
        ],
        'overview' => [
            'total_videos' => (int)$overview['total_videos'],
            'unique_users' => (int)$overview['unique_users'],
            'successful_videos' => (int)$overview['successful_videos'],
            'failed_videos' => (int)$overview['failed_videos'],
            'success_rate' => $successRate,
            'error_rate' => $errorRate,
            'avg_confidence' => round($overview['avg_confidence'], 2),
            'first_video' => $overview['first_video'],
            'last_video' => $overview['last_video']
        ],
        'changes' => $changes,
        'time_series' => $timeSeries,
        'artists' => $artists,
        'songs' => $songs,
        'users' => $users,
        'hourly' => $hourly,
        'weekly' => $weekly,
        'confidence' => $confidence,
        'errors' => $errors,
        'success' => $success
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
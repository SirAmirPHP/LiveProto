<?php
/**
 * آنالیتیکس و گزارش‌گیری
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
    
    // دریافت پارامترهای فیلتر
    $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
    $endDate = $_GET['end_date'] ?? date('Y-m-d');
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
            AVG(confidence) as avg_confidence
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
    $stmt->execute([$startDate, $endDate]);
    $overview = $stmt->fetch();
    
    // آمار زمانی
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(created_at, ?) as period,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DATE_FORMAT(created_at, ?)
        ORDER BY period
    ");
    $stmt->execute([$dateFormat, $startDate, $endDate, $dateFormat]);
    $timeSeries = $stmt->fetchAll();
    
    // آمار هنرمندان
    $stmt = $pdo->prepare("
        SELECT 
            artist_name,
            COUNT(*) as count,
            AVG(confidence) as avg_confidence
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND artist_name IS NOT NULL
        GROUP BY artist_name 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stmt->execute([$startDate, $endDate]);
    $artists = $stmt->fetchAll();
    
    // آمار آهنگ‌ها
    $stmt = $pdo->prepare("
        SELECT 
            music_title,
            artist_name,
            COUNT(*) as count,
            AVG(confidence) as avg_confidence
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND music_title IS NOT NULL
        GROUP BY music_title, artist_name 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stmt->execute([$startDate, $endDate]);
    $songs = $stmt->fetchAll();
    
    // آمار کاربران
    $stmt = $pdo->prepare("
        SELECT 
            user_id,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed,
            AVG(confidence) as avg_confidence
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY user_id 
        ORDER BY count DESC 
        LIMIT 20
    ");
    $stmt->execute([$startDate, $endDate]);
    $users = $stmt->fetchAll();
    
    // آمار ساعتی
    $stmt = $pdo->prepare("
        SELECT 
            HOUR(created_at) as hour,
            COUNT(*) as count
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY HOUR(created_at) 
        ORDER BY hour
    ");
    $stmt->execute([$startDate, $endDate]);
    $hourly = $stmt->fetchAll();
    
    // آمار روزهای هفته
    $stmt = $pdo->prepare("
        SELECT 
            DAYOFWEEK(created_at) as day_of_week,
            COUNT(*) as count
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DAYOFWEEK(created_at) 
        ORDER BY day_of_week
    ");
    $stmt->execute([$startDate, $endDate]);
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
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND confidence IS NOT NULL
        GROUP BY confidence_range
        ORDER BY confidence
    ");
    $stmt->execute([$startDate, $endDate]);
    $confidence = $stmt->fetchAll();
    
    // آمار خطاها
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND music_title IS NULL
        GROUP BY DATE(created_at) 
        ORDER BY date
    ");
    $stmt->execute([$startDate, $endDate]);
    $errors = $stmt->fetchAll();
    
    // آمار موفقیت
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as count
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND music_title IS NOT NULL
        GROUP BY DATE(created_at) 
        ORDER BY date
    ");
    $stmt->execute([$startDate, $endDate]);
    $success = $stmt->fetchAll();
    
    // محاسبه نرخ موفقیت
    $successRate = $overview['total_videos'] > 0 ? 
        round(($overview['successful_videos'] / $overview['total_videos']) * 100, 2) : 0;
    
    // محاسبه نرخ خطا
    $errorRate = $overview['total_videos'] > 0 ? 
        round(($overview['failed_videos'] / $overview['total_videos']) * 100, 2) : 0;
    
    // تنظیم header
    header('Content-Type: application/json; charset=utf-8');
    
    // خروجی JSON
    echo json_encode([
        'period' => [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'group_by' => $groupBy
        ],
        'overview' => [
            'total_videos' => (int)$overview['total_videos'],
            'unique_users' => (int)$overview['unique_users'],
            'successful_videos' => (int)$overview['successful_videos'],
            'failed_videos' => (int)$overview['failed_videos'],
            'success_rate' => $successRate,
            'error_rate' => $errorRate,
            'avg_confidence' => round($overview['avg_confidence'], 2)
        ],
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
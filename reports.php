<?php
/**
 * گزارش‌های تفصیلی
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
    $reportType = $_GET['type'] ?? 'overview'; // overview, users, songs, artists, errors, performance
    $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
    $endDate = $_GET['end_date'] ?? date('Y-m-d');
    $format = $_GET['format'] ?? 'html'; // html, json, csv, pdf
    
    // تنظیم گروه‌بندی
    $groupBy = $_GET['group_by'] ?? 'day'; // day, week, month
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
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
    $stmt->execute([$startDate, $endDate]);
    $overview = $stmt->fetch();
    
    // محاسبه نرخ موفقیت
    $successRate = $overview['total_videos'] > 0 ? 
        round(($overview['successful_videos'] / $overview['total_videos']) * 100, 2) : 0;
    
    // محاسبه نرخ خطا
    $errorRate = $overview['total_videos'] > 0 ? 
        round(($overview['failed_videos'] / $overview['total_videos']) * 100, 2) : 0;
    
    // آمار زمانی
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(created_at, ?) as period,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed,
            AVG(confidence) as avg_confidence
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
            AVG(confidence) as avg_confidence,
            MIN(created_at) as first_recognized,
            MAX(created_at) as last_recognized
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND artist_name IS NOT NULL
        GROUP BY artist_name 
        ORDER BY count DESC 
        LIMIT 100
    ");
    $stmt->execute([$startDate, $endDate]);
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
        WHERE DATE(created_at) BETWEEN ? AND ? 
        AND music_title IS NOT NULL
        GROUP BY music_title, artist_name 
        ORDER BY count DESC 
        LIMIT 100
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
            AVG(confidence) as avg_confidence,
            MIN(created_at) as first_video,
            MAX(created_at) as last_video
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY user_id 
        ORDER BY count DESC 
        LIMIT 100
    ");
    $stmt->execute([$startDate, $endDate]);
    $users = $stmt->fetchAll();
    
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
    
    // آمار ساعتی
    $stmt = $pdo->prepare("
        SELECT 
            HOUR(created_at) as hour,
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed
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
            COUNT(*) as count,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DAYOFWEEK(created_at) 
        ORDER BY day_of_week
    ");
    $stmt->execute([$startDate, $endDate]);
    $weekly = $stmt->fetchAll();
    
    // آمار مقایسه‌ای
    $prevStartDate = date('Y-m-d', strtotime($startDate . ' -' . (strtotime($endDate) - strtotime($startDate)) . ' days'));
    $prevEndDate = $startDate;
    
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_videos,
            COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful_videos,
            COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed_videos
        FROM processed_videos 
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
    $stmt->execute([$prevStartDate, $prevEndDate]);
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
    if ($format === 'json') {
        header('Content-Type: application/json; charset=utf-8');
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
    } elseif ($format === 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=report_{$reportType}_{$startDate}_to_{$endDate}.csv");
        
        $output = fopen('php://output', 'w');
        
        // BOM برای UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // هدرها
        fputcsv($output, ['Period', 'Total Videos', 'Unique Users', 'Successful Videos', 'Failed Videos', 'Success Rate', 'Error Rate', 'Avg Confidence']);
        
        // داده‌ها
        foreach ($timeSeries as $row) {
            fputcsv($output, [
                $row['period'],
                $row['count'],
                'N/A', // در گزارش زمانی، کاربران منحصر به فرد محاسبه نمی‌شود
                $row['successful'],
                $row['failed'],
                $row['count'] > 0 ? round(($row['successful'] / $row['count']) * 100, 2) : 0,
                $row['count'] > 0 ? round(($row['failed'] / $row['count']) * 100, 2) : 0,
                round($row['avg_confidence'], 2)
            ]);
        }
        
        fclose($output);
    } else {
        // HTML report
        header('Content-Type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>گزارش تفصیلی - ربات شناسایی آهنگ</title>
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
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                .table th, .table td {
                    padding: 12px;
                    text-align: right;
                    border-bottom: 1px solid #ddd;
                }
                .table th {
                    background: #f8f9fa;
                    font-weight: bold;
                }
                .table tr:hover {
                    background: #f5f5f5;
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
                .chart-container h3 {
                    margin-top: 0;
                    color: #495057;
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
                <h1>📊 گزارش تفصیلی - ربات شناسایی آهنگ</h1>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>📈 آمار کلی</h3>
                        <div class="stat-item">
                            <span class="stat-label">کل ویدیوها:</span>
                            <span class="stat-value"><?php echo number_format($overview['total_videos']); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">کاربران منحصر به فرد:</span>
                            <span class="stat-value"><?php echo number_format($overview['unique_users']); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">ویدیوهای موفق:</span>
                            <span class="stat-value"><?php echo number_format($overview['successful_videos']); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">ویدیوهای ناموفق:</span>
                            <span class="stat-value"><?php echo number_format($overview['failed_videos']); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">نرخ موفقیت:</span>
                            <span class="stat-value"><?php echo $successRate; ?>%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">نرخ خطا:</span>
                            <span class="stat-value"><?php echo $errorRate; ?>%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">میانگین دقت:</span>
                            <span class="stat-value"><?php echo round($overview['avg_confidence'], 2); ?></span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <h3>📅 دوره گزارش</h3>
                        <div class="stat-item">
                            <span class="stat-label">تاریخ شروع:</span>
                            <span class="stat-value"><?php echo $startDate; ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">تاریخ پایان:</span>
                            <span class="stat-value"><?php echo $endDate; ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">گروه‌بندی:</span>
                            <span class="stat-value"><?php echo $groupBy; ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">اولین ویدیو:</span>
                            <span class="stat-value"><?php echo $overview['first_video']; ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">آخرین ویدیو:</span>
                            <span class="stat-value"><?php echo $overview['last_video']; ?></span>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <h3>📊 تغییرات</h3>
                        <div class="stat-item">
                            <span class="stat-label">کل ویدیوها:</span>
                            <span class="stat-value"><?php echo $changes['total_videos']; ?>%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">ویدیوهای موفق:</span>
                            <span class="stat-value"><?php echo $changes['successful_videos']; ?>%</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">ویدیوهای ناموفق:</span>
                            <span class="stat-value"><?php echo $changes['failed_videos']; ?>%</span>
                        </div>
                    </div>
                </div>
                
                <div class="chart-container">
                    <h3>📈 نرخ موفقیت</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $successRate; ?>%"></div>
                    </div>
                    <p><?php echo $successRate; ?>% موفقیت</p>
                </div>
                
                <h2>🎵 محبوب‌ترین آهنگ‌ها</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>نام آهنگ</th>
                            <th>هنرمند</th>
                            <th>تعداد</th>
                            <th>میانگین دقت</th>
                            <th>اولین شناسایی</th>
                            <th>آخرین شناسایی</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($songs, 0, 20) as $song): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($song['music_title']); ?></td>
                                <td><?php echo htmlspecialchars($song['artist_name']); ?></td>
                                <td><?php echo number_format($song['count']); ?></td>
                                <td><?php echo round($song['avg_confidence'], 2); ?></td>
                                <td><?php echo $song['first_recognized']; ?></td>
                                <td><?php echo $song['last_recognized']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <h2>🎤 محبوب‌ترین هنرمندان</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>نام هنرمند</th>
                            <th>تعداد</th>
                            <th>میانگین دقت</th>
                            <th>اولین شناسایی</th>
                            <th>آخرین شناسایی</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($artists, 0, 20) as $artist): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($artist['artist_name']); ?></td>
                                <td><?php echo number_format($artist['count']); ?></td>
                                <td><?php echo round($artist['avg_confidence'], 2); ?></td>
                                <td><?php echo $artist['first_recognized']; ?></td>
                                <td><?php echo $artist['last_recognized']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <h2>👥 کاربران فعال</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>شناسه کاربر</th>
                            <th>تعداد ویدیو</th>
                            <th>موفق</th>
                            <th>ناموفق</th>
                            <th>میانگین دقت</th>
                            <th>اولین ویدیو</th>
                            <th>آخرین ویدیو</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($users, 0, 20) as $user): ?>
                            <tr>
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo number_format($user['count']); ?></td>
                                <td><?php echo number_format($user['successful']); ?></td>
                                <td><?php echo number_format($user['failed']); ?></td>
                                <td><?php echo round($user['avg_confidence'], 2); ?></td>
                                <td><?php echo $user['first_video']; ?></td>
                                <td><?php echo $user['last_video']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="?password=<?php echo $adminPassword; ?>&type=<?php echo $reportType; ?>&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>&format=json" class="btn btn-primary">📄 JSON</a>
                    <a href="?password=<?php echo $adminPassword; ?>&type=<?php echo $reportType; ?>&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>&format=csv" class="btn btn-primary">📊 CSV</a>
                    <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">بازگشت به پنل مدیریت</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
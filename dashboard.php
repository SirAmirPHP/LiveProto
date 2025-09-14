<?php
/**
 * داشبورد اصلی
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
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM processed_videos");
    $totalVideos = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as users FROM processed_videos");
    $uniqueUsers = $stmt->fetch()['users'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as today FROM processed_videos WHERE DATE(created_at) = CURDATE()");
    $todayVideos = $stmt->fetch()['today'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as successful FROM processed_videos WHERE music_title IS NOT NULL");
    $successfulVideos = $stmt->fetch()['successful'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as failed FROM processed_videos WHERE music_title IS NULL");
    $failedVideos = $stmt->fetch()['failed'];
    
    // محاسبه نرخ موفقیت
    $successRate = $totalVideos > 0 ? round(($successfulVideos / $totalVideos) * 100, 2) : 0;
    
    // آمار روزانه (7 روز گذشته)
    $stmt = $pdo->query("
        SELECT DATE(created_at) as date, COUNT(*) as count 
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
        GROUP BY DATE(created_at) 
        ORDER BY date DESC
    ");
    $dailyStats = $stmt->fetchAll();
    
    // محبوب‌ترین آهنگ‌ها
    $stmt = $pdo->query("
        SELECT music_title, artist_name, COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NOT NULL 
        GROUP BY music_title, artist_name 
        ORDER BY count DESC 
        LIMIT 10
    ");
    $popularSongs = $stmt->fetchAll();
    
    // کاربران فعال
    $stmt = $pdo->query("
        SELECT user_id, COUNT(*) as count 
        FROM processed_videos 
        GROUP BY user_id 
        ORDER BY count DESC 
        LIMIT 10
    ");
    $activeUsers = $stmt->fetchAll();
    
    // آمار ساعتی
    $stmt = $pdo->query("
        SELECT HOUR(created_at) as hour, COUNT(*) as count 
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR) 
        GROUP BY HOUR(created_at) 
        ORDER BY hour
    ");
    $hourlyStats = $stmt->fetchAll();
    
    // آمار دقت
    $stmt = $pdo->query("
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
        WHERE confidence IS NOT NULL
        GROUP BY confidence_range
        ORDER BY confidence
    ");
    $confidenceStats = $stmt->fetchAll();
    
    // آمار خطاها
    $stmt = $pdo->query("
        SELECT DATE(created_at) as date, COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NULL 
        AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY DATE(created_at) 
        ORDER BY date DESC
    ");
    $errorStats = $stmt->fetchAll();
    
    // آمار موفقیت
    $stmt = $pdo->query("
        SELECT DATE(created_at) as date, COUNT(*) as count 
        FROM processed_videos 
        WHERE music_title IS NOT NULL 
        AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        GROUP BY DATE(created_at) 
        ORDER BY date DESC
    ");
    $successStats = $stmt->fetchAll();
    
    // آمار مقایسه‌ای
    $stmt = $pdo->query("
        SELECT COUNT(*) as count 
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ");
    $lastWeekVideos = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("
        SELECT COUNT(*) as count 
        FROM processed_videos 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY)
        AND created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)
    ");
    $weekBeforeVideos = $stmt->fetch()['count'];
    
    $growthRate = $weekBeforeVideos > 0 ? 
        round((($lastWeekVideos - $weekBeforeVideos) / $weekBeforeVideos) * 100, 2) : 0;
    
} catch (Exception $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد - ربات شناسایی آهنگ</title>
    <style>
        body { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            max-width: 1400px; 
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
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin-top: 0;
            font-size: 1.1em;
            opacity: 0.9;
        }
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-label {
            font-size: 1em;
            opacity: 0.8;
        }
        .chart-container {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            border: 1px solid #dee2e6;
        }
        .chart-container h3 {
            margin-top: 0;
            color: #495057;
            text-align: center;
        }
        .chart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin: 25px 0;
        }
        .chart {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .chart h4 {
            margin-top: 0;
            color: #333;
            text-align: center;
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
            color: #495057;
        }
        .table tr:hover {
            background: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        .progress-bar {
            width: 100%;
            height: 25px;
            background: #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            margin: 15px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #c3e6cb;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #bee5eb;
        }
        .nav-tabs {
            display: flex;
            border-bottom: 2px solid #dee2e6;
            margin: 20px 0;
        }
        .nav-tab {
            padding: 12px 20px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .nav-tab.active {
            background: white;
            border-bottom: 2px solid #007bff;
        }
        .nav-tab:hover {
            background: #e9ecef;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .metric-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 10px 0;
        }
        .metric-card h4 {
            margin-top: 0;
            color: #333;
        }
        .metric-value {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }
        .metric-label {
            color: #6c757d;
            font-size: 0.9em;
        }
        .trend {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .trend.up {
            background: #d4edda;
            color: #155724;
        }
        .trend.down {
            background: #f8d7da;
            color: #721c24;
        }
        .trend.neutral {
            background: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 داشبورد - ربات شناسایی آهنگ</h1>
        
        <?php if (isset($error)): ?>
            <div class="error">
                <strong>خطا:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php else: ?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>📹 کل ویدیوها</h3>
                    <div class="stat-number"><?php echo number_format($totalVideos); ?></div>
                    <div class="stat-label">ویدیو پردازش شده</div>
                </div>
                
                <div class="stat-card">
                    <h3>👥 کاربران منحصر به فرد</h3>
                    <div class="stat-number"><?php echo number_format($uniqueUsers); ?></div>
                    <div class="stat-label">کاربر فعال</div>
                </div>
                
                <div class="stat-card">
                    <h3>📅 ویدیوهای امروز</h3>
                    <div class="stat-number"><?php echo number_format($todayVideos); ?></div>
                    <div class="stat-label">ویدیو امروز</div>
                </div>
                
                <div class="stat-card">
                    <h3>✅ ویدیوهای موفق</h3>
                    <div class="stat-number"><?php echo number_format($successfulVideos); ?></div>
                    <div class="stat-label">شناسایی موفق</div>
                </div>
                
                <div class="stat-card">
                    <h3>❌ ویدیوهای ناموفق</h3>
                    <div class="stat-number"><?php echo number_format($failedVideos); ?></div>
                    <div class="stat-label">شناسایی ناموفق</div>
                </div>
                
                <div class="stat-card">
                    <h3>🎯 نرخ موفقیت</h3>
                    <div class="stat-number"><?php echo $successRate; ?>%</div>
                    <div class="stat-label">درصد موفقیت</div>
                </div>
            </div>
            
            <div class="chart-container">
                <h3>📈 نرخ موفقیت</h3>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $successRate; ?>%">
                        <?php echo $successRate; ?>%
                    </div>
                </div>
            </div>
            
            <div class="chart-grid">
                <div class="chart">
                    <h4>📅 آمار روزانه (7 روز گذشته)</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>تاریخ</th>
                                <th>تعداد ویدیو</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dailyStats as $day): ?>
                                <tr>
                                    <td><?php echo $day['date']; ?></td>
                                    <td><?php echo number_format($day['count']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="chart">
                    <h4>🎵 محبوب‌ترین آهنگ‌ها</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>نام آهنگ</th>
                                <th>هنرمند</th>
                                <th>تعداد</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($popularSongs as $song): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($song['music_title']); ?></td>
                                    <td><?php echo htmlspecialchars($song['artist_name']); ?></td>
                                    <td><?php echo number_format($song['count']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="chart">
                    <h4>👥 کاربران فعال</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>شناسه کاربر</th>
                                <th>تعداد ویدیو</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activeUsers as $user): ?>
                                <tr>
                                    <td><?php echo $user['user_id']; ?></td>
                                    <td><?php echo number_format($user['count']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="chart">
                    <h4>⏰ آمار ساعتی (24 ساعت گذشته)</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ساعت</th>
                                <th>تعداد ویدیو</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hourlyStats as $hour): ?>
                                <tr>
                                    <td><?php echo $hour['hour']; ?>:00</td>
                                    <td><?php echo number_format($hour['count']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="chart-container">
                <h3>📊 آمار دقت شناسایی</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>بازه دقت</th>
                            <th>تعداد</th>
                            <th>درصد</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($confidenceStats as $conf): ?>
                            <tr>
                                <td><?php echo $conf['confidence_range']; ?></td>
                                <td><?php echo number_format($conf['count']); ?></td>
                                <td><?php echo round(($conf['count'] / $successfulVideos) * 100, 2); ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="chart-container">
                <h3>📈 رشد هفتگی</h3>
                <div class="metric-card">
                    <h4>تغییرات نسبت به هفته قبل</h4>
                    <div class="metric-value">
                        <?php echo $growthRate; ?>%
                        <span class="trend <?php echo $growthRate > 0 ? 'up' : ($growthRate < 0 ? 'down' : 'neutral'); ?>">
                            <?php echo $growthRate > 0 ? '📈' : ($growthRate < 0 ? '📉' : '➡️'); ?>
                        </span>
                    </div>
                    <div class="metric-label">
                        <?php echo $lastWeekVideos; ?> ویدیو این هفته vs <?php echo $weekBeforeVideos; ?> ویدیو هفته قبل
                    </div>
                </div>
            </div>
            
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-primary">📊 پنل مدیریت</a>
            <a href="reports.php?password=<?php echo $adminPassword; ?>" class="btn btn-success">📋 گزارش‌ها</a>
            <a href="analytics.php?password=<?php echo $adminPassword; ?>" class="btn btn-warning">📈 آنالیتیکس</a>
            <a href="monitor.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">🔍 مانیتورینگ</a>
            <a href="security.php?password=<?php echo $adminPassword; ?>" class="btn btn-danger">🔒 امنیت</a>
        </div>
    </div>
</body>
</html>
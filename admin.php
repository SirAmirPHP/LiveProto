<?php
/**
 * پنل مدیریت ربات
 */

require_once 'database.php';

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // دریافت آمار
    $stats = [];
    
    // تعداد کل ویدیوهای پردازش شده
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM processed_videos");
    $stats['total_videos'] = $stmt->fetch()['total'];
    
    // تعداد کاربران منحصر به فرد
    $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as users FROM processed_videos");
    $stats['unique_users'] = $stmt->fetch()['users'];
    
    // آمار روزانه
    $stmt = $pdo->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM processed_videos WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY DATE(created_at) ORDER BY date DESC");
    $stats['daily'] = $stmt->fetchAll();
    
    // محبوب‌ترین آهنگ‌ها
    $stmt = $pdo->query("SELECT music_title, artist_name, COUNT(*) as count FROM processed_videos WHERE music_title IS NOT NULL GROUP BY music_title, artist_name ORDER BY count DESC LIMIT 10");
    $stats['popular_songs'] = $stmt->fetchAll();
    
    // آمار کاربران فعال
    $stmt = $pdo->query("SELECT user_id, COUNT(*) as count FROM processed_videos GROUP BY user_id ORDER BY count DESC LIMIT 10");
    $stats['active_users'] = $stmt->fetchAll();
    
} catch (Exception $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت ربات</title>
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
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .stat-label {
            font-size: 1.1em;
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
            background: #667eea;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 پنل مدیریت ربات شناسایی آهنگ</h1>
        
        <?php if (isset($error)): ?>
            <div class="error">
                <strong>خطا:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php else: ?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo number_format($stats['total_videos']); ?></div>
                    <div class="stat-label">ویدیوهای پردازش شده</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo number_format($stats['unique_users']); ?></div>
                    <div class="stat-label">کاربران منحصر به فرد</div>
                </div>
            </div>
            
            <h2>📈 آمار روزانه (7 روز گذشته)</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>تاریخ</th>
                        <th>تعداد ویدیو</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['daily'] as $day): ?>
                        <tr>
                            <td><?php echo $day['date']; ?></td>
                            <td><?php echo number_format($day['count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <h2>🎵 محبوب‌ترین آهنگ‌ها</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>نام آهنگ</th>
                        <th>هنرمند</th>
                        <th>تعداد</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['popular_songs'] as $song): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($song['music_title']); ?></td>
                            <td><?php echo htmlspecialchars($song['artist_name']); ?></td>
                            <td><?php echo number_format($song['count']); ?></td>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['active_users'] as $user): ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo number_format($user['count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="setup.php?password=<?php echo $adminPassword; ?>" class="btn">⚙️ تنظیمات</a>
            <a href="test.php?password=<?php echo $adminPassword; ?>" class="btn">🧪 تست</a>
            <a href="cron.php" class="btn">🧹 پاکسازی</a>
        </div>
    </div>
</body>
</html>
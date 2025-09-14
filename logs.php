<?php
/**
 * نمایش لاگ‌های سیستم
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

// تنظیمات
$logFiles = [
    'PHP Errors' => '/var/log/php_errors.log',
    'Apache Error' => '/var/log/apache2/error.log',
    'Apache Access' => '/var/log/apache2/access.log',
    'MySQL Error' => '/var/log/mysql/error.log',
    'Custom Log' => 'bot.log'
];

$lines = (int)($_GET['lines'] ?? 100);
$file = $_GET['file'] ?? 'PHP Errors';

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لاگ‌های سیستم</title>
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
        .controls {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .controls select, .controls input {
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .controls button {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .controls button:hover {
            background: #0056b3;
        }
        .log-content {
            background: #1e1e1e;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            max-height: 600px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .log-line {
            margin: 2px 0;
        }
        .log-error {
            color: #ff6b6b;
        }
        .log-warning {
            color: #ffd93d;
        }
        .log-info {
            color: #6bcf7f;
        }
        .log-debug {
            color: #4dabf7;
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
        .stats {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .stats h3 {
            margin-top: 0;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 لاگ‌های سیستم</h1>
        
        <div class="controls">
            <form method="GET">
                <input type="hidden" name="password" value="<?php echo $adminPassword; ?>">
                
                <label for="file">فایل لاگ:</label>
                <select name="file" id="file">
                    <?php foreach ($logFiles as $name => $path): ?>
                        <option value="<?php echo $name; ?>" <?php echo $file === $name ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <label for="lines">تعداد خطوط:</label>
                <input type="number" name="lines" id="lines" value="<?php echo $lines; ?>" min="10" max="1000">
                
                <button type="submit">🔄 نمایش</button>
            </form>
        </div>
        
        <?php
        $logPath = $logFiles[$file];
        $logContent = '';
        $logStats = [
            'total_lines' => 0,
            'error_count' => 0,
            'warning_count' => 0,
            'info_count' => 0
        ];
        
        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $logLines = explode("\n", $logContent);
            $logStats['total_lines'] = count($logLines);
            
            // نمایش آخرین خطوط
            $lastLines = array_slice($logLines, -$lines);
            $logContent = implode("\n", $lastLines);
            
            // شمارش انواع لاگ
            foreach ($lastLines as $line) {
                if (stripos($line, 'error') !== false || stripos($line, 'fatal') !== false) {
                    $logStats['error_count']++;
                } elseif (stripos($line, 'warning') !== false) {
                    $logStats['warning_count']++;
                } elseif (stripos($line, 'info') !== false) {
                    $logStats['info_count']++;
                }
            }
        } else {
            $logContent = "فایل لاگ یافت نشد: $logPath";
        }
        ?>
        
        <div class="stats">
            <h3>📊 آمار لاگ</h3>
            <p><strong>کل خطوط:</strong> <?php echo number_format($logStats['total_lines']); ?></p>
            <p><strong>خطوط نمایش داده شده:</strong> <?php echo $lines; ?></p>
            <p><strong>خطاها:</strong> <span style="color: #ff6b6b;"><?php echo $logStats['error_count']; ?></span></p>
            <p><strong>هشدارها:</strong> <span style="color: #ffd93d;"><?php echo $logStats['warning_count']; ?></span></p>
            <p><strong>اطلاعات:</strong> <span style="color: #6bcf7f;"><?php echo $logStats['info_count']; ?></span></p>
        </div>
        
        <div class="log-content">
            <?php
            $lines = explode("\n", $logContent);
            foreach ($lines as $line) {
                $class = '';
                if (stripos($line, 'error') !== false || stripos($line, 'fatal') !== false) {
                    $class = 'log-error';
                } elseif (stripos($line, 'warning') !== false) {
                    $class = 'log-warning';
                } elseif (stripos($line, 'info') !== false) {
                    $class = 'log-info';
                } elseif (stripos($line, 'debug') !== false) {
                    $class = 'log-debug';
                }
                
                echo '<div class="log-line ' . $class . '">' . htmlspecialchars($line) . '</div>';
            }
            ?>
        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="?password=<?php echo $adminPassword; ?>&file=<?php echo $file; ?>&lines=<?php echo $lines; ?>" class="btn btn-primary">🔄 تازه‌سازی</a>
            <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">بازگشت به پنل مدیریت</a>
        </div>
    </div>
</body>
</html>
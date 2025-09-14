<?php
/**
 * اطلاعات نسخه و وضعیت سیستم
 */

// اطلاعات نسخه
define('BOT_VERSION', '1.0.0');
define('BOT_BUILD', '2024-01-01');
define('BOT_AUTHOR', 'Music Recognition Bot Team');

// بررسی وضعیت سیستم
function checkSystemStatus() {
    $status = [
        'php_version' => PHP_VERSION,
        'php_extensions' => [],
        'ffmpeg' => false,
        'database' => false,
        'config' => false
    ];
    
    // بررسی extension های PHP
    $requiredExtensions = ['curl', 'json', 'pdo', 'pdo_mysql'];
    foreach ($requiredExtensions as $ext) {
        $status['php_extensions'][$ext] = extension_loaded($ext);
    }
    
    // بررسی FFmpeg
    $ffmpegPath = shell_exec('which ffmpeg');
    $status['ffmpeg'] = !empty($ffmpegPath);
    
    // بررسی دیتابیس
    try {
        require_once 'config.php';
        require_once 'database.php';
        $db = new Database();
        $status['database'] = true;
    } catch (Exception $e) {
        $status['database'] = false;
    }
    
    // بررسی فایل کانفیگ
    $status['config'] = file_exists('config.php') && is_readable('config.php');
    
    return $status;
}

// نمایش اطلاعات نسخه
if (isset($_GET['info'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'version' => BOT_VERSION,
        'build' => BOT_BUILD,
        'author' => BOT_AUTHOR,
        'status' => checkSystemStatus()
    ]);
    exit;
}

// نمایش صفحه اطلاعات
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اطلاعات نسخه - ربات شناسایی آهنگ</title>
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
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
        .status.success {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 اطلاعات نسخه - ربات شناسایی آهنگ</h1>
        
        <?php
        $status = checkSystemStatus();
        ?>
        
        <div class="info-grid">
            <div class="info-card">
                <h3>📦 اطلاعات نسخه</h3>
                <p><strong>نسخه:</strong> <?php echo BOT_VERSION; ?></p>
                <p><strong>تاریخ ساخت:</strong> <?php echo BOT_BUILD; ?></p>
                <p><strong>توسعه‌دهنده:</strong> <?php echo BOT_AUTHOR; ?></p>
            </div>
            
            <div class="info-card">
                <h3>🐘 PHP</h3>
                <p><strong>نسخه:</strong> <?php echo $status['php_version']; ?></p>
                <p><strong>وضعیت:</strong> 
                    <span class="status <?php echo version_compare(PHP_VERSION, '7.4.0', '>=') ? 'success' : 'error'; ?>">
                        <?php echo version_compare(PHP_VERSION, '7.4.0', '>=') ? 'مناسب' : 'نامناسب'; ?>
                    </span>
                </p>
            </div>
            
            <div class="info-card">
                <h3>🔌 Extension ها</h3>
                <?php foreach ($status['php_extensions'] as $ext => $loaded): ?>
                    <p><strong><?php echo $ext; ?>:</strong> 
                        <span class="status <?php echo $loaded ? 'success' : 'error'; ?>">
                            <?php echo $loaded ? 'نصب شده' : 'نصب نشده'; ?>
                        </span>
                    </p>
                <?php endforeach; ?>
            </div>
            
            <div class="info-card">
                <h3>🎬 FFmpeg</h3>
                <p><strong>وضعیت:</strong> 
                    <span class="status <?php echo $status['ffmpeg'] ? 'success' : 'error'; ?>">
                        <?php echo $status['ffmpeg'] ? 'نصب شده' : 'نصب نشده'; ?>
                    </span>
                </p>
            </div>
            
            <div class="info-card">
                <h3>🗄️ دیتابیس</h3>
                <p><strong>وضعیت:</strong> 
                    <span class="status <?php echo $status['database'] ? 'success' : 'error'; ?>">
                        <?php echo $status['database'] ? 'متصل' : 'قطع'; ?>
                    </span>
                </p>
            </div>
            
            <div class="info-card">
                <h3>⚙️ کانفیگ</h3>
                <p><strong>وضعیت:</strong> 
                    <span class="status <?php echo $status['config'] ? 'success' : 'error'; ?>">
                        <?php echo $status['config'] ? 'موجود' : 'مفقود'; ?>
                    </span>
                </p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="?info=1" class="btn">📊 JSON API</a>
            <a href="setup.php" class="btn">⚙️ تنظیمات</a>
            <a href="test.php" class="btn">🧪 تست</a>
            <a href="admin.php" class="btn">📊 مدیریت</a>
        </div>
    </div>
</body>
</html>
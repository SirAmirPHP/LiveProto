<?php
/**
 * بررسی سلامت سیستم
 */

header('Content-Type: application/json; charset=utf-8');

$health = [
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'version' => '1.0.0',
    'checks' => []
];

// بررسی PHP
$health['checks']['php'] = [
    'status' => 'ok',
    'version' => PHP_VERSION,
    'memory_usage' => memory_get_usage(true),
    'memory_limit' => ini_get('memory_limit')
];

// بررسی دیتابیس
try {
    require_once 'config.php';
    require_once 'database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    
    $stmt = $pdo->query("SELECT 1");
    $health['checks']['database'] = [
        'status' => 'ok',
        'message' => 'Database connection successful'
    ];
} catch (Exception $e) {
    $health['checks']['database'] = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    $health['status'] = 'unhealthy';
}

// بررسی FFmpeg
$ffmpegPath = shell_exec('which ffmpeg');
if ($ffmpegPath) {
    $health['checks']['ffmpeg'] = [
        'status' => 'ok',
        'path' => trim($ffmpegPath)
    ];
} else {
    $health['checks']['ffmpeg'] = [
        'status' => 'error',
        'message' => 'FFmpeg not found'
    ];
    $health['status'] = 'unhealthy';
}

// بررسی فایل‌های موقت
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

$health['checks']['temp_files'] = [
    'status' => count($tempFiles) > 100 ? 'warning' : 'ok',
    'count' => count($tempFiles),
    'size_mb' => round($tempSize / 1024 / 1024, 2)
];

// بررسی فضای دیسک
$diskFree = disk_free_space('.');
$diskTotal = disk_total_space('.');
$diskUsage = (($diskTotal - $diskFree) / $diskTotal) * 100;

$health['checks']['disk'] = [
    'status' => $diskUsage > 90 ? 'warning' : 'ok',
    'free_gb' => round($diskFree / 1024 / 1024 / 1024, 2),
    'total_gb' => round($diskTotal / 1024 / 1024 / 1024, 2),
    'usage_percent' => round($diskUsage, 2)
];

// بررسی حافظه
$memoryUsage = (memory_get_usage(true) / (1024 * 1024 * 1024)) * 100;
$memoryLimit = ini_get('memory_limit');
$memoryLimitBytes = $memoryLimit === '-1' ? PHP_INT_MAX : (int)$memoryLimit * 1024 * 1024;

$health['checks']['memory'] = [
    'status' => $memoryUsage > 80 ? 'warning' : 'ok',
    'usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
    'limit' => $memoryLimit,
    'usage_percent' => round($memoryUsage, 2)
];

// بررسی فایل‌های حساس
$sensitiveFiles = ['config.php', 'database.php', '.htaccess'];
$missingFiles = [];
foreach ($sensitiveFiles as $file) {
    if (!file_exists($file)) {
        $missingFiles[] = $file;
    }
}

if (!empty($missingFiles)) {
    $health['checks']['files'] = [
        'status' => 'error',
        'message' => 'Missing files: ' . implode(', ', $missingFiles)
    ];
    $health['status'] = 'unhealthy';
} else {
    $health['checks']['files'] = [
        'status' => 'ok',
        'message' => 'All required files present'
    ];
}

// بررسی API ها
$health['checks']['apis'] = [
    'instagram' => defined('INSTAGRAM_API_KEY') && INSTAGRAM_API_KEY !== 'your_instagram_api_key' ? 'ok' : 'warning',
    'music_recognition' => defined('MUSIC_RECOGNITION_API_KEY') && MUSIC_RECOGNITION_API_KEY !== 'your_music_recognition_api_key' ? 'ok' : 'warning'
];

// بررسی کلی
$errorCount = 0;
$warningCount = 0;

foreach ($health['checks'] as $check) {
    if (is_array($check) && isset($check['status'])) {
        if ($check['status'] === 'error') {
            $errorCount++;
        } elseif ($check['status'] === 'warning') {
            $warningCount++;
        }
    }
}

if ($errorCount > 0) {
    $health['status'] = 'unhealthy';
} elseif ($warningCount > 0) {
    $health['status'] = 'degraded';
}

$health['summary'] = [
    'total_checks' => count($health['checks']),
    'errors' => $errorCount,
    'warnings' => $warningCount,
    'uptime' => 'N/A' // در یک سیستم واقعی، این مقدار از فایل‌های لاگ محاسبه می‌شود
];

// تنظیم HTTP status code
if ($health['status'] === 'unhealthy') {
    http_response_code(503);
} elseif ($health['status'] === 'degraded') {
    http_response_code(200);
} else {
    http_response_code(200);
}

echo json_encode($health, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
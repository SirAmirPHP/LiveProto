<?php
/**
 * API برای دریافت آمار و اطلاعات ربات
 */

require_once 'database.php';

// تنظیم header ها
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// بررسی API Key
$apiKey = 'your_api_key_here'; // تغییر دهید
if (!isset($_GET['api_key']) || $_GET['api_key'] !== $apiKey) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    $action = $_GET['action'] ?? 'stats';
    
    switch ($action) {
        case 'stats':
            // آمار کلی
            $stmt = $pdo->query("SELECT COUNT(*) as total_videos FROM processed_videos");
            $totalVideos = $stmt->fetch()['total_videos'];
            
            $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as unique_users FROM processed_videos");
            $uniqueUsers = $stmt->fetch()['unique_users'];
            
            $stmt = $pdo->query("SELECT COUNT(*) as today_videos FROM processed_videos WHERE DATE(created_at) = CURDATE()");
            $todayVideos = $stmt->fetch()['today_videos'];
            
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'total_videos' => (int)$totalVideos,
                    'unique_users' => (int)$uniqueUsers,
                    'today_videos' => (int)$todayVideos,
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ]);
            break;
            
        case 'popular_songs':
            // محبوب‌ترین آهنگ‌ها
            $limit = (int)($_GET['limit'] ?? 10);
            $stmt = $pdo->prepare("SELECT music_title, artist_name, COUNT(*) as count FROM processed_videos WHERE music_title IS NOT NULL GROUP BY music_title, artist_name ORDER BY count DESC LIMIT ?");
            $stmt->execute([$limit]);
            $songs = $stmt->fetchAll();
            
            echo json_encode([
                'status' => 'success',
                'data' => $songs
            ]);
            break;
            
        case 'user_stats':
            // آمار کاربر خاص
            $userId = $_GET['user_id'] ?? null;
            if (!$userId) {
                throw new Exception("user_id is required");
            }
            
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM processed_videos WHERE user_id = ?");
            $stmt->execute([$userId]);
            $userVideos = $stmt->fetch()['count'];
            
            $stmt = $pdo->prepare("SELECT music_title, artist_name, created_at FROM processed_videos WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
            $stmt->execute([$userId]);
            $userHistory = $stmt->fetchAll();
            
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'user_id' => $userId,
                    'total_videos' => (int)$userVideos,
                    'recent_videos' => $userHistory
                ]
            ]);
            break;
            
        case 'daily_stats':
            // آمار روزانه
            $days = (int)($_GET['days'] ?? 7);
            $stmt = $pdo->prepare("SELECT DATE(created_at) as date, COUNT(*) as count FROM processed_videos WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) GROUP BY DATE(created_at) ORDER BY date DESC");
            $stmt->execute([$days]);
            $dailyStats = $stmt->fetchAll();
            
            echo json_encode([
                'status' => 'success',
                'data' => $dailyStats
            ]);
            break;
            
        default:
            throw new Exception("Invalid action");
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
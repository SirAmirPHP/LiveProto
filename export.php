<?php
/**
 * صادرات داده‌ها
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
    $format = $_GET['format'] ?? 'csv'; // csv, json, xml
    $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
    $endDate = $_GET['end_date'] ?? date('Y-m-d');
    $type = $_GET['type'] ?? 'all'; // all, videos, users, songs
    
    // دریافت داده‌ها
    $data = [];
    
    switch ($type) {
        case 'videos':
            $stmt = $pdo->prepare("
                SELECT 
                    id,
                    user_id,
                    instagram_url,
                    video_url,
                    music_title,
                    artist_name,
                    confidence,
                    created_at
                FROM processed_videos 
                WHERE DATE(created_at) BETWEEN ? AND ?
                ORDER BY created_at DESC
            ");
            $stmt->execute([$startDate, $endDate]);
            $data = $stmt->fetchAll();
            break;
            
        case 'users':
            $stmt = $pdo->prepare("
                SELECT 
                    user_id,
                    COUNT(*) as total_videos,
                    COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful_videos,
                    COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed_videos,
                    AVG(confidence) as avg_confidence,
                    MIN(created_at) as first_video,
                    MAX(created_at) as last_video
                FROM processed_videos 
                WHERE DATE(created_at) BETWEEN ? AND ?
                GROUP BY user_id 
                ORDER BY total_videos DESC
            ");
            $stmt->execute([$startDate, $endDate]);
            $data = $stmt->fetchAll();
            break;
            
        case 'songs':
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
            ");
            $stmt->execute([$startDate, $endDate]);
            $data = $stmt->fetchAll();
            break;
            
        default: // all
            $stmt = $pdo->prepare("
                SELECT 
                    p.id,
                    p.user_id,
                    p.instagram_url,
                    p.video_url,
                    p.music_title,
                    p.artist_name,
                    p.confidence,
                    p.created_at,
                    u.total_videos,
                    u.successful_videos,
                    u.failed_videos
                FROM processed_videos p
                LEFT JOIN (
                    SELECT 
                        user_id,
                        COUNT(*) as total_videos,
                        COUNT(CASE WHEN music_title IS NOT NULL THEN 1 END) as successful_videos,
                        COUNT(CASE WHEN music_title IS NULL THEN 1 END) as failed_videos
                    FROM processed_videos 
                    GROUP BY user_id
                ) u ON p.user_id = u.user_id
                WHERE DATE(p.created_at) BETWEEN ? AND ?
                ORDER BY p.created_at DESC
            ");
            $stmt->execute([$startDate, $endDate]);
            $data = $stmt->fetchAll();
            break;
    }
    
    // تنظیم نام فایل
    $filename = "export_{$type}_{$startDate}_to_{$endDate}";
    
    // صادرات بر اساس فرمت
    switch ($format) {
        case 'csv':
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename={$filename}.csv");
            
            $output = fopen('php://output', 'w');
            
            // BOM برای UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            if (!empty($data)) {
                // هدرها
                fputcsv($output, array_keys($data[0]));
                
                // داده‌ها
                foreach ($data as $row) {
                    fputcsv($output, $row);
                }
            }
            
            fclose($output);
            break;
            
        case 'json':
            header('Content-Type: application/json; charset=utf-8');
            header("Content-Disposition: attachment; filename={$filename}.json");
            
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;
            
        case 'xml':
            header('Content-Type: application/xml; charset=utf-8');
            header("Content-Disposition: attachment; filename={$filename}.xml");
            
            $xml = new SimpleXMLElement('<data/>');
            
            foreach ($data as $row) {
                $item = $xml->addChild('item');
                foreach ($row as $key => $value) {
                    $item->addChild($key, htmlspecialchars($value));
                }
            }
            
            echo $xml->asXML();
            break;
            
        default:
            throw new Exception("فرمت نامعتبر: $format");
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo "خطا در صادرات داده‌ها: " . $e->getMessage();
}
?>
<?php
/**
 * فایل Cron Job برای پاکسازی فایل‌های موقت
 * این فایل باید هر ساعت اجرا شود
 */

require_once 'config.php';
require_once 'database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // پاکسازی فایل‌های موقت قدیمی‌تر از 24 ساعت
    $tempDir = sys_get_temp_dir();
    $files = glob($tempDir . '/instagram_*');
    $files = array_merge($files, glob($tempDir . '/audio_*'));
    $files = array_merge($files, glob($tempDir . '/shazam_*'));
    
    $deletedCount = 0;
    foreach ($files as $file) {
        if (file_exists($file) && (time() - filemtime($file)) > 86400) { // 24 ساعت
            if (unlink($file)) {
                $deletedCount++;
            }
        }
    }
    
    // پاکسازی رکوردهای قدیمی‌تر از 30 روز
    $stmt = $pdo->prepare("DELETE FROM processed_videos WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $stmt->execute();
    $deletedRecords = $stmt->rowCount();
    
    // پاکسازی session های قدیمی
    $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE updated_at < DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stmt->execute();
    $deletedSessions = $stmt->rowCount();
    
    // لاگ کردن نتایج
    error_log("Cron job completed: Deleted $deletedCount temp files, $deletedRecords old records, $deletedSessions old sessions");
    
    echo "Cron job completed successfully\n";
    echo "Deleted temp files: $deletedCount\n";
    echo "Deleted old records: $deletedRecords\n";
    echo "Deleted old sessions: $deletedSessions\n";
    
} catch (Exception $e) {
    error_log("Cron job error: " . $e->getMessage());
    echo "Cron job failed: " . $e->getMessage() . "\n";
}
?>
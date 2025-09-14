<?php
/**
 * فایل پشتیبان‌گیری از دیتابیس
 */

require_once 'config.php';
require_once 'database.php';

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // ایجاد نام فایل پشتیبان
    $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    
    // دستور mysqldump
    $command = "mysqldump -h " . DB_HOST . " -u " . DB_USER . " -p" . DB_PASS . " " . DB_NAME . " > " . $backupFile;
    
    // اجرای دستور
    exec($command, $output, $returnCode);
    
    if ($returnCode === 0 && file_exists($backupFile)) {
        // تنظیم header برای دانلود
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $backupFile . '"');
        header('Content-Length: ' . filesize($backupFile));
        
        // خواندن و ارسال فایل
        readfile($backupFile);
        
        // حذف فایل موقت
        unlink($backupFile);
        
    } else {
        throw new Exception("خطا در ایجاد پشتیبان");
    }
    
} catch (Exception $e) {
    echo "خطا: " . $e->getMessage();
}
?>
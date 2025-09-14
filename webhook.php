<?php
require_once 'telegram_bot.php';

// تنظیم header ها
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// بررسی روش درخواست
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// دریافت داده‌های JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// بررسی صحت داده‌ها
if (!$data || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

try {
    // ایجاد نمونه ربات
    $bot = new TelegramBot();
    
    // پردازش پیام
    $bot->processMessage($data['message']);
    
    // پاسخ موفق
    echo json_encode(['status' => 'success']);
    
} catch (Exception $e) {
    error_log("Webhook error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
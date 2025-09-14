<?php
require_once 'config.php';
require_once 'database.php';
require_once 'instagram_handler.php';
require_once 'music_recognizer.php';

class TelegramBot {
    private $botToken;
    private $db;
    private $instagramHandler;
    private $musicRecognizer;
    
    public function __construct() {
        $this->botToken = BOT_TOKEN;
        $this->db = new Database();
        $this->instagramHandler = new InstagramHandler();
        $this->musicRecognizer = new MusicRecognizer();
        
        // ایجاد جداول دیتابیس
        $this->db->createTables();
    }
    
    /**
     * پردازش پیام‌های دریافتی
     */
    public function processMessage($message) {
        try {
            $chatId = $message['chat']['id'];
            $userId = $message['from']['id'];
            $text = $message['text'] ?? '';
            
            // بررسی نوع پیام
            if (isset($message['text'])) {
                $this->handleTextMessage($chatId, $userId, $text);
            } elseif (isset($message['video'])) {
                $this->handleVideoMessage($chatId, $userId, $message['video']);
            }
            
        } catch (Exception $e) {
            error_log("Message processing error: " . $e->getMessage());
            $this->sendMessage($chatId, "خطایی رخ داد. لطفاً دوباره تلاش کنید.");
        }
    }
    
    /**
     * پردازش پیام‌های متنی
     */
    private function handleTextMessage($chatId, $userId, $text) {
        // بررسی دستورات
        if ($text === '/start') {
            $this->sendWelcomeMessage($chatId);
        } elseif ($text === '/help') {
            $this->sendHelpMessage($chatId);
        } elseif ($this->isInstagramUrl($text)) {
            $this->processInstagramUrl($chatId, $userId, $text);
        } else {
            $this->sendMessage($chatId, "لطفاً لینک ریلز اینستاگرام را ارسال کنید یا از دستور /help استفاده کنید.");
        }
    }
    
    /**
     * پردازش لینک اینستاگرام
     */
    private function processInstagramUrl($chatId, $userId, $url) {
        try {
            // ارسال پیام در حال پردازش
            $this->sendMessage($chatId, "در حال پردازش لینک... لطفاً صبر کنید.");
            
            // استخراج ویدیو از اینستاگرام
            $videoData = $this->instagramHandler->extractVideoFromReels($url);
            
            // دانلود ویدیو
            $videoPath = tempnam(sys_get_temp_dir(), 'instagram_') . '.mp4';
            $this->instagramHandler->downloadVideo($videoData['video_url'], $videoPath);
            
            // شناسایی آهنگ
            $musicInfo = $this->musicRecognizer->recognizeMusic($videoPath);
            
            // ذخیره در دیتابیس
            $this->saveToDatabase($userId, $url, $videoData['video_url'], $musicInfo);
            
            // ارسال نتیجه
            $this->sendMusicResult($chatId, $musicInfo, $videoData);
            
            // پاک کردن فایل موقت
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
            
        } catch (Exception $e) {
            $this->sendMessage($chatId, "خطا: " . $e->getMessage());
        }
    }
    
    /**
     * ارسال پیام خوش‌آمدگویی
     */
    private function sendWelcomeMessage($chatId) {
        $message = "🎵 خوش آمدید به ربات شناسایی آهنگ!\n\n";
        $message .= "برای شناسایی آهنگ، لینک ریلز اینستاگرام را ارسال کنید.\n";
        $message .= "از دستور /help برای راهنمایی بیشتر استفاده کنید.";
        
        $this->sendMessage($chatId, $message);
    }
    
    /**
     * ارسال پیام راهنما
     */
    private function sendHelpMessage($chatId) {
        $message = "📖 راهنمای استفاده:\n\n";
        $message .= "1️⃣ لینک ریلز اینستاگرام را کپی کنید\n";
        $message .= "2️⃣ لینک را در این چت ارسال کنید\n";
        $message .= "3️⃣ ربات آهنگ را شناسایی می‌کند\n\n";
        $message .= "مثال: https://www.instagram.com/reel/ABC123/\n\n";
        $message .= "⚠️ توجه: فقط ریلز و پست‌های ویدیویی پشتیبانی می‌شوند.";
        
        $this->sendMessage($chatId, $message);
    }
    
    /**
     * ارسال نتیجه شناسایی آهنگ
     */
    private function sendMusicResult($chatId, $musicInfo, $videoData) {
        $message = "🎵 آهنگ شناسایی شد!\n\n";
        $message .= "🎶 نام آهنگ: " . $musicInfo['title'] . "\n";
        $message .= "🎤 هنرمند: " . $musicInfo['artist'] . "\n";
        
        if (!empty($musicInfo['album'])) {
            $message .= "💿 آلبوم: " . $musicInfo['album'] . "\n";
        }
        
        if (!empty($musicInfo['release_date'])) {
            $message .= "📅 سال انتشار: " . $musicInfo['release_date'] . "\n";
        }
        
        $confidence = round($musicInfo['confidence'] * 100, 1);
        $message .= "🎯 دقت: " . $confidence . "%\n\n";
        
        if (!empty($videoData['caption'])) {
            $message .= "📝 توضیحات ویدیو:\n" . $videoData['caption'];
        }
        
        $this->sendMessage($chatId, $message);
    }
    
    /**
     * بررسی صحت لینک اینستاگرام
     */
    private function isInstagramUrl($text) {
        $pattern = '/^https?:\/\/(www\.)?instagram\.com\/(p|reel)\/[A-Za-z0-9_-]+\/?/';
        return preg_match($pattern, $text);
    }
    
    /**
     * ذخیره اطلاعات در دیتابیس
     */
    private function saveToDatabase($userId, $instagramUrl, $videoUrl, $musicInfo) {
        try {
            $pdo = $this->db->getConnection();
            $stmt = $pdo->prepare("
                INSERT INTO processed_videos 
                (user_id, instagram_url, video_url, music_title, artist_name, confidence) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $userId,
                $instagramUrl,
                $videoUrl,
                $musicInfo['title'],
                $musicInfo['artist'],
                $musicInfo['confidence']
            ]);
            
        } catch (Exception $e) {
            error_log("Database save error: " . $e->getMessage());
        }
    }
    
    /**
     * ارسال پیام به کاربر
     */
    public function sendMessage($chatId, $text, $replyMarkup = null) {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];
        
        if ($replyMarkup) {
            $data['reply_markup'] = json_encode($replyMarkup);
        }
        
        $this->sendRequest($url, $data);
    }
    
    /**
     * ارسال درخواست HTTP
     */
    private function sendRequest($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log("Telegram API error: HTTP $httpCode - $response");
        }
        
        return $response;
    }
    
    /**
     * تنظیم webhook
     */
    public function setWebhook() {
        $url = "https://api.telegram.org/bot{$this->botToken}/setWebhook";
        $data = ['url' => WEBHOOK_URL];
        
        $response = $this->sendRequest($url, $data);
        return json_decode($response, true);
    }
    
    /**
     * حذف webhook
     */
    public function deleteWebhook() {
        $url = "https://api.telegram.org/bot{$this->botToken}/deleteWebhook";
        $data = ['drop_pending_updates' => true];
        
        $response = $this->sendRequest($url, $data);
        return json_decode($response, true);
    }
}
?>
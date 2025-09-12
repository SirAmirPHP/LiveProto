<?php
/**
 * Telegram Gift Monitor
 * مانیتورینگ و ارسال گیفت‌های جدید تلگرام به کانال
 * 
 * @author Your Name
 * @version 1.0
 */

require_once 'vendor/autoload.php';

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;

class TelegramGiftMonitor
{
    private $api;
    private $config;
    private $lastGiftId = 0;
    private $isRunning = false;

    public function __construct($configFile = 'config.json')
    {
        $this->loadConfig($configFile);
        $this->initializeAPI();
    }

    /**
     * بارگذاری تنظیمات از فایل JSON
     */
    private function loadConfig($configFile)
    {
        if (!file_exists($configFile)) {
            throw new Exception("فایل تنظیمات {$configFile} یافت نشد!");
        }

        $this->config = json_decode(file_get_contents($configFile), true);
        
        if (!$this->config) {
            throw new Exception("خطا در خواندن فایل تنظیمات!");
        }

        // اعتبارسنجی تنظیمات ضروری
        $required = ['api_id', 'api_hash', 'bot_token', 'channel_id'];
        foreach ($required as $key) {
            if (!isset($this->config[$key]) || empty($this->config[$key])) {
                throw new Exception("تنظیمات ضروری '{$key}' یافت نشد!");
            }
        }
    }

    /**
     * راه‌اندازی API تلگرام
     */
    private function initializeAPI()
    {
        try {
            $settings = new Settings();
            $settings->setAppInfo((new AppInfo())
                ->setApiId($this->config['api_id'])
                ->setApiHash($this->config['api_hash'])
                ->setDeviceModel('Telegram Gift Monitor')
                ->setSystemVersion('1.0')
                ->setAppVersion('1.0')
                ->setLangCode('fa')
                ->setSystemLangCode('fa')
            );

            $this->api = new API('session.madeline', $settings);
            $this->api->start();
            
            echo "✅ اتصال به تلگرام برقرار شد\n";
            
        } catch (Exception $e) {
            throw new Exception("خطا در اتصال به تلگرام: " . $e->getMessage());
        }
    }

    /**
     * دریافت لیست گیفت‌های موجود
     */
    private function getAvailableGifts()
    {
        try {
            // دریافت اطلاعات گیفت‌ها از تلگرام
            $result = $this->api->method('messages.getStickers', [
                'stickerset' => [
                    '_' => 'inputStickerSetPremiumGifts',
                    'id' => 0,
                    'access_hash' => 0
                ],
                'hash' => 0
            ]);

            return $result;
        } catch (Exception $e) {
            echo "⚠️ خطا در دریافت گیفت‌ها: " . $e->getMessage() . "\n";
            return null;
        }
    }

    /**
     * بررسی گیفت‌های جدید
     */
    private function checkForNewGifts()
    {
        $gifts = $this->getAvailableGifts();
        
        if (!$gifts || !isset($gifts['stickers'])) {
            return;
        }

        $currentGiftCount = count($gifts['stickers']);
        
        // اگر تعداد گیفت‌ها بیشتر از قبل شده
        if ($currentGiftCount > $this->lastGiftId) {
            $newGifts = array_slice($gifts['stickers'], $this->lastGiftId);
            
            foreach ($newGifts as $gift) {
                $this->sendGiftToChannel($gift);
            }
            
            $this->lastGiftId = $currentGiftCount;
        }
    }

    /**
     * ارسال گیفت به کانال
     */
    private function sendGiftToChannel($gift)
    {
        try {
            $giftInfo = $this->extractGiftInfo($gift);
            
            $message = $this->formatGiftMessage($giftInfo);
            
            // ارسال پیام به کانال
            $this->api->method('messages.sendMessage', [
                'peer' => $this->config['channel_id'],
                'message' => $message,
                'parse_mode' => 'HTML'
            ]);

            echo "🎁 گیفت جدید ارسال شد: {$giftInfo['name']}\n";
            
        } catch (Exception $e) {
            echo "❌ خطا در ارسال گیفت: " . $e->getMessage() . "\n";
        }
    }

    /**
     * استخراج اطلاعات گیفت
     */
    private function extractGiftInfo($gift)
    {
        $info = [
            'id' => $gift['id'] ?? 'نامشخص',
            'name' => 'گیفت جدید',
            'description' => 'گیفت ویژه تلگرام',
            'emoji' => $gift['emoji'] ?? '🎁',
            'file_id' => $gift['file_id'] ?? null
        ];

        // اگر اطلاعات اضافی وجود دارد
        if (isset($gift['attributes'])) {
            foreach ($gift['attributes'] as $attr) {
                if ($attr['_'] === 'documentAttributeSticker') {
                    $info['name'] = $attr['alt'] ?? $info['name'];
                }
            }
        }

        return $info;
    }

    /**
     * فرمت کردن پیام گیفت
     */
    private function formatGiftMessage($giftInfo)
    {
        $message = "🎁 <b>گیفت جدید در تلگرام!</b>\n\n";
        $message .= "📝 <b>نام:</b> {$giftInfo['name']}\n";
        $message .= "🆔 <b>شناسه:</b> {$giftInfo['id']}\n";
        $message .= "😊 <b>ایموجی:</b> {$giftInfo['emoji']}\n";
        $message .= "📄 <b>توضیحات:</b> {$giftInfo['description']}\n\n";
        $message .= "⏰ <b>زمان:</b> " . date('Y-m-d H:i:s') . "\n";
        $message .= "🔗 <b>کانال:</b> @{$this->config['channel_username'] ?? 'نامشخص'}";

        return $message;
    }

    /**
     * شروع مانیتورینگ
     */
    public function startMonitoring()
    {
        echo "🚀 شروع مانیتورینگ گیفت‌های تلگرام...\n";
        echo "📊 کانال مقصد: {$this->config['channel_id']}\n";
        echo "⏱️ فاصله بررسی: {$this->config['check_interval']} ثانیه\n\n";

        $this->isRunning = true;
        $this->lastGiftId = 0;

        while ($this->isRunning) {
            try {
                $this->checkForNewGifts();
                sleep($this->config['check_interval'] ?? 30);
                
            } catch (Exception $e) {
                echo "❌ خطا در مانیتورینگ: " . $e->getMessage() . "\n";
                sleep(10); // صبر کوتاه در صورت خطا
            }
        }
    }

    /**
     * توقف مانیتورینگ
     */
    public function stopMonitoring()
    {
        $this->isRunning = false;
        echo "⏹️ مانیتورینگ متوقف شد\n";
    }

    /**
     * تست اتصال
     */
    public function testConnection()
    {
        try {
            $me = $this->api->getSelf();
            echo "✅ اتصال موفق! کاربر: " . ($me['first_name'] ?? 'نامشخص') . "\n";
            
            // تست ارسال پیام
            $testMessage = "🧪 <b>تست اتصال</b>\n\nاین پیام برای تست اتصال ارسال شده است.\n⏰ زمان: " . date('Y-m-d H:i:s');
            
            $this->api->method('messages.sendMessage', [
                'peer' => $this->config['channel_id'],
                'message' => $testMessage,
                'parse_mode' => 'HTML'
            ]);
            
            echo "✅ پیام تست با موفقیت ارسال شد\n";
            
        } catch (Exception $e) {
            echo "❌ خطا در تست اتصال: " . $e->getMessage() . "\n";
        }
    }
}

// اجرای برنامه
try {
    $monitor = new TelegramGiftMonitor();
    
    // بررسی آرگومان‌های خط فرمان
    $command = $argv[1] ?? 'start';
    
    switch ($command) {
        case 'test':
            $monitor->testConnection();
            break;
            
        case 'start':
        default:
            $monitor->startMonitoring();
            break;
    }
    
} catch (Exception $e) {
    echo "❌ خطای کلی: " . $e->getMessage() . "\n";
    exit(1);
}
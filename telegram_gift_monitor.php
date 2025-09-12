<?php

declare(strict_types=1);

error_reporting(E_ALL);

// نصب خودکار liveproto در صورت عدم وجود
if (file_exists('liveproto.php') === false) {
    copy('https://installer.liveproto.dev/liveproto.php', 'liveproto.php');
    require_once 'liveproto.php';
} else {
    require_once 'liveproto.phar';
}

use Tak\Liveproto\Network\Client;
use Tak\Liveproto\Utils\Settings;
use Tak\Liveproto\Filters\Filter;
use Tak\Liveproto\Filters\Filter\Command;
use Tak\Liveproto\Filters\Events\NewMessage;
use Tak\Liveproto\Filters\Interfaces\Incoming;
use Tak\Liveproto\Filters\Interfaces\IsPrivate;
use Tak\Liveproto\Enums\CommandType;
use Revolt\EventLoop;

/**
 * کلاس اصلی برای مانیتورینگ و ارسال گیفت‌های تلگرام
 */
final class TelegramGiftMonitor
{
    private Client $client;
    private Settings $settings;
    private array $targetChannels = [];
    private array $giftHistory = [];
    private int $checkInterval = 30; // چک کردن هر 30 ثانیه
    private string $configFile = 'gift_config.json';

    public function __construct()
    {
        $this->loadConfiguration();
        $this->initializeClient();
    }

    /**
     * بارگذاری تنظیمات از فایل کانفیگ
     */
    private function loadConfiguration(): void
    {
        if (file_exists($this->configFile)) {
            $config = json_decode(file_get_contents($this->configFile), true);
            $this->targetChannels = $config['channels'] ?? [];
            $this->checkInterval = $config['check_interval'] ?? 30;
        } else {
            $this->createDefaultConfig();
        }
    }

    /**
     * ایجاد فایل کانفیگ پیش‌فرض
     */
    private function createDefaultConfig(): void
    {
        $defaultConfig = [
            'api_id' => 'YOUR_API_ID',
            'api_hash' => 'YOUR_API_HASH',
            'channels' => ['@your_channel_username'],
            'check_interval' => 30,
            'device_model' => 'PC 64bit',
            'system_version' => '4.14.186',
            'app_version' => '1.28.5'
        ];
        
        file_put_contents($this->configFile, json_encode($defaultConfig, JSON_PRETTY_PRINT));
        echo "فایل کانفیگ ایجاد شد. لطفاً تنظیمات را تکمیل کنید.\n";
        exit;
    }

    /**
     * مقداردهی اولیه کلاینت تلگرام
     */
    private function initializeClient(): void
    {
        $config = json_decode(file_get_contents($this->configFile), true);
        
        $this->settings = new Settings();
        $this->settings->setApiId((int)$config['api_id']);
        $this->settings->setApiHash($config['api_hash']);
        $this->settings->setDeviceModel($config['device_model']);
        $this->settings->setSystemVersion($config['system_version']);
        $this->settings->setAppVersion($config['app_version']);
        $this->settings->setIPv6(false);
        $this->settings->setHideLog(false);
        $this->settings->setReceiveUpdates(true);

        $this->client = new Client('telegram_gift_monitor', 'sqlite', $this->settings);
    }

    /**
     * شروع مانیتورینگ گیفت‌ها
     */
    public function startMonitoring(): void
    {
        echo "🚀 شروع مانیتورینگ گیفت‌های تلگرام...\n";
        
        // اضافه کردن هندلر برای دستورات
        $this->client->addHandler($this);
        
        // شروع چک کردن دوره‌ای گیفت‌ها
        EventLoop::unreference(EventLoop::repeat($this->checkInterval, function() {
            $this->checkForNewGifts();
        }));

        $this->client->start();
    }

    /**
     * چک کردن گیفت‌های جدید
     */
    private function checkForNewGifts(): void
    {
        if (!$this->client->isAuthorized() || !$this->client->connected) {
            return;
        }

        try {
            static $lastHash = 0;
            $starGifts = $this->client->payments->getStarGifts(hash: $lastHash);
            
            if ($starGifts->getClass() === 'payments.starGifts') {
                if ($lastHash === 0) {
                    $lastHash = $starGifts->hash;
                    echo "📋 بارگذاری اولیه گیفت‌ها انجام شد\n";
                } else {
                    $lastHash = $starGifts->hash;
                    $this->processNewGifts($starGifts->gifts);
                }
            }
        } catch (Throwable $e) {
            echo "❌ خطا در چک کردن گیفت‌ها: " . $e->getMessage() . "\n";
        }
    }

    /**
     * پردازش گیفت‌های جدید
     */
    private function processNewGifts(array $gifts): void
    {
        foreach ($gifts as $gift) {
            if ($gift->getClass() === 'starGift') {
                $giftId = $gift->id;
                
                // چک کردن اینکه آیا این گیفت قبلاً دیده شده یا نه
                if (!in_array($giftId, $this->giftHistory)) {
                    $this->giftHistory[] = $giftId;
                    $this->sendGiftNotification($gift);
                }
            }
        }
    }

    /**
     * ارسال اعلان گیفت به کانال‌های تعیین شده
     */
    private function sendGiftNotification($gift): void
    {
        $message = $this->formatGiftMessage($gift);
        
        foreach ($this->targetChannels as $channel) {
            try {
                $this->client->messages->sendMessage(
                    peer: $this->client->get_input_peer($channel),
                    message: $message,
                    random_id: random_int(PHP_INT_MIN, PHP_INT_MAX)
                );
                echo "✅ اعلان گیفت به کانال {$channel} ارسال شد\n";
            } catch (Throwable $e) {
                echo "❌ خطا در ارسال به کانال {$channel}: " . $e->getMessage() . "\n";
            }
        }
    }

    /**
     * فرمت کردن پیام گیفت
     */
    private function formatGiftMessage($gift): string
    {
        $title = $gift->title ?? 'بدون عنوان';
        $price = $gift->stars ?? 0;
        $giftId = $gift->id ?? 'نامشخص';
        $requirePremium = $gift->require_premium ? 'بله' : 'خیر';
        $canUpgrade = $gift->can_upgrade ? 'بله' : 'خیر';
        $soldOut = $gift->sold_out ? 'بله' : 'خیر';
        $limited = $gift->limited ? 'بله' : 'خیر';
        
        $message = "🎁 **گیفت جدید در تلگرام!**\n\n";
        $message .= "📝 **عنوان:** {$title}\n";
        $message .= "🆔 **شناسه گیفت:** {$giftId}\n";
        $message .= "⭐ **قیمت (ستاره):** {$price}\n";
        $message .= "💎 **نیاز به پریمیوم:** {$requirePremium}\n";
        $message .= "🔄 **قابل ارتقا:** {$canUpgrade}\n";
        $message .= "🏷️ **محدود:** {$limited}\n";
        $message .= "🛒 **تمام شده:** {$soldOut}\n";
        $message .= "\n⏰ **زمان:** " . date('Y/m/d H:i:s');
        
        return $message;
    }

    /**
     * اضافه کردن کانال جدید
     */
    public function addChannel(string $channel): void
    {
        if (!in_array($channel, $this->targetChannels)) {
            $this->targetChannels[] = $channel;
            $this->saveConfiguration();
            echo "✅ کانال {$channel} اضافه شد\n";
        } else {
            echo "⚠️ کانال {$channel} قبلاً اضافه شده\n";
        }
    }

    /**
     * حذف کانال
     */
    public function removeChannel(string $channel): void
    {
        $key = array_search($channel, $this->targetChannels);
        if ($key !== false) {
            unset($this->targetChannels[$key]);
            $this->targetChannels = array_values($this->targetChannels);
            $this->saveConfiguration();
            echo "✅ کانال {$channel} حذف شد\n";
        } else {
            echo "⚠️ کانال {$channel} یافت نشد\n";
        }
    }

    /**
     * ذخیره تنظیمات
     */
    private function saveConfiguration(): void
    {
        $config = json_decode(file_get_contents($this->configFile), true);
        $config['channels'] = $this->targetChannels;
        $config['check_interval'] = $this->checkInterval;
        file_put_contents($this->configFile, json_encode($config, JSON_PRETTY_PRINT));
    }

    /**
     * نمایش وضعیت فعلی
     */
    public function showStatus(): void
    {
        echo "📊 **وضعیت مانیتورینگ گیفت‌ها:**\n";
        echo "🔗 **کانال‌های هدف:** " . implode(', ', $this->targetChannels) . "\n";
        echo "⏱️ **فاصله چک کردن:** {$this->checkInterval} ثانیه\n";
        echo "📈 **تعداد گیفت‌های مشاهده شده:** " . count($this->giftHistory) . "\n";
        echo "🟢 **وضعیت اتصال:** " . ($this->client->connected ? 'متصل' : 'قطع') . "\n";
    }

    // هندلرهای دستورات برای مدیریت از طریق پیام خصوصی
    #[Filter(new NewMessage(new Command(start: [CommandType::SLASH, CommandType::DOT, CommandType::EXCLAMATION])))]
    public function startCommand(Incoming & IsPrivate $update): void
    {
        $message = "🤖 **ربات مانیتورینگ گیفت‌های تلگرام**\n\n";
        $message .= "📋 **دستورات موجود:**\n";
        $message .= "/status - نمایش وضعیت\n";
        $message .= "/add_channel @channel - اضافه کردن کانال\n";
        $message .= "/remove_channel @channel - حذف کانال\n";
        $message .= "/list_channels - لیست کانال‌ها\n";
        
        $update->reply(message: $message);
    }

    #[Filter(new NewMessage(new Command(status: CommandType::SLASH)))]
    public function statusCommand(Incoming & IsPrivate $update): void
    {
        $status = "📊 **وضعیت سیستم:**\n\n";
        $status .= "🔗 **کانال‌ها:** " . count($this->targetChannels) . "\n";
        $status .= "⏱️ **فاصله چک:** {$this->checkInterval}ث\n";
        $status .= "📈 **گیفت‌های دیده شده:** " . count($this->giftHistory) . "\n";
        $status .= "🟢 **وضعیت:** " . ($this->client->connected ? 'فعال' : 'غیرفعال');
        
        $update->reply(message: $status);
    }

    #[Filter(new NewMessage(new Command(add_channel: CommandType::SLASH)))]
    public function addChannelCommand(Incoming & IsPrivate $update): void
    {
        $text = $update->getMessage();
        $parts = explode(' ', $text, 2);
        
        if (count($parts) < 2) {
            $update->reply(message: "❌ لطفاً نام کانال را وارد کنید: /add_channel @channel");
            return;
        }
        
        $channel = trim($parts[1]);
        $this->addChannel($channel);
        $update->reply(message: "✅ کانال {$channel} اضافه شد");
    }

    #[Filter(new NewMessage(new Command(remove_channel: CommandType::SLASH)))]
    public function removeChannelCommand(Incoming & IsPrivate $update): void
    {
        $text = $update->getMessage();
        $parts = explode(' ', $text, 2);
        
        if (count($parts) < 2) {
            $update->reply(message: "❌ لطفاً نام کانال را وارد کنید: /remove_channel @channel");
            return;
        }
        
        $channel = trim($parts[1]);
        $this->removeChannel($channel);
        $update->reply(message: "✅ کانال {$channel} حذف شد");
    }

    #[Filter(new NewMessage(new Command(list_channels: CommandType::SLASH)))]
    public function listChannelsCommand(Incoming & IsPrivate $update): void
    {
        if (empty($this->targetChannels)) {
            $update->reply(message: "📝 هیچ کانالی اضافه نشده است");
            return;
        }
        
        $message = "📋 **کانال‌های هدف:**\n\n";
        foreach ($this->targetChannels as $index => $channel) {
            $message .= ($index + 1) . ". {$channel}\n";
        }
        
        $update->reply(message: $message);
    }
}

// اجرای برنامه
try {
    $monitor = new TelegramGiftMonitor();
    $monitor->startMonitoring();
} catch (Throwable $e) {
    echo "❌ خطای کلی: " . $e->getMessage() . "\n";
    echo "📍 فایل: " . $e->getFile() . " خط " . $e->getLine() . "\n";
}

?>
<?php
// Telegram Bot Configuration
define('BOT_TOKEN', 'YOUR_BOT_TOKEN_HERE');
define('WEBHOOK_URL', 'https://yourdomain.com/bot.php');

// Database files
define('CHANNELS_FILE', 'channels.txt');
define('DATABASE_FILE', 'database.json');

// Initialize database if not exists
if (!file_exists(DATABASE_FILE)) {
    file_put_contents(DATABASE_FILE, json_encode(['channels' => [], 'captions' => []]));
}

// Get webhook update
$update = json_decode(file_get_contents('php://input'), true);

if (!$update) {
    // Set webhook if this is a direct access
    if (isset($_GET['set_webhook'])) {
        setWebhook();
    }
    exit;
}

// Process the update
processUpdate($update);

function setWebhook() {
    $url = WEBHOOK_URL;
    $response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/setWebhook?url=" . urlencode($url));
    echo "Webhook set: " . $response;
}

function processUpdate($update) {
    if (isset($update['message'])) {
        $message = $update['message'];
        $chat_id = $message['chat']['id'];
        $user_id = $message['from']['id'];
        $text = $message['text'] ?? '';
        
        if ($text === '/start') {
            showMainMenu($chat_id);
        } elseif ($text === 'افزودن ربات به کانال') {
            addBotToChannel($chat_id, $user_id);
        } elseif ($text === 'مدیریت کانال') {
            manageChannels($chat_id, $user_id);
        } elseif (isset($message['new_chat_members'])) {
            handleNewChatMember($message);
        }
    } elseif (isset($update['callback_query'])) {
        handleCallbackQuery($update['callback_query']);
    }
}

function showMainMenu($chat_id) {
    $keyboard = [
        'keyboard' => [
            [['text' => 'افزودن ربات به کانال']],
            [['text' => 'مدیریت کانال']]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => false
    ];
    
    $message = "🤖 ربات مدیریت کانال\n\n";
    $message .= "لطفا یکی از گزینه های زیر را انتخاب کنید:";
    
    sendMessage($chat_id, $message, $keyboard);
}

function addBotToChannel($chat_id, $user_id) {
    $message = "📢 برای افزودن ربات به کانال:\n\n";
    $message .= "1️⃣ ربات را به کانال خود اضافه کنید\n";
    $message .= "2️⃣ ربات را به عنوان ادمین کانال تنظیم کنید\n";
    $message .= "3️⃣ فقط مالک کانال می‌تواند ربات را اضافه کند\n\n";
    $message .= "⚠️ توجه: ربات باید دسترسی کامل به کانال داشته باشد";
    
    sendMessage($chat_id, $message);
}

function manageChannels($chat_id, $user_id) {
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    $user_channels = [];
    
    // Find channels owned by this user
    foreach ($database['channels'] as $channel_id => $owner_id) {
        if ($owner_id == $user_id) {
            $user_channels[] = $channel_id;
        }
    }
    
    if (empty($user_channels)) {
        $message = "❌ هیچ کانالی توسط شما اضافه نشده است.\n\n";
        $message .= "ابتدا ربات را به کانال خود اضافه کنید.";
        sendMessage($chat_id, $message);
        return;
    }
    
    // Create inline keyboard for channels
    $keyboard = ['inline_keyboard' => []];
    foreach ($user_channels as $channel_id) {
        $channel_info = getChannelInfo($channel_id);
        $channel_name = $channel_info['title'] ?? "کانال " . $channel_id;
        
        $keyboard['inline_keyboard'][] = [
            ['text' => "📢 " . $channel_name, 'callback_data' => "manage_" . $channel_id]
        ];
    }
    
    $message = "📋 کانال‌های شما:\n\n";
    $message .= "برای مدیریت هر کانال، روی آن کلیک کنید:";
    
    sendMessage($chat_id, $message, $keyboard);
}

function handleNewChatMember($message) {
    $chat = $message['chat'];
    $new_members = $message['new_chat_members'];
    
    // Check if bot was added to a channel
    foreach ($new_members as $member) {
        if ($member['id'] == getBotId()) {
            $chat_id = $chat['id'];
            $chat_type = $chat['type'];
            
            if ($chat_type === 'channel') {
                // Get chat administrators to verify ownership
                $admins = getChatAdministrators($chat_id);
                $bot_admin = false;
                $owner_id = null;
                
                foreach ($admins as $admin) {
                    if ($admin['user']['id'] == getBotId()) {
                        $bot_admin = true;
                    }
                    if ($admin['status'] === 'creator') {
                        $owner_id = $admin['user']['id'];
                    }
                }
                
                if ($bot_admin && $owner_id) {
                    // Add channel to database
                    addChannelToDatabase($chat_id, $owner_id);
                    
                    $message = "✅ ربات با موفقیت به کانال اضافه شد!\n\n";
                    $message .= "کانال: " . ($chat['title'] ?? "کانال " . $chat_id) . "\n";
                    $message .= "مالک: " . ($chat['username'] ?? "نام کاربری نامشخص");
                    
                    sendMessage($owner_id, $message);
                } else {
                    $message = "❌ ربات باید به عنوان ادمین کانال تنظیم شود و فقط مالک کانال می‌تواند آن را اضافه کند.";
                    sendMessage($chat_id, $message);
                }
            }
        }
    }
}

function handleCallbackQuery($callback_query) {
    $chat_id = $callback_query['message']['chat']['id'];
    $user_id = $callback_query['from']['id'];
    $data = $callback_query['data'];
    
    if (strpos($data, 'manage_') === 0) {
        $channel_id = str_replace('manage_', '', $data);
        showChannelManagement($chat_id, $user_id, $channel_id);
    } elseif (strpos($data, 'delete_') === 0) {
        $channel_id = str_replace('delete_', '', $data);
        deleteChannel($chat_id, $user_id, $channel_id);
    } elseif (strpos($data, 'caption_') === 0) {
        $channel_id = str_replace('caption_', '', $data);
        requestCaption($chat_id, $user_id, $channel_id);
    }
    
    // Answer callback query
    answerCallbackQuery($callback_query['id']);
}

function showChannelManagement($chat_id, $user_id, $channel_id) {
    // Verify ownership
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    if (!isset($database['channels'][$channel_id]) || $database['channels'][$channel_id] != $user_id) {
        sendMessage($chat_id, "❌ شما مجاز به مدیریت این کانال نیستید.");
        return;
    }
    
    $channel_info = getChannelInfo($channel_id);
    $channel_name = $channel_info['title'] ?? "کانال " . $channel_id;
    $current_caption = $database['captions'][$channel_id] ?? '';
    
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '✏️ تنظیم کپشن', 'callback_data' => 'caption_' . $channel_id],
                ['text' => '🗑️ حذف کانال', 'callback_data' => 'delete_' . $channel_id]
            ]
        ]
    ];
    
    $message = "⚙️ مدیریت کانال: " . $channel_name . "\n\n";
    $message .= "🆔 شناسه کانال: " . $channel_id . "\n";
    $message .= "📝 کپشن فعلی: " . ($current_caption ?: "تنظیم نشده") . "\n\n";
    $message .= "گزینه مورد نظر خود را انتخاب کنید:";
    
    sendMessage($chat_id, $message, $keyboard);
}

function deleteChannel($chat_id, $user_id, $channel_id) {
    // Verify ownership
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    if (!isset($database['channels'][$channel_id]) || $database['channels'][$channel_id] != $user_id) {
        sendMessage($chat_id, "❌ شما مجاز به حذف این کانال نیستید.");
        return;
    }
    
    // Remove from database
    unset($database['channels'][$channel_id]);
    unset($database['captions'][$channel_id]);
    file_put_contents(DATABASE_FILE, json_encode($database));
    
    // Remove from channels.txt
    $channels = file_get_contents(CHANNELS_FILE);
    $channels = str_replace($channel_id . "\n", '', $channels);
    file_put_contents(CHANNELS_FILE, $channels);
    
    $message = "✅ کانال با موفقیت حذف شد!";
    sendMessage($chat_id, $message);
}

function requestCaption($chat_id, $user_id, $channel_id) {
    // Store pending caption request
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    $database['pending_captions'][$user_id] = $channel_id;
    file_put_contents(DATABASE_FILE, json_encode($database));
    
    $message = "📝 لطفا کپشن جدید کانال را ارسال کنید:\n\n";
    $message .= "⚠️ توجه: این کپشن برای ارسال پیام‌های خودکار استفاده خواهد شد.";
    
    sendMessage($chat_id, $message);
}

function addChannelToDatabase($channel_id, $owner_id) {
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    $database['channels'][$channel_id] = $owner_id;
    file_put_contents(DATABASE_FILE, json_encode($database));
    
    // Add to channels.txt
    $channels = file_get_contents(CHANNELS_FILE);
    if (strpos($channels, $channel_id) === false) {
        file_put_contents(CHANNELS_FILE, $channels . $channel_id . "\n", FILE_APPEND);
    }
}

function getChannelInfo($channel_id) {
    $response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/getChat?chat_id=" . $channel_id);
    $data = json_decode($response, true);
    return $data['result'] ?? [];
}

function getChatAdministrators($chat_id) {
    $response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/getChatAdministrators?chat_id=" . $chat_id);
    $data = json_decode($response, true);
    return $data['result'] ?? [];
}

function getBotId() {
    $response = file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/getMe");
    $data = json_decode($response, true);
    return $data['result']['id'] ?? null;
}

function sendMessage($chat_id, $text, $reply_markup = null) {
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    
    if ($reply_markup) {
        $data['reply_markup'] = json_encode($reply_markup);
    }
    
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

function answerCallbackQuery($callback_query_id, $text = '') {
    $data = [
        'callback_query_id' => $callback_query_id,
        'text' => $text
    ];
    
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/answerCallbackQuery";
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Handle caption setting
if (isset($update['message']) && isset($update['message']['text'])) {
    $message = $update['message'];
    $user_id = $message['from']['id'];
    $text = $message['text'];
    
    $database = json_decode(file_get_contents(DATABASE_FILE), true);
    if (isset($database['pending_captions'][$user_id])) {
        $channel_id = $database['pending_captions'][$user_id];
        
        // Verify ownership
        if (isset($database['channels'][$channel_id]) && $database['channels'][$channel_id] == $user_id) {
            $database['captions'][$channel_id] = $text;
            unset($database['pending_captions'][$user_id]);
            file_put_contents(DATABASE_FILE, json_encode($database));
            
            $message_text = "✅ کپشن کانال با موفقیت تنظیم شد!";
            sendMessage($message['chat']['id'], $message_text);
        } else {
            $message_text = "❌ خطا در تنظیم کپشن. لطفا دوباره تلاش کنید.";
            sendMessage($message['chat']['id'], $message_text);
        }
    }
}
?>
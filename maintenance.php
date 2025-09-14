<?php
/**
 * صفحه نگهداری
 */

// بررسی وضعیت نگهداری
$maintenanceMode = true; // تغییر دهید به false برای غیرفعال کردن
$maintenanceMessage = "سیستم در حال نگهداری است. لطفاً بعداً تلاش کنید.";
$estimatedTime = "2 ساعت";

if (!$maintenanceMode) {
    header('Location: /');
    exit;
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نگهداری سیستم - ربات شناسایی آهنگ</title>
    <style>
        body { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0; 
            padding: 0; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .maintenance-container { 
            max-width: 600px; 
            margin: 20px; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }
        .maintenance-icon {
            font-size: 4em;
            color: #667eea;
            margin: 20px 0;
        }
        .maintenance-title {
            font-size: 2.5em;
            color: #333;
            margin: 20px 0;
        }
        .maintenance-message {
            font-size: 1.2em;
            color: #666;
            margin: 20px 0;
            line-height: 1.6;
        }
        .estimated-time {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .estimated-time h3 {
            color: #333;
            margin-top: 0;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            width: 0%;
            animation: progress 3s ease-in-out infinite;
        }
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 0%; }
        }
        .contact-info {
            background: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: right;
        }
        .contact-info h3 {
            color: #333;
            margin-top: 0;
        }
        .contact-info p {
            margin: 5px 0;
            color: #666;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 5px;
            padding: 10px 15px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .social-links a:hover {
            background: #5a6fd8;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>
        <h1 class="maintenance-title">سیستم در حال نگهداری</h1>
        <p class="maintenance-message"><?php echo $maintenanceMessage; ?></p>
        
        <div class="estimated-time">
            <h3>⏰ زمان تقریبی تکمیل</h3>
            <p><?php echo $estimatedTime; ?></p>
        </div>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <div class="contact-info">
            <h3>📞 اطلاعات تماس</h3>
            <p><strong>ایمیل:</strong> support@yourdomain.com</p>
            <p><strong>تلگرام:</strong> @your_support_bot</p>
            <p><strong>ساعات کاری:</strong> 9 صبح تا 6 عصر</p>
        </div>
        
        <div class="social-links">
            <a href="https://t.me/your_bot" target="_blank">📱 تلگرام</a>
            <a href="https://instagram.com/your_account" target="_blank">📷 اینستاگرام</a>
            <a href="https://twitter.com/your_account" target="_blank">🐦 توییتر</a>
        </div>
        
        <p style="color: #999; font-size: 0.9em; margin-top: 30px;">
            از صبر و شکیبایی شما متشکریم 🙏
        </p>
    </div>
</body>
</html>
<?php
// صفحه اصلی ربات
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ربات شناسایی آهنگ</title>
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
        .container { 
            max-width: 600px; 
            margin: 20px; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }
        h1 { 
            color: #333; 
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .status { 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 10px; 
            font-size: 1.1em;
        }
        .success { 
            background: linear-gradient(135deg, #d4edda, #c3e6cb); 
            color: #155724; 
            border: 2px solid #c3e6cb; 
        }
        .info { 
            background: linear-gradient(135deg, #d1ecf1, #bee5eb); 
            color: #0c5460; 
            border: 2px solid #bee5eb; 
        }
        .feature {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .emoji {
            font-size: 1.5em;
            margin-left: 10px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            margin: 10px;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎵 ربات شناسایی آهنگ</h1>
        
        <div class="status success">
            <strong>✅ ربات فعال است!</strong><br>
            برای استفاده از ربات، آن را در تلگرام پیدا کنید و شروع به چت کنید.
        </div>
        
        <div class="status info">
            <strong>📖 راهنمای استفاده:</strong><br>
            1. لینک ریلز اینستاگرام را کپی کنید<br>
            2. لینک را در چت ربات ارسال کنید<br>
            3. ربات آهنگ را شناسایی می‌کند
        </div>
        
        <div class="feature">
            <span class="emoji">🎶</span>
            <strong>شناسایی آهنگ</strong> - از ریلزهای اینستاگرام
        </div>
        
        <div class="feature">
            <span class="emoji">🎤</span>
            <strong>نمایش هنرمند</strong> - نام خواننده و آهنگ
        </div>
        
        <div class="feature">
            <span class="emoji">💿</span>
            <strong>اطلاعات کامل</strong> - آلبوم، سال انتشار و دقت
        </div>
        
        <div class="feature">
            <span class="emoji">🔒</span>
            <strong>امنیت بالا</strong> - محافظت از داده‌های کاربران
        </div>
        
        <a href="setup.php" class="btn">⚙️ تنظیمات</a>
        <a href="test.php" class="btn">🧪 تست ربات</a>
    </div>
</body>
</html>
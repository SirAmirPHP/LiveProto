<?php
/**
 * صفحه خطا
 */

// دریافت کد خطا
$errorCode = $_GET['code'] ?? '404';
$errorMessage = $_GET['message'] ?? 'صفحه یافت نشد';

// تعریف پیام‌های خطا
$errorMessages = [
    '400' => 'درخواست نامعتبر',
    '401' => 'دسترسی غیرمجاز',
    '403' => 'دسترسی ممنوع',
    '404' => 'صفحه یافت نشد',
    '500' => 'خطای سرور',
    '503' => 'سرویس در دسترس نیست'
];

$errorTitle = $errorMessages[$errorCode] ?? 'خطای ناشناخته';

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطا - ربات شناسایی آهنگ</title>
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
        .error-container { 
            max-width: 600px; 
            margin: 20px; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }
        .error-code {
            font-size: 6em;
            font-weight: bold;
            color: #667eea;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .error-title {
            font-size: 2em;
            color: #333;
            margin: 20px 0;
        }
        .error-message {
            font-size: 1.2em;
            color: #666;
            margin: 20px 0;
            line-height: 1.6;
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
        .help-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: right;
        }
        .help-section h3 {
            color: #333;
            margin-top: 0;
        }
        .help-section ul {
            margin: 10px 0;
            padding-right: 20px;
        }
        .help-section li {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code"><?php echo $errorCode; ?></div>
        <h1 class="error-title"><?php echo $errorTitle; ?></h1>
        <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
        
        <div class="help-section">
            <h3>راه‌های حل مشکل:</h3>
            <ul>
                <li>آدرس URL را بررسی کنید</li>
                <li>به صفحه اصلی بازگردید</li>
                <li>صفحه را تازه‌سازی کنید</li>
                <li>در صورت ادامه مشکل، با پشتیبانی تماس بگیرید</li>
            </ul>
        </div>
        
        <a href="/" class="btn">🏠 صفحه اصلی</a>
        <a href="javascript:history.back()" class="btn">⬅️ بازگشت</a>
        <a href="javascript:location.reload()" class="btn">🔄 تازه‌سازی</a>
    </div>
</body>
</html>
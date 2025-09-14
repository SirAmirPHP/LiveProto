<?php
// نصب و راه‌اندازی ربات
echo "<h2>نصب و راه‌اندازی ربات شناسایی آهنگ</h2>";

// بررسی نسخه PHP
echo "<h3>بررسی نسخه PHP:</h3>";
if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
    echo "<p style='color: green;'>✅ نسخه PHP مناسب: " . PHP_VERSION . "</p>";
} else {
    echo "<p style='color: red;'>❌ نسخه PHP نامناسب: " . PHP_VERSION . " (حداقل 7.4.0 مورد نیاز است)</p>";
}

// بررسی extension های مورد نیاز
echo "<h3>بررسی Extension های مورد نیاز:</h3>";
$requiredExtensions = ['curl', 'json', 'pdo', 'pdo_mysql'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p style='color: green;'>✅ $ext</p>";
    } else {
        echo "<p style='color: red;'>❌ $ext (نصب نشده)</p>";
    }
}

// بررسی دسترسی به FFmpeg
echo "<h3>بررسی FFmpeg:</h3>";
$ffmpegPath = shell_exec('which ffmpeg');
if ($ffmpegPath) {
    echo "<p style='color: green;'>✅ FFmpeg نصب شده: " . trim($ffmpegPath) . "</p>";
} else {
    echo "<p style='color: red;'>❌ FFmpeg نصب نشده (برای استخراج صدا از ویدیو مورد نیاز است)</p>";
    echo "<p>برای نصب FFmpeg در cPanel:</p>";
    echo "<ul>";
    echo "<li>از Softaculous Apps Installer استفاده کنید</li>";
    echo "<li>یا از terminal دستور زیر را اجرا کنید: <code>yum install ffmpeg</code></li>";
    echo "</ul>";
}

// ایجاد فایل .htaccess
echo "<h3>ایجاد فایل .htaccess:</h3>";
$htaccessContent = "RewriteEngine On\n";
$htaccessContent .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
$htaccessContent .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
$htaccessContent .= "RewriteRule ^(.*)$ index.php [QSA,L]\n\n";
$htaccessContent .= "# امنیت\n";
$htaccessContent .= "Options -Indexes\n";
$htaccessContent .= "ServerSignature Off\n\n";
$htaccessContent .= "# محدودیت فایل\n";
$htaccessContent .= "php_value upload_max_filesize 50M\n";
$htaccessContent .= "php_value post_max_size 50M\n";
$htaccessContent .= "php_value max_execution_time 300\n";
$htaccessContent .= "php_value memory_limit 256M\n";

if (file_put_contents('.htaccess', $htaccessContent)) {
    echo "<p style='color: green;'>✅ فایل .htaccess ایجاد شد</p>";
} else {
    echo "<p style='color: red;'>❌ خطا در ایجاد فایل .htaccess</p>";
}

// ایجاد فایل index.php
echo "<h3>ایجاد فایل index.php:</h3>";
$indexContent = "<?php\n";
$indexContent .= "// صفحه اصلی ربات\n";
$indexContent .= "header('Content-Type: text/html; charset=utf-8');\n";
$indexContent .= "?>\n";
$indexContent .= "<!DOCTYPE html>\n";
$indexContent .= "<html dir='rtl' lang='fa'>\n";
$indexContent .= "<head>\n";
$indexContent .= "    <meta charset='UTF-8'>\n";
$indexContent .= "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
$indexContent .= "    <title>ربات شناسایی آهنگ</title>\n";
$indexContent .= "    <style>\n";
$indexContent .= "        body { font-family: 'Tahoma', sans-serif; margin: 40px; background: #f5f5f5; }\n";
$indexContent .= "        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }\n";
$indexContent .= "        h1 { color: #333; text-align: center; }\n";
$indexContent .= "        .status { padding: 15px; margin: 10px 0; border-radius: 5px; }\n";
$indexContent .= "        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }\n";
$indexContent .= "        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }\n";
$indexContent .= "    </style>\n";
$indexContent .= "</head>\n";
$indexContent .= "<body>\n";
$indexContent .= "    <div class='container'>\n";
$indexContent .= "        <h1>🎵 ربات شناسایی آهنگ</h1>\n";
$indexContent .= "        <div class='status success'>\n";
$indexContent .= "            <strong>✅ ربات فعال است!</strong><br>\n";
$indexContent .= "            برای استفاده از ربات، آن را در تلگرام پیدا کنید و شروع به چت کنید.\n";
$indexContent .= "        </div>\n";
$indexContent .= "        <div class='status info'>\n";
$indexContent .= "            <strong>📖 راهنمای استفاده:</strong><br>\n";
$indexContent .= "            1. لینک ریلز اینستاگرام را کپی کنید<br>\n";
$indexContent .= "            2. لینک را در چت ربات ارسال کنید<br>\n";
$indexContent .= "            3. ربات آهنگ را شناسایی می‌کند\n";
$indexContent .= "        </div>\n";
$indexContent .= "    </div>\n";
$indexContent .= "</body>\n";
$indexContent .= "</html>";

if (file_put_contents('index.php', $indexContent)) {
    echo "<p style='color: green;'>✅ فایل index.php ایجاد شد</p>";
} else {
    echo "<p style='color: red;'>❌ خطا در ایجاد فایل index.php</p>";
}

// راهنمای نصب
echo "<h3>راهنمای نصب:</h3>";
echo "<ol>";
echo "<li><strong>تنظیم دیتابیس:</strong> دیتابیس MySQL ایجاد کنید و اطلاعات آن را در فایل config.php وارد کنید</li>";
echo "<li><strong>تنظیم ربات:</strong> ربات تلگرام ایجاد کنید و توکن آن را در config.php وارد کنید</li>";
echo "<li><strong>تنظیم API:</strong> کلیدهای API مورد نیاز را دریافت و در config.php وارد کنید</li>";
echo "<li><strong>تنظیم Webhook:</strong> از فایل setup.php برای تنظیم webhook استفاده کنید</li>";
echo "<li><strong>تست ربات:</strong> از فایل test.php برای تست ربات استفاده کنید</li>";
echo "</ol>";

echo "<h3>API های مورد نیاز:</h3>";
echo "<ul>";
echo "<li><strong>Instagram Basic Display API:</strong> برای دسترسی به محتوای اینستاگرام</li>";
echo "<li><strong>ACRCloud API:</strong> برای شناسایی آهنگ (رایگان تا 1000 درخواست در ماه)</li>";
echo "<li><strong>Shazam API:</strong> جایگزین ACRCloud (از RapidAPI)</li>";
echo "</ul>";

echo "<h3>نکات مهم:</h3>";
echo "<ul>";
echo "<li>مطمئن شوید که سرور شما FFmpeg نصب دارد</li>";
echo "<li>فضای کافی برای ذخیره فایل‌های موقت در نظر بگیرید</li>";
echo "<li>از SSL certificate معتبر استفاده کنید</li>";
echo "<li>فایل config.php را از دسترسی عمومی محافظت کنید</li>";
echo "</ul>";
?>
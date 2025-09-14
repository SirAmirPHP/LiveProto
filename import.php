<?php
/**
 * واردات داده‌ها
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

require_once 'database.php';

// بررسی درخواست POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    try {
        $db = new Database();
        $pdo = $db->getConnection();
        
        $file = $_FILES['file'];
        $format = $_POST['format'] ?? 'csv';
        
        // بررسی فایل
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("خطا در آپلود فایل");
        }
        
        // بررسی فرمت
        $allowedFormats = ['csv', 'json', 'xml'];
        if (!in_array($format, $allowedFormats)) {
            throw new Exception("فرمت نامعتبر");
        }
        
        // خواندن فایل
        $content = file_get_contents($file['tmp_name']);
        if ($content === false) {
            throw new Exception("خطا در خواندن فایل");
        }
        
        // تجزیه داده‌ها
        $data = [];
        
        switch ($format) {
            case 'csv':
                $lines = explode("\n", $content);
                $headers = str_getcsv($lines[0]);
                
                for ($i = 1; $i < count($lines); $i++) {
                    if (trim($lines[$i])) {
                        $row = str_getcsv($lines[$i]);
                        if (count($row) === count($headers)) {
                            $data[] = array_combine($headers, $row);
                        }
                    }
                }
                break;
                
            case 'json':
                $data = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("خطا در تجزیه JSON: " . json_last_error_msg());
                }
                break;
                
            case 'xml':
                $xml = simplexml_load_string($content);
                if ($xml === false) {
                    throw new Exception("خطا در تجزیه XML");
                }
                
                foreach ($xml->item as $item) {
                    $row = [];
                    foreach ($item->children() as $key => $value) {
                        $row[$key] = (string)$value;
                    }
                    $data[] = $row;
                }
                break;
        }
        
        // بررسی داده‌ها
        if (empty($data)) {
            throw new Exception("هیچ داده‌ای یافت نشد");
        }
        
        // بررسی ساختار داده‌ها
        $requiredFields = ['user_id', 'instagram_url', 'created_at'];
        $firstRow = $data[0];
        
        foreach ($requiredFields as $field) {
            if (!isset($firstRow[$field])) {
                throw new Exception("فیلد الزامی یافت نشد: $field");
            }
        }
        
        // شروع تراکنش
        $pdo->beginTransaction();
        
        $imported = 0;
        $errors = 0;
        
        foreach ($data as $row) {
            try {
                // بررسی وجود رکورد
                $stmt = $pdo->prepare("
                    SELECT id FROM processed_videos 
                    WHERE user_id = ? AND instagram_url = ? AND created_at = ?
                ");
                $stmt->execute([
                    $row['user_id'],
                    $row['instagram_url'],
                    $row['created_at']
                ]);
                
                if ($stmt->rowCount() > 0) {
                    // به‌روزرسانی رکورد موجود
                    $stmt = $pdo->prepare("
                        UPDATE processed_videos 
                        SET video_url = ?, music_title = ?, artist_name = ?, confidence = ?
                        WHERE user_id = ? AND instagram_url = ? AND created_at = ?
                    ");
                    $stmt->execute([
                        $row['video_url'] ?? null,
                        $row['music_title'] ?? null,
                        $row['artist_name'] ?? null,
                        $row['confidence'] ?? null,
                        $row['user_id'],
                        $row['instagram_url'],
                        $row['created_at']
                    ]);
                } else {
                    // درج رکورد جدید
                    $stmt = $pdo->prepare("
                        INSERT INTO processed_videos 
                        (user_id, instagram_url, video_url, music_title, artist_name, confidence, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $row['user_id'],
                        $row['instagram_url'],
                        $row['video_url'] ?? null,
                        $row['music_title'] ?? null,
                        $row['artist_name'] ?? null,
                        $row['confidence'] ?? null,
                        $row['created_at']
                    ]);
                }
                
                $imported++;
                
            } catch (Exception $e) {
                $errors++;
                error_log("Import error: " . $e->getMessage());
            }
        }
        
        // تأیید تراکنش
        $pdo->commit();
        
        // پاسخ موفقیت
        echo json_encode([
            'status' => 'success',
            'imported' => $imported,
            'errors' => $errors,
            'total' => count($data)
        ]);
        
    } catch (Exception $e) {
        // برگشت تراکنش
        if (isset($pdo)) {
            $pdo->rollBack();
        }
        
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    
    exit;
}

// نمایش فرم آپلود
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واردات داده‌ها</title>
    <style>
        body { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #333; 
            text-align: center; 
            margin-bottom: 30px;
        }
        .form-group {
            margin: 20px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .help-text {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .help-text h3 {
            margin-top: 0;
            color: #333;
        }
        .help-text ul {
            margin: 10px 0;
            padding-right: 20px;
        }
        .help-text li {
            margin: 5px 0;
            color: #666;
        }
        .file-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            display: none;
        }
        .file-info h3 {
            margin-top: 0;
            color: #333;
        }
        .file-info pre {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📥 واردات داده‌ها</h1>
        
        <form id="importForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">فایل:</label>
                <input type="file" id="file" name="file" accept=".csv,.json,.xml" required>
            </div>
            
            <div class="form-group">
                <label for="format">فرمت فایل:</label>
                <select id="format" name="format" required>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                    <option value="xml">XML</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">📤 وارد کردن</button>
                <a href="admin.php?password=<?php echo $adminPassword; ?>" class="btn btn-secondary">❌ لغو</a>
            </div>
        </form>
        
        <div class="help-text">
            <h3>📋 راهنمای واردات</h3>
            <ul>
                <li><strong>CSV:</strong> فایل با جداکننده کاما، اولین سطر باید شامل نام ستون‌ها باشد</li>
                <li><strong>JSON:</strong> آرایه‌ای از اشیاء با فیلدهای مورد نیاز</li>
                <li><strong>XML:</strong> فایل XML با ساختار مشخص</li>
            </ul>
            
            <h3>🔧 فیلدهای الزامی</h3>
            <ul>
                <li><strong>user_id:</strong> شناسه کاربر</li>
                <li><strong>instagram_url:</strong> لینک اینستاگرام</li>
                <li><strong>created_at:</strong> تاریخ ایجاد</li>
            </ul>
            
            <h3>📝 فیلدهای اختیاری</h3>
            <ul>
                <li><strong>video_url:</strong> لینک ویدیو</li>
                <li><strong>music_title:</strong> نام آهنگ</li>
                <li><strong>artist_name:</strong> نام هنرمند</li>
                <li><strong>confidence:</strong> دقت شناسایی</li>
            </ul>
        </div>
        
        <div class="file-info" id="fileInfo">
            <h3>📄 اطلاعات فایل</h3>
            <pre id="fileContent"></pre>
        </div>
    </div>
    
    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const content = e.target.result;
                    document.getElementById('fileContent').textContent = content.substring(0, 1000) + '...';
                    document.getElementById('fileInfo').style.display = 'block';
                };
                reader.readAsText(file);
            }
        });
        
        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('import.php?password=<?php echo $adminPassword; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(`واردات موفق!\nوارد شده: ${data.imported}\nخطاها: ${data.errors}\nکل: ${data.total}`);
                    window.location.href = 'admin.php?password=<?php echo $adminPassword; ?>';
                } else {
                    alert('خطا: ' + data.message);
                }
            })
            .catch(error => {
                alert('خطا: ' + error.message);
            });
        });
    </script>
</body>
</html>
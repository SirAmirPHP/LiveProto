<?php
/**
 * جستجو در داده‌ها
 */

// بررسی دسترسی ادمین
$adminPassword = 'your_admin_password'; // تغییر دهید
if (!isset($_GET['password']) || $_GET['password'] !== $adminPassword) {
    die('دسترسی غیرمجاز');
}

require_once 'database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();
    
    // دریافت پارامترهای جستجو
    $query = $_GET['q'] ?? '';
    $type = $_GET['type'] ?? 'all'; // all, videos, users, songs
    $page = (int)($_GET['page'] ?? 1);
    $limit = (int)($_GET['limit'] ?? 20);
    $sort = $_GET['sort'] ?? 'created_at';
    $order = $_GET['order'] ?? 'DESC';
    
    // تنظیم offset
    $offset = ($page - 1) * $limit;
    
    // ساختار جستجو
    $whereConditions = [];
    $params = [];
    
    if (!empty($query)) {
        switch ($type) {
            case 'videos':
                $whereConditions[] = "(music_title LIKE ? OR artist_name LIKE ? OR instagram_url LIKE ?)";
                $params[] = "%$query%";
                $params[] = "%$query%";
                $params[] = "%$query%";
                break;
                
            case 'users':
                $whereConditions[] = "user_id LIKE ?";
                $params[] = "%$query%";
                break;
                
            case 'songs':
                $whereConditions[] = "(music_title LIKE ? OR artist_name LIKE ?)";
                $params[] = "%$query%";
                $params[] = "%$query%";
                break;
                
            default: // all
                $whereConditions[] = "(music_title LIKE ? OR artist_name LIKE ? OR instagram_url LIKE ? OR user_id LIKE ?)";
                $params[] = "%$query%";
                $params[] = "%$query%";
                $params[] = "%$query%";
                $params[] = "%$query%";
                break;
        }
    }
    
    // ساختار WHERE
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // ساختار ORDER BY
    $allowedSorts = ['created_at', 'music_title', 'artist_name', 'user_id', 'confidence'];
    $sort = in_array($sort, $allowedSorts) ? $sort : 'created_at';
    $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';
    $orderClause = "ORDER BY $sort $order";
    
    // شمارش کل نتایج
    $countSql = "SELECT COUNT(*) as total FROM processed_videos $whereClause";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $totalResults = $countStmt->fetch()['total'];
    
    // محاسبه تعداد صفحات
    $totalPages = ceil($totalResults / $limit);
    
    // دریافت نتایج
    $sql = "SELECT * FROM processed_videos $whereClause $orderClause LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
    
    // آمار جستجو
    $stats = [
        'query' => $query,
        'type' => $type,
        'total_results' => $totalResults,
        'page' => $page,
        'limit' => $limit,
        'total_pages' => $totalPages,
        'has_next' => $page < $totalPages,
        'has_prev' => $page > 1,
        'next_page' => $page < $totalPages ? $page + 1 : null,
        'prev_page' => $page > 1 ? $page - 1 : null
    ];
    
    // تنظیم header
    header('Content-Type: application/json; charset=utf-8');
    
    // خروجی JSON
    echo json_encode([
        'stats' => $stats,
        'results' => $results
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
<?php
declare(strict_types=1);

// Basic health check for GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo 'OK';
	exit;
}

require_once __DIR__ . '/../src/bootstrap.php';

use Telegram\Bot;

// Read Telegram update
$input = file_get_contents('php://input');
if (!$input) {
	Bot::logError('Empty update payload');
	http_response_code(400);
	echo 'No payload';
	exit;
}

$update = json_decode($input, true);
if (!is_array($update)) {
	Bot::logError('Invalid JSON payload: ' . substr($input, 0, 2000));
	http_response_code(400);
	echo 'Bad JSON';
	exit;
}

Bot::handleUpdate($update);

echo 'OK';
?>


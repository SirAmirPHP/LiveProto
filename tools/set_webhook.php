<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/config.php';

use Telegram\Config;

if (PHP_SAPI !== 'cli') {
	echo "Run this script from CLI.\n";
	exit(1);
}

$publicUrl = $argv[1] ?? null;
if (!$publicUrl) {
	fwrite(STDERR, "Usage: php tools/set_webhook.php https://your-domain.com/index.php\n");
	exit(1);
}

$url = 'https://api.telegram.org/bot' . Config::TELEGRAM_BOT_TOKEN . '/setWebhook';

$ch = curl_init($url);
$payload = json_encode(['url' => $publicUrl], JSON_UNESCAPED_SLASHES);
curl_setopt_array($ch, [
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
	CURLOPT_POSTFIELDS => $payload,
]);
$resp = curl_exec($ch);
$err = curl_error($ch);
$code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

if ($resp === false) {
	fwrite(STDERR, "Request failed: {$err}\n");
	exit(1);
}

echo "HTTP {$code}\n{$resp}\n";

?>


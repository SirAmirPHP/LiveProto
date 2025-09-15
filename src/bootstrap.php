<?php
declare(strict_types=1);

namespace Telegram;

require_once __DIR__ . '/config.php';

final class Http
{
	public static function postJson(string $url, array $data, int $timeout = 30): array
	{
		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
			CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
			CURLOPT_TIMEOUT => $timeout,
		]);
		$resp = curl_exec($ch);
		$err = curl_error($ch);
		$code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		curl_close($ch);
		if ($resp === false) {
			return ['ok' => false, 'error' => $err ?: 'curl_exec failed', 'status' => $code];
		}
		$decoded = json_decode($resp, true);
		if ($decoded === null) {
			return ['ok' => false, 'error' => 'Invalid JSON from ' . $url, 'status' => $code, 'raw' => $resp];
		}
		return ['ok' => $code >= 200 && $code < 300, 'status' => $code, 'data' => $decoded];
	}

	public static function get(string $url, int $timeout = 30, array $headers = []): array
	{
		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => $timeout,
			CURLOPT_HTTPHEADER => $headers,
		]);
		$resp = curl_exec($ch);
		$err = curl_error($ch);
		$code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		curl_close($ch);
		if ($resp === false) {
			return ['ok' => false, 'error' => $err ?: 'curl_exec failed', 'status' => $code];
		}
		return ['ok' => $code >= 200 && $code < 300, 'status' => $code, 'data' => $resp];
	}
}

final class Bot
{
	public static function logError(string $message): void
	{
		if (!Config::ENABLE_LOGS) {
			return;
		}
		$line = date('c') . ' ERROR ' . $message . "\n";
		@file_put_contents(__DIR__ . '/../storage/logs/app.log', $line, FILE_APPEND);
	}

	public static function logInfo(string $message): void
	{
		if (!Config::ENABLE_LOGS) {
			return;
		}
		$line = date('c') . ' INFO ' . $message . "\n";
		@file_put_contents(__DIR__ . '/../storage/logs/app.log', $line, FILE_APPEND);
	}

	public static function handleUpdate(array $update): void
	{
		$message = $update['message'] ?? $update['edited_message'] ?? null;
		if (!$message) {
			return;
		}
		$chatId = $message['chat']['id'] ?? null;
		$text = $message['text'] ?? '';
		if (!$chatId) {
			return;
		}

		if ($text === '/start') {
			self::sendMessage($chatId, "سلام! لینک ریلز اینستاگرام رو بفرست تا اسم آهنگ رو بگم.");
			return;
		}

		$reelsUrl = self::extractInstagramReelsUrl($text);
		if (!$reelsUrl) {
			self::sendMessage($chatId, "لطفاً لینک معتبر ریلز اینستاگرام ارسال کن.");
			return;
		}

		self::sendChatAction($chatId, 'typing');

		$result = self::identifyMusicFromReels($reelsUrl);
		if (!$result['ok']) {
			self::sendMessage($chatId, "متاسفانه نتونستم آهنگ رو تشخیص بدم. \n" . ($result['error'] ?? ''));
			return;
		}
		$track = $result['track'];
		$artist = $result['artist'];
		$title = trim($artist . ' - ' . $track);
		$more = $result['label'] ? "\nLabel: {$result['label']}" : '';
		$linkLine = $result['song_link'] ? "\nLink: {$result['song_link']}" : '';
		self::sendMessage($chatId, "اسم آهنگ: {$title}{$more}{$linkLine}");
	}

	private static function extractInstagramReelsUrl(string $text): ?string
	{
		$text = trim($text);
		$pattern = '#https?://(?:www\.)?instagram\.com/reel/[^\s/?]+/?#i';
		if (preg_match($pattern, $text, $m)) {
			return $m[0];
		}
		// Handle short links like https://instagram.com/p/.. or shared urls with params
		$pattern2 = '#https?://(?:www\.)?instagram\.com/(?:reel|p|tv)/[^\s]+#i';
		if (preg_match($pattern2, $text, $m2)) {
			return $m2[0];
		}
		return null;
	}

	private static function identifyMusicFromReels(string $reelsUrl): array
	{
		// Use AudD API via direct URL recognition parameter: url=<media_url>
		// We rely on AudD to fetch the media and recognize the track.
		$query = http_build_query([
			'url' => $reelsUrl,
			'api_token' => Config::AUDD_API_TOKEN,
			'return' => 'timecode,deezer,spotify,apple_music',
		]);
		$response = Http::get('https://api.audd.io/?' . $query, 60);
		if (!$response['ok']) {
			self::logError('AudD request failed: ' . ($response['error'] ?? 'unknown'));
			return ['ok' => false, 'error' => 'خطا در ارتباط با سرویس تشخیص موسیقی'];
		}
		$decoded = json_decode($response['data'], true);
		if (!is_array($decoded) || !($decoded['status'] ?? '') === 'success') {
			// Some responses may not include 'status', still try to read result
		}
		$result = $decoded['result'] ?? null;
		if (!$result) {
			return ['ok' => false, 'error' => 'نتیجه‌ای پیدا نشد'];
		}
		$artist = $result['artist'] ?? '';
		$title = $result['title'] ?? '';
		$songLink = $result['song_link'] ?? '';
		$label = $result['label'] ?? '';
		if (!$artist && !$title) {
			return ['ok' => false, 'error' => 'نتیجه‌ای پیدا نشد'];
		}
		return [
			'ok' => true,
			'artist' => $artist,
			'track' => $title,
			'song_link' => $songLink,
			'label' => $label,
		];
	}

	private static function sendMessage(int $chatId, string $text): void
	{
		$url = 'https://api.telegram.org/bot' . Config::TELEGRAM_BOT_TOKEN . '/sendMessage';
		$payload = [
			'chat_id' => $chatId,
			'text' => $text,
			'parse_mode' => 'HTML',
			'disable_web_page_preview' => true,
		];
		Http::postJson($url, $payload, 30);
	}

	private static function sendChatAction(int $chatId, string $action): void
	{
		$url = 'https://api.telegram.org/bot' . Config::TELEGRAM_BOT_TOKEN . '/sendChatAction';
		$payload = [
			'chat_id' => $chatId,
			'action' => $action,
		];
		Http::postJson($url, $payload, 15);
	}
}

?>


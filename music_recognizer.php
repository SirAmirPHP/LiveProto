<?php
require_once 'config.php';

class MusicRecognizer {
    private $apiKey;
    
    public function __construct() {
        $this->apiKey = MUSIC_RECOGNITION_API_KEY;
    }
    
    /**
     * شناسایی آهنگ از فایل ویدیو
     */
    public function recognizeMusic($videoPath) {
        try {
            // استخراج صدا از ویدیو
            $audioPath = $this->extractAudio($videoPath);
            
            // شناسایی آهنگ با استفاده از ACRCloud API
            $result = $this->recognizeWithACRCloud($audioPath);
            
            // پاک کردن فایل موقت
            if (file_exists($audioPath)) {
                unlink($audioPath);
            }
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Music recognition error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * استخراج صدا از ویدیو با استفاده از FFmpeg
     */
    private function extractAudio($videoPath) {
        $audioPath = tempnam(sys_get_temp_dir(), 'audio_') . '.wav';
        
        // دستور FFmpeg برای استخراج صدا
        $command = "ffmpeg -i " . escapeshellarg($videoPath) . 
                  " -vn -acodec pcm_s16le -ar 44100 -ac 2 " . 
                  escapeshellarg($audioPath) . " 2>&1";
        
        exec($command, $output, $returnCode);
        
        if ($returnCode !== 0 || !file_exists($audioPath)) {
            throw new Exception("خطا در استخراج صدا از ویدیو");
        }
        
        return $audioPath;
    }
    
    /**
     * شناسایی آهنگ با ACRCloud API
     */
    private function recognizeWithACRCloud($audioPath) {
        $url = 'https://identify-us-west-2.acrcloud.com/v1/identify';
        
        // تنظیمات ACRCloud
        $access_key = $this->apiKey;
        $access_secret = 'YOUR_ACRCLOUD_SECRET';
        $timestamp = time();
        $signature = base64_encode(hash_hmac('sha1', $access_key . $timestamp, $access_secret, true));
        
        $postFields = [
            'sample' => new CURLFile($audioPath, 'audio/wav', 'audio.wav'),
            'sample_bytes' => filesize($audioPath),
            'access_key' => $access_key,
            'data_type' => 'audio',
            'signature' => $signature,
            'signature_version' => '1',
            'timestamp' => $timestamp
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("خطا در ارتباط با سرویس شناسایی آهنگ");
        }
        
        $data = json_decode($response, true);
        
        if (isset($data['status']['code']) && $data['status']['code'] === 0) {
            $music = $data['metadata']['music'][0];
            return [
                'title' => $music['title'],
                'artist' => $music['artists'][0]['name'],
                'album' => $music['album']['name'] ?? '',
                'confidence' => $music['score'] ?? 0,
                'duration' => $music['duration_ms'] ?? 0,
                'release_date' => $music['release_date'] ?? ''
            ];
        } else {
            throw new Exception("آهنگ شناسایی نشد");
        }
    }
    
    /**
     * شناسایی آهنگ با استفاده از Shazam API (جایگزین)
     */
    public function recognizeWithShazam($videoPath) {
        try {
            $audioPath = $this->extractAudio($videoPath);
            
            // تبدیل به فرمت مناسب برای Shazam
            $wavPath = tempnam(sys_get_temp_dir(), 'shazam_') . '.wav';
            $command = "ffmpeg -i " . escapeshellarg($audioPath) . 
                      " -ar 16000 -ac 1 " . escapeshellarg($wavPath) . " 2>&1";
            
            exec($command, $output, $returnCode);
            
            if ($returnCode !== 0) {
                throw new Exception("خطا در تبدیل فایل صوتی");
            }
            
            // ارسال به Shazam API
            $result = $this->sendToShazamAPI($wavPath);
            
            // پاک کردن فایل‌های موقت
            if (file_exists($audioPath)) unlink($audioPath);
            if (file_exists($wavPath)) unlink($wavPath);
            
            return $result;
            
        } catch (Exception $e) {
            error_log("Shazam recognition error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * ارسال فایل به Shazam API
     */
    private function sendToShazamAPI($audioPath) {
        $url = 'https://shazam.p.rapidapi.com/songs/detect';
        
        $headers = [
            'X-RapidAPI-Key: ' . $this->apiKey,
            'X-RapidAPI-Host: shazam.p.rapidapi.com'
        ];
        
        $postFields = [
            'audio' => new CURLFile($audioPath, 'audio/wav', 'audio.wav')
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("خطا در ارتباط با Shazam API");
        }
        
        $data = json_decode($response, true);
        
        if (isset($data['track'])) {
            $track = $data['track'];
            return [
                'title' => $track['title'],
                'artist' => $track['subtitle'],
                'album' => $track['sections'][0]['metadata'][0]['text'] ?? '',
                'confidence' => $track['hub']['actions'][0]['confidence'] ?? 0,
                'duration' => $track['duration'] ?? 0,
                'release_date' => $track['release_date'] ?? ''
            ];
        } else {
            throw new Exception("آهنگ شناسایی نشد");
        }
    }
}
?>
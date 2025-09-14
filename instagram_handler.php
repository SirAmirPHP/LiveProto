<?php
require_once 'config.php';

class InstagramHandler {
    private $apiKey;
    
    public function __construct() {
        $this->apiKey = INSTAGRAM_API_KEY;
    }
    
    /**
     * استخراج لینک ویدیو از URL ریلز اینستاگرام
     */
    public function extractVideoFromReels($url) {
        try {
            // بررسی صحت URL
            if (!$this->isValidInstagramUrl($url)) {
                throw new Exception("لینک معتبر نیست");
            }
            
            // استخراج shortcode از URL
            $shortcode = $this->extractShortcode($url);
            if (!$shortcode) {
                throw new Exception("نمی‌توان shortcode را استخراج کرد");
            }
            
            // دریافت اطلاعات پست از Instagram API
            $mediaData = $this->getMediaData($shortcode);
            
            if (!$mediaData || $mediaData['media_type'] !== 'VIDEO') {
                throw new Exception("این پست یک ویدیو نیست");
            }
            
            return [
                'video_url' => $mediaData['video_url'],
                'thumbnail_url' => $mediaData['thumbnail_url'],
                'caption' => $mediaData['caption'] ?? '',
                'shortcode' => $shortcode
            ];
            
        } catch (Exception $e) {
            error_log("Instagram extraction error: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * بررسی صحت URL اینستاگرام
     */
    private function isValidInstagramUrl($url) {
        $pattern = '/^https?:\/\/(www\.)?instagram\.com\/(p|reel)\/[A-Za-z0-9_-]+\/?/';
        return preg_match($pattern, $url);
    }
    
    /**
     * استخراج shortcode از URL
     */
    private function extractShortcode($url) {
        $pattern = '/instagram\.com\/(?:p|reel)\/([A-Za-z0-9_-]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return false;
    }
    
    /**
     * دریافت اطلاعات پست از Instagram API
     */
    private function getMediaData($shortcode) {
        // استفاده از Instagram Basic Display API
        $apiUrl = "https://graph.instagram.com/{$shortcode}?fields=id,media_type,media_url,thumbnail_url,caption&access_token={$this->apiKey}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("خطا در دریافت اطلاعات از اینستاگرام");
        }
        
        $data = json_decode($response, true);
        
        if (isset($data['error'])) {
            throw new Exception("خطای API: " . $data['error']['message']);
        }
        
        return $data;
    }
    
    /**
     * دانلود ویدیو از URL
     */
    public function downloadVideo($videoUrl, $outputPath) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $videoUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            
            $videoData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode !== 200 || !$videoData) {
                throw new Exception("خطا در دانلود ویدیو");
            }
            
            if (file_put_contents($outputPath, $videoData) === false) {
                throw new Exception("خطا در ذخیره ویدیو");
            }
            
            return true;
            
        } catch (Exception $e) {
            error_log("Video download error: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
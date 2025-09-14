# Telegram Müzik Tanıma Botu

Bu Telegram botu Instagram Reels'den müzik tanıyabilir. Kullanıcılar Instagram Reels linklerini gönderebilir ve bot şarkı adını ve sanatçıyı tanıyacaktır.

## Özellikler

- 🎵 Instagram Reels'den müzik tanıma
- 🎤 Sanatçı ve şarkı adını gösterme
- 💿 Albüm bilgilerini gösterme (varsa)
- 📅 Çıkış yılını gösterme
- 🎯 Güven yüzdesini gösterme
- 💾 Veritabanında geçmişi kaydetme
- 🔒 Yüksek güvenlik ve veri koruması

## Gereksinimler

- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- FFmpeg (videodan ses çıkarmak için)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL Sertifikası (webhook için)

## Kurulum

### 1. Dosyaları Yükle

Projenin tüm dosyalarını cPanel hostuna yükleyin.

### 2. Kurulumu Çalıştır

Gereksinimleri kontrol etmek için `install.php`'yi tarayıcıda çalıştırın.

### 3. Veritabanını Ayarla

1. MySQL veritabanı oluştur
2. `config.php`'yi düzenle ve veritabanı bilgilerini gir

### 4. Telegram Botu Oluştur

1. Telegram'da [@BotFather](https://t.me/botfather) ile sohbet et
2. `/newbot` komutunu gönder
3. Bot adı ve kullanıcı adı seç
4. Bot token'ını kopyala
5. Token'ı `config.php`'ye gir

### 5. API'leri Ayarla

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/)'a git
2. Yeni uygulama oluştur
3. Instagram Basic Display ekle
4. API anahtarı al

#### ACRCloud API (Müzik Tanıma)
1. [ACRCloud](https://www.acrcloud.com/)'a git
2. Hesap oluştur
3. API anahtarı al

### 6. Webhook'u Ayarla

`setup.php`'yi çalıştır:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Botu Test Et

`test.php`'yi çalıştır:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Kullanım

1. Telegram'da botu bul
2. `/start` komutunu gönder
3. Instagram Reels linkini gönder
4. Müzik tanımayı bekle

## Dosya Yapısı

```
/
├── config.php              # Ana yapılandırma
├── database.php            # Veritabanı sınıfı
├── instagram_handler.php   # Instagram işleme
├── music_recognizer.php    # Müzik tanıma
├── telegram_bot.php        # Telegram bot sınıfı
├── webhook.php            # webhook işleyicisi
├── setup.php              # Ayarlar
├── test.php               # Bot testi
├── install.php            # Kurulum
├── index.php              # Ana sayfa
└── README.md              # Dokümantasyon
```

## Desteklenen API'ler

### Müzik Tanıma
- **ACRCloud**: Ana müzik tanıma servisi
- **Shazam**: ACRCloud alternatifi

### Instagram
- **Instagram Basic Display API**: Instagram içeriğine erişim

## Gelişmiş Ayarlar

### Dosya Sınırları
`.htaccess` dosyasında:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Güvenlik
- `config.php`'yi genel erişimden koru
- Geçerli SSL sertifikası kullan
- Güçlü şifreler seç

## Sorun Giderme

### Yaygın Sorunlar

1. **Veritabanı Bağlantı Hatası**
   - Veritabanı bilgilerini kontrol et
   - Veritabanının oluşturulduğundan emin ol

2. **FFmpeg Hatası**
   - FFmpeg'i yükle
   - Kodda FFmpeg yolunu ayarla

3. **API Hatası**
   - API anahtarlarını kontrol et
   - API sınırlarını göz önünde bulundur

4. **Webhook Hatası**
   - SSL sertifikasını kontrol et
   - Doğru webhook URL'sini ayarla

## Destek

Destek ve hata raporları için lütfen geliştirici ile iletişime geçin.

## Lisans

Bu proje MIT Lisansı altında lisanslanmıştır.
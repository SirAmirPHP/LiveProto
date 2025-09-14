# 텔레그램 음악 인식 봇

이 텔레그램 봇은 Instagram Reels에서 음악을 식별할 수 있습니다. 사용자는 Instagram Reels 링크를 보낼 수 있고 봇은 곡명과 아티스트를 식별합니다.

## 기능

- 🎵 Instagram Reels에서 음악 인식
- 🎤 아티스트와 곡명 표시
- 💿 앨범 정보 표시 (사용 가능한 경우)
- 📅 출시 연도 표시
- 🎯 신뢰도 백분율 표시
- 💾 데이터베이스에 기록 저장
- 🔒 높은 보안 및 데이터 보호

## 요구사항

- PHP 7.4 이상
- MySQL 5.7 이상
- FFmpeg (비디오에서 오디오 추출용)
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL 인증서 (webhook용)

## 설치

### 1. 파일 업로드

프로젝트의 모든 파일을 cPanel 호스트에 업로드합니다.

### 2. 설치 실행

`install.php`를 브라우저에서 실행하여 요구사항을 확인합니다.

### 3. 데이터베이스 설정

1. MySQL 데이터베이스 생성
2. `config.php` 편집 및 데이터베이스 정보 입력

### 4. 텔레그램 봇 생성

1. 텔레그램에서 [@BotFather](https://t.me/botfather)와 채팅
2. `/newbot` 명령어 전송
3. 봇 이름과 사용자명 선택
4. 봇 토큰 복사
5. 토큰을 `config.php`에 입력

### 5. API 설정

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/) 방문
2. 새 애플리케이션 생성
3. Instagram Basic Display 추가
4. API 키 획득

#### ACRCloud API (음악 인식)
1. [ACRCloud](https://www.acrcloud.com/) 방문
2. 계정 생성
3. API 키 획득

### 6. Webhook 설정

`setup.php` 실행:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. 봇 테스트

`test.php` 실행:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## 사용법

1. 텔레그램에서 봇 찾기
2. `/start` 명령어 전송
3. Instagram Reels 링크 전송
4. 음악 인식 대기

## 파일 구조

```
/
├── config.php              # 메인 설정
├── database.php            # 데이터베이스 클래스
├── instagram_handler.php   # Instagram 처리
├── music_recognizer.php    # 음악 인식
├── telegram_bot.php        # 텔레그램 봇 클래스
├── webhook.php            # webhook 핸들러
├── setup.php              # 설정
├── test.php               # 봇 테스트
├── install.php            # 설치
├── index.php              # 메인 페이지
└── README.md              # 문서
```

## 지원되는 API

### 음악 인식
- **ACRCloud**: 메인 음악 인식 서비스
- **Shazam**: ACRCloud 대안

### Instagram
- **Instagram Basic Display API**: Instagram 콘텐츠 접근

## 고급 설정

### 파일 제한
`.htaccess` 파일에서:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### 보안
- `config.php`를 공개 액세스로부터 보호
- 유효한 SSL 인증서 사용
- 강력한 비밀번호 선택

## 문제 해결

### 일반적인 문제

1. **데이터베이스 연결 오류**
   - 데이터베이스 정보 확인
   - 데이터베이스가 생성되었는지 확인

2. **FFmpeg 오류**
   - FFmpeg 설치
   - 코드에서 FFmpeg 경로 설정

3. **API 오류**
   - API 키 확인
   - API 제한 고려

4. **Webhook 오류**
   - SSL 인증서 확인
   - 올바른 webhook URL 설정

## 지원

지원 및 버그 리포트는 개발자에게 문의하세요.

## 라이선스

이 프로젝트는 MIT 라이선스 하에 라이선스되어 있습니다.
# テレグラム音楽認識ボット

このテレグラムボットはInstagram Reelsから音楽を識別できます。ユーザーはInstagram Reelsのリンクを送信でき、ボットは曲名とアーティストを識別します。

## 機能

- 🎵 Instagram Reelsからの音楽認識
- 🎤 アーティスト名と曲名の表示
- 💿 アルバム情報の表示（利用可能な場合）
- 📅 リリース年の表示
- 🎯 信頼度のパーセンテージ表示
- 💾 データベースでの履歴保存
- 🔒 高いセキュリティとデータ保護

## 要件

- PHP 7.4以上
- MySQL 5.7以上
- FFmpeg（ビデオからオーディオを抽出するため）
- PHP Extensions: curl, json, pdo, pdo_mysql
- SSL証明書（webhook用）

## インストール

### 1. ファイルのアップロード

プロジェクトのすべてのファイルをcPanelホストにアップロードします。

### 2. インストールの実行

`install.php`をブラウザで実行して要件を確認します。

### 3. データベースの設定

1. MySQLデータベースを作成
2. `config.php`を編集してデータベース情報を入力

### 4. テレグラムボットの作成

1. テレグラムで[@BotFather](https://t.me/botfather)とチャット
2. `/newbot`コマンドを送信
3. ボット名とユーザー名を選択
4. ボットトークンをコピー
5. トークンを`config.php`に入力

### 5. APIの設定

#### Instagram Basic Display API
1. [Facebook Developers](https://developers.facebook.com/)にアクセス
2. 新しいアプリケーションを作成
3. Instagram Basic Displayを追加
4. APIキーを取得

#### ACRCloud API（音楽認識）
1. [ACRCloud](https://www.acrcloud.com/)にアクセス
2. アカウントを作成
3. APIキーを取得

### 6. Webhookの設定

`setup.php`を実行：

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. ボットのテスト

`test.php`を実行：

```
https://yourdomain.com/test.php?password=your_admin_password
```

## 使用方法

1. テレグラムでボットを見つける
2. `/start`コマンドを送信
3. Instagram Reelsのリンクを送信
4. 音楽認識を待つ

## ファイル構造

```
/
├── config.php              # メイン設定
├── database.php            # データベースクラス
├── instagram_handler.php   # Instagram処理
├── music_recognizer.php    # 音楽認識
├── telegram_bot.php        # テレグラムボットクラス
├── webhook.php            # webhookハンドラー
├── setup.php              # 設定
├── test.php               # ボットテスト
├── install.php            # インストール
├── index.php              # メインページ
└── README.md              # ドキュメント
```

## サポートされているAPI

### 音楽認識
- **ACRCloud**: メイン音楽認識サービス
- **Shazam**: ACRCloudの代替

### Instagram
- **Instagram Basic Display API**: Instagramコンテンツへのアクセス

## 高度な設定

### ファイル制限
`.htaccess`ファイルで：
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### セキュリティ
- `config.php`をパブリックアクセスから保護
- 有効なSSL証明書を使用
- 強力なパスワードを選択

## トラブルシューティング

### 一般的な問題

1. **データベース接続エラー**
   - データベース情報を確認
   - データベースが作成されていることを確認

2. **FFmpegエラー**
   - FFmpegをインストール
   - コードでFFmpegパスを設定

3. **APIエラー**
   - APIキーを確認
   - API制限を考慮

4. **Webhookエラー**
   - SSL証明書を確認
   - 正しいwebhook URLを設定

## サポート

サポートとバグレポートについては、開発者にお問い合わせください。

## ライセンス

このプロジェクトはMITライセンスの下でライセンスされています。
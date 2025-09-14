# 电报音乐识别机器人

这个电报机器人可以从Instagram Reels识别音乐。用户可以发送Instagram Reels链接，机器人将识别歌曲名称和艺术家。

## 功能

- 🎵 从Instagram Reels识别音乐
- 🎤 显示艺术家和歌曲名称
- 💿 显示专辑信息（如果可用）
- 📅 显示发行年份
- 🎯 显示置信度百分比
- 💾 在数据库中保存历史记录
- 🔒 高安全性和数据保护

## 要求

- PHP 7.4或更高版本
- MySQL 5.7或更高版本
- FFmpeg（用于从视频中提取音频）
- PHP扩展：curl, json, pdo, pdo_mysql
- SSL证书（用于webhook）

## 安装

### 1. 上传文件

将项目的所有文件上传到您的cPanel主机。

### 2. 运行安装

在浏览器中运行`install.php`以检查要求。

### 3. 设置数据库

1. 创建MySQL数据库
2. 编辑`config.php`并输入数据库信息

### 4. 创建电报机器人

1. 在电报上与[@BotFather](https://t.me/botfather)聊天
2. 发送`/newbot`命令
3. 选择机器人名称和用户名
4. 复制机器人令牌
5. 在`config.php`中输入令牌

### 5. 设置API

#### Instagram Basic Display API
1. 访问[Facebook Developers](https://developers.facebook.com/)
2. 创建新应用程序
3. 添加Instagram Basic Display
4. 获取API密钥

#### ACRCloud API（音乐识别）
1. 访问[ACRCloud](https://www.acrcloud.com/)
2. 创建账户
3. 获取API密钥

### 6. 设置Webhook

运行`setup.php`：

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. 测试机器人

运行`test.php`：

```
https://yourdomain.com/test.php?password=your_admin_password
```

## 使用方法

1. 在电报上找到机器人
2. 发送`/start`命令
3. 发送Instagram Reels链接
4. 等待音乐识别

## 文件结构

```
/
├── config.php              # 主配置
├── database.php            # 数据库类
├── instagram_handler.php   # Instagram处理
├── music_recognizer.php    # 音乐识别
├── telegram_bot.php        # 电报机器人类
├── webhook.php            # webhook处理器
├── setup.php              # 设置
├── test.php               # 机器人测试
├── install.php            # 安装
├── index.php              # 主页面
└── README.md              # 文档
```

## 支持的API

### 音乐识别
- **ACRCloud**: 主要音乐识别服务
- **Shazam**: ACRCloud的替代方案

### Instagram
- **Instagram Basic Display API**: 访问Instagram内容

## 高级设置

### 文件限制
在`.htaccess`文件中：
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### 安全性
- 保护`config.php`免受公共访问
- 使用有效的SSL证书
- 选择强密码

## 故障排除

### 常见问题

1. **数据库连接错误**
   - 检查数据库信息
   - 确保数据库已创建

2. **FFmpeg错误**
   - 安装FFmpeg
   - 在代码中设置FFmpeg路径

3. **API错误**
   - 检查API密钥
   - 考虑API限制

4. **Webhook错误**
   - 检查SSL证书
   - 设置正确的webhook URL

## 支持

如需支持和错误报告，请联系开发者。

## 许可证

此项目在MIT许可证下获得许可。
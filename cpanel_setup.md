# راهنمای نصب در cPanel
## cPanel Installation Guide

راهنمای کامل برای نصب و راه‌اندازی ربات مانیتور گیفت تلگرام در هاست cPanel.

### پیش‌نیازها 📋

- هاست cPanel با پشتیبانی از Python 3.7+
- دسترسی به Terminal یا SSH
- حساب کاربری تلگرام
- ربات تلگرام (از @BotFather)

### مرحله 1: آپلود فایل‌ها 📁

1. **آپلود فایل‌ها به هاست:**
   ```bash
   # آپلود تمام فایل‌ها به پوشه public_html
   scp -r * username@yourdomain.com:public_html/gift_monitor/
   ```

2. **یا از طریق File Manager در cPanel:**
   - وارد cPanel شوید
   - File Manager را باز کنید
   - به پوشه `public_html` بروید
   - پوشه `gift_monitor` ایجاد کنید
   - تمام فایل‌ها را آپلود کنید

### مرحله 2: تنظیم دسترسی‌ها 🔐

1. **تنظیم دسترسی فایل‌ها:**
   ```bash
   chmod 755 gift_monitor/
   chmod +x gift_monitor/*.sh
   chmod +x gift_monitor/bot.py
   ```

2. **ایجاد پوشه‌های مورد نیاز:**
   ```bash
   mkdir -p gift_monitor/logs
   mkdir -p gift_monitor/data
   chmod 755 gift_monitor/logs
   chmod 755 gift_monitor/data
   ```

### مرحله 3: نصب Python و وابستگی‌ها 🐍

1. **بررسی نسخه Python:**
   ```bash
   python3 --version
   # یا
   python --version
   ```

2. **نصب وابستگی‌ها:**
   ```bash
   cd gift_monitor/
   pip3 install -r requirements.txt --user
   # یا
   pip install -r requirements.txt --user
   ```

### مرحله 4: تنظیمات ربات ⚙️

1. **ایجاد فایل .env:**
   ```bash
   cp .env.example .env
   nano .env
   ```

2. **ویرایش فایل .env:**
   ```env
   API_ID=your_api_id_here
   API_HASH=your_api_hash_here
   BOT_TOKEN=your_bot_token_here
   GIFT_CHANNELS=@gift_channel_1,@gift_channel_2
   TARGET_CHANNEL=@your_target_channel
   CHECK_INTERVAL=30
   MAX_RETRIES=3
   DEBUG=False
   ```

### مرحله 5: تست ربات 🧪

1. **اجرای تست:**
   ```bash
   ./run.sh check
   ```

2. **اجرای موقت:**
   ```bash
   ./run.sh start
   ```

3. **اجرای در پس‌زمینه:**
   ```bash
   ./run.sh background
   ```

### مرحله 6: تنظیم Cron Job ⏰

1. **وارد cPanel شوید**
2. **Cron Jobs را باز کنید**
3. **Cron Job جدید ایجاد کنید:**

   ```bash
   # هر 5 دقیقه اجرا شود
   */5 * * * * cd /home/username/public_html/gift_monitor && python3 bot.py
   
   # یا هر دقیقه
   * * * * * cd /home/username/public_html/gift_monitor && python3 bot.py
   ```

4. **ذخیره و فعال کنید**

### مرحله 7: اجرای دائمی 🔄

#### روش 1: استفاده از nohup
```bash
cd gift_monitor/
nohup python3 bot.py > logs/bot.log 2>&1 &
echo $! > bot.pid
```

#### روش 2: استفاده از screen
```bash
screen -S gift_bot
cd gift_monitor/
python3 bot.py
# Ctrl+A, D برای خارج شدن
```

#### روش 3: استفاده از systemd (اگر دسترسی دارید)
```bash
# ایجاد سرویس
sudo nano /etc/systemd/system/gift-bot.service
```

محتوای فایل سرویس:
```ini
[Unit]
Description=Telegram Gift Monitor Bot
After=network.target

[Service]
Type=simple
User=username
WorkingDirectory=/home/username/public_html/gift_monitor
ExecStart=/usr/bin/python3 bot.py
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

فعال‌سازی سرویس:
```bash
sudo systemctl enable gift-bot.service
sudo systemctl start gift-bot.service
```

### مرحله 8: مانیتورینگ 📊

1. **مشاهده لاگ‌ها:**
   ```bash
   tail -f logs/bot.log
   ```

2. **بررسی وضعیت:**
   ```bash
   ./run.sh status
   ```

3. **توقف ربات:**
   ```bash
   ./run.sh stop
   ```

### عیب‌یابی مشکلات رایج 🔧

#### مشکل 1: Python یافت نشد
```bash
# بررسی مسیر Python
which python3
which python

# اضافه کردن به PATH
export PATH=$PATH:/usr/local/bin
```

#### مشکل 2: ماژول‌ها یافت نشدند
```bash
# نصب مجدد وابستگی‌ها
pip3 install -r requirements.txt --user --upgrade

# بررسی مسیر Python
python3 -c "import sys; print(sys.path)"
```

#### مشکل 3: دسترسی به فایل‌ها
```bash
# تنظیم مالکیت
chown -R username:username gift_monitor/
chmod -R 755 gift_monitor/
```

#### مشکل 4: خطای API
- بررسی صحت `API_ID` و `API_HASH`
- بررسی صحت `BOT_TOKEN`
- اطمینان از دسترسی ربات به کانال‌ها

### نکات امنیتی 🔒

1. **فایل .env را محافظت کنید:**
   ```bash
   chmod 600 .env
   ```

2. **فایل‌های session را محافظت کنید:**
   ```bash
   chmod 600 *.session
   ```

3. **لاگ‌ها را به طور منظم پاک کنید:**
   ```bash
   # پاک کردن لاگ‌های قدیمی
   find logs/ -name "*.log" -mtime +30 -delete
   ```

### پشتیبانی 💬

در صورت بروز مشکل:

1. **لاگ‌ها را بررسی کنید:**
   ```bash
   grep "ERROR" logs/bot.log
   ```

2. **تنظیمات را بررسی کنید:**
   ```bash
   ./run.sh check
   ```

3. **ربات را راه‌اندازی مجدد کنید:**
   ```bash
   ./run.sh restart
   ```

### به‌روزرسانی 🔄

1. **پشتیبان‌گیری:**
   ```bash
   cp -r gift_monitor/ gift_monitor_backup/
   ```

2. **آپلود فایل‌های جدید**

3. **نصب وابستگی‌های جدید:**
   ```bash
   pip3 install -r requirements.txt --user --upgrade
   ```

4. **راه‌اندازی مجدد:**
   ```bash
   ./run.sh restart
   ```

---

**نکته مهم**: این راهنما برای هاست‌های cPanel استاندارد نوشته شده است. ممکن است در برخی هاست‌ها تنظیمات متفاوت باشد.
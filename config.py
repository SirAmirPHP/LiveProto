#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Configuration file for Telegram Gift Monitor Bot
فایل تنظیمات برای ربات مانیتور گیفت تلگرام
"""

import os
from typing import List

class Config:
    """کلاس تنظیمات ربات"""
    
    def __init__(self):
        # تنظیمات API تلگرام
        self.API_ID = self._get_env_var('API_ID', '')
        self.API_HASH = self._get_env_var('API_HASH', '')
        self.BOT_TOKEN = self._get_env_var('BOT_TOKEN', '')
        
        # تنظیمات کانال‌ها
        self.GIFT_CHANNELS = self._get_gift_channels()
        self.TARGET_CHANNEL = self._get_env_var('TARGET_CHANNEL', '')
        
        # تنظیمات عمومی
        self.CHECK_INTERVAL = int(self._get_env_var('CHECK_INTERVAL', '30'))  # ثانیه
        self.MAX_RETRIES = int(self._get_env_var('MAX_RETRIES', '3'))
        self.DEBUG = self._get_env_var('DEBUG', 'False').lower() == 'true'
        
        # تنظیمات فایل‌ها
        self.LOG_FILE = self._get_env_var('LOG_FILE', 'gift_monitor.log')
        self.SESSION_FILE = self._get_env_var('SESSION_FILE', 'gift_monitor_session.session')
        self.PROCESSED_FILE = self._get_env_var('PROCESSED_FILE', 'processed_gifts.json')
        
        # اعتبارسنجی تنظیمات
        self._validate_config()
    
    def _get_env_var(self, key: str, default: str = '') -> str:
        """دریافت متغیر محیطی"""
        return os.environ.get(key, default)
    
    def _get_gift_channels(self) -> List[str]:
        """دریافت لیست کانال‌های گیفت"""
        channels_str = self._get_env_var('GIFT_CHANNELS', '')
        if channels_str:
            # تقسیم کانال‌ها با کاما
            channels = [ch.strip() for ch in channels_str.split(',')]
            return [ch for ch in channels if ch]
        else:
            # کانال‌های پیش‌فرض
            return [
                '@gift_channel_1',  # جایگزین کنید با کانال‌های واقعی
                '@gift_channel_2',
                '@gift_channel_3'
            ]
    
    def _validate_config(self):
        """اعتبارسنجی تنظیمات"""
        required_vars = {
            'API_ID': self.API_ID,
            'API_HASH': self.API_HASH,
            'BOT_TOKEN': self.BOT_TOKEN,
            'TARGET_CHANNEL': self.TARGET_CHANNEL
        }
        
        missing_vars = []
        for var_name, var_value in required_vars.items():
            if not var_value:
                missing_vars.append(var_name)
        
        if missing_vars:
            raise ValueError(
                f"متغیرهای زیر باید تنظیم شوند: {', '.join(missing_vars)}\n"
                f"لطفاً فایل .env را ایجاد کنید یا متغیرهای محیطی را تنظیم کنید."
            )
        
        if not self.GIFT_CHANNELS:
            raise ValueError("حداقل یک کانال گیفت باید تعریف شود")
    
    def get_gift_keywords(self) -> List[str]:
        """کلمات کلیدی برای تشخیص گیفت"""
        return [
            'gift', 'گیفت', 'present', 'هدیه', 'giveaway', 'give away',
            'free', 'رایگان', 'promo', 'promotion', 'تخفیف', 'discount',
            'special offer', 'پیشنهاد ویژه', 'bonus', 'پاداش'
        ]
    
    def get_message_template(self) -> str:
        """قالب پیام گیفت"""
        return """
🎁 <b>گیفت جدید در تلگرام</b> 🎁

<b>عنوان:</b> {title}

<b>کانال:</b> 📢 {channel_name}

<b>زمان:</b> ⏰ {date}

<b>توضیحات:</b>
{description}

<b>لینک پیام اصلی:</b>
{link}

#Gift #Giveaway #Telegram #هدیه #گیفت
"""
    
    def to_dict(self) -> dict:
        """تبدیل تنظیمات به دیکشنری"""
        return {
            'API_ID': self.API_ID,
            'API_HASH': self.API_HASH,
            'BOT_TOKEN': '***' + self.BOT_TOKEN[-4:] if self.BOT_TOKEN else '',
            'GIFT_CHANNELS': self.GIFT_CHANNELS,
            'TARGET_CHANNEL': self.TARGET_CHANNEL,
            'CHECK_INTERVAL': self.CHECK_INTERVAL,
            'MAX_RETRIES': self.MAX_RETRIES,
            'DEBUG': self.DEBUG,
            'LOG_FILE': self.LOG_FILE,
            'SESSION_FILE': self.SESSION_FILE,
            'PROCESSED_FILE': self.PROCESSED_FILE
        }

# نمونه پیش‌فرض تنظیمات
DEFAULT_CONFIG = {
    'API_ID': '',
    'API_HASH': '',
    'BOT_TOKEN': '',
    'GIFT_CHANNELS': '@gift_channel_1,@gift_channel_2',
    'TARGET_CHANNEL': '@your_target_channel',
    'CHECK_INTERVAL': 30,
    'MAX_RETRIES': 3,
    'DEBUG': False,
    'LOG_FILE': 'gift_monitor.log',
    'SESSION_FILE': 'gift_monitor_session.session',
    'PROCESSED_FILE': 'processed_gifts.json'
}

def create_env_file():
    """ایجاد فایل .env نمونه"""
    env_content = """# تنظیمات ربات مانیتور گیفت تلگرام
# Telegram Gift Monitor Bot Configuration

# API اطلاعات تلگرام (از my.telegram.org دریافت کنید)
API_ID=your_api_id_here
API_HASH=your_api_hash_here

# توکن ربات (از @BotFather دریافت کنید)
BOT_TOKEN=your_bot_token_here

# کانال‌های گیفت (با کاما جدا کنید)
GIFT_CHANNELS=@gift_channel_1,@gift_channel_2,@gift_channel_3

# کانال هدف برای ارسال گیفت‌ها
TARGET_CHANNEL=@your_target_channel

# تنظیمات اختیاری
CHECK_INTERVAL=30
MAX_RETRIES=3
DEBUG=False
LOG_FILE=gift_monitor.log
SESSION_FILE=gift_monitor_session.session
PROCESSED_FILE=processed_gifts.json
"""
    
    with open('.env', 'w', encoding='utf-8') as f:
        f.write(env_content)
    
    print("فایل .env ایجاد شد. لطفاً اطلاعات خود را در آن وارد کنید.")

if __name__ == "__main__":
    # ایجاد فایل .env نمونه
    create_env_file()
    print("فایل .env نمونه ایجاد شد!")
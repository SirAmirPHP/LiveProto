#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Telegram Gift Monitor Bot
استخراج و ارسال اطلاعات گیفت‌های تلگرام به کانال
"""

import asyncio
import logging
import os
import sys
from datetime import datetime
from typing import List, Dict, Any
import json

# اضافه کردن مسیر فعلی به sys.path برای import کردن ماژول‌های محلی
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

try:
    from telethon import TelegramClient, events
    from telethon.tl.types import MessageMediaDocument, DocumentAttributeSticker
    from telethon.tl.functions.messages import GetStickerSetRequest
    from telethon.tl.types import InputStickerSetID
    from telethon.errors import FloodWaitError, ChatAdminRequiredError
except ImportError as e:
    print(f"خطا در import کردن telethon: {e}")
    print("لطفاً ابتدا requirements.txt را نصب کنید: pip install -r requirements.txt")
    sys.exit(1)

from config import Config

# تنظیم logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('gift_monitor.log', encoding='utf-8'),
        logging.StreamHandler(sys.stdout)
    ]
)
logger = logging.getLogger(__name__)

class TelegramGiftMonitor:
    def __init__(self):
        self.client = None
        self.config = Config()
        self.processed_gifts = set()  # برای جلوگیری از ارسال مجدد
        self.gift_channels = self.config.GIFT_CHANNELS
        self.target_channel = self.config.TARGET_CHANNEL
        
    async def start(self):
        """شروع ربات"""
        try:
            # ایجاد کلاینت تلگرام
            self.client = TelegramClient(
                'gift_monitor_session',
                self.config.API_ID,
                self.config.API_HASH
            )
            
            await self.client.start(bot_token=self.config.BOT_TOKEN)
            logger.info("ربات با موفقیت شروع شد")
            
            # ثبت event handler برای پیام‌های جدید
            @self.client.on(events.NewMessage(chats=self.gift_channels))
            async def handle_new_message(event):
                await self.process_message(event)
            
            logger.info(f"در حال مانیتور کردن کانال‌های گیفت: {self.gift_channels}")
            logger.info(f"گیفت‌ها به کانال {self.target_channel} ارسال می‌شوند")
            
            # نگه داشتن ربات در حال اجرا
            await self.client.run_until_disconnected()
            
        except Exception as e:
            logger.error(f"خطا در شروع ربات: {e}")
            raise
    
    async def process_message(self, event):
        """پردازش پیام جدید و استخراج اطلاعات گیفت"""
        try:
            message = event.message
            message_id = f"{event.chat_id}_{message.id}"
            
            # بررسی اینکه آیا این پیام قبلاً پردازش شده یا نه
            if message_id in self.processed_gifts:
                return
            
            # بررسی اینکه آیا پیام حاوی گیفت است یا نه
            if not await self.is_gift_message(message):
                return
            
            # استخراج اطلاعات گیفت
            gift_info = await self.extract_gift_info(message)
            if not gift_info:
                return
            
            # ارسال به کانال هدف
            await self.send_gift_to_channel(gift_info, message)
            
            # اضافه کردن به لیست پیام‌های پردازش شده
            self.processed_gifts.add(message_id)
            
            logger.info(f"گیفت جدید پردازش شد: {gift_info.get('title', 'بدون عنوان')}")
            
        except Exception as e:
            logger.error(f"خطا در پردازش پیام: {e}")
    
    async def is_gift_message(self, message) -> bool:
        """بررسی اینکه آیا پیام حاوی گیفت است یا نه"""
        try:
            # بررسی متن پیام برای کلمات کلیدی گیفت
            gift_keywords = [
                'gift', 'گیفت', 'present', 'هدیه', 'giveaway', 'give away',
                'free', 'رایگان', 'promo', 'promotion', 'تخفیف', 'discount'
            ]
            
            message_text = message.text or ""
            message_text_lower = message_text.lower()
            
            # بررسی وجود کلمات کلیدی
            for keyword in gift_keywords:
                if keyword in message_text_lower:
                    return True
            
            # بررسی وجود استیکر یا فایل گیفت
            if message.media:
                if isinstance(message.media, MessageMediaDocument):
                    document = message.media.document
                    if document:
                        # بررسی attributes برای گیفت
                        for attr in document.attributes:
                            if hasattr(attr, 'stickerset') and attr.stickerset:
                                return True
                            if hasattr(attr, 'file_name'):
                                filename = attr.file_name.lower()
                                if any(keyword in filename for keyword in ['gift', 'giveaway', 'promo']):
                                    return True
            
            return False
            
        except Exception as e:
            logger.error(f"خطا در بررسی گیفت بودن پیام: {e}")
            return False
    
    async def extract_gift_info(self, message) -> Dict[str, Any]:
        """استخراج اطلاعات گیفت از پیام"""
        try:
            gift_info = {
                'title': 'گیفت جدید',
                'description': '',
                'channel_name': '',
                'message_id': message.id,
                'date': message.date,
                'media': None,
                'original_text': message.text or ''
            }
            
            # استخراج نام کانال
            try:
                chat = await message.get_chat()
                gift_info['channel_name'] = getattr(chat, 'title', 'کانال ناشناس')
            except:
                gift_info['channel_name'] = 'کانال ناشناس'
            
            # استخراج عنوان از متن پیام
            if message.text:
                lines = message.text.split('\n')
                for line in lines[:3]:  # بررسی 3 خط اول
                    line = line.strip()
                    if len(line) > 10 and not line.startswith('http'):
                        gift_info['title'] = line
                        break
                
                # استخراج توضیحات
                if len(message.text) > 100:
                    gift_info['description'] = message.text[:200] + "..."
                else:
                    gift_info['description'] = message.text
            
            # استخراج اطلاعات رسانه
            if message.media:
                gift_info['media'] = {
                    'type': type(message.media).__name__,
                    'has_document': isinstance(message.media, MessageMediaDocument)
                }
            
            return gift_info
            
        except Exception as e:
            logger.error(f"خطا در استخراج اطلاعات گیفت: {e}")
            return None
    
    async def send_gift_to_channel(self, gift_info: Dict[str, Any], original_message):
        """ارسال گیفت به کانال هدف"""
        try:
            # ایجاد متن پیام
            message_text = self.create_gift_message(gift_info)
            
            # ارسال پیام
            if message.media and gift_info.get('media', {}).get('has_document'):
                # ارسال با رسانه
                await self.client.send_file(
                    self.target_channel,
                    file=original_message.media,
                    caption=message_text,
                    parse_mode='html'
                )
            else:
                # ارسال فقط متن
                await self.client.send_message(
                    self.target_channel,
                    message_text,
                    parse_mode='html'
                )
            
            logger.info(f"گیفت با موفقیت به کانال ارسال شد: {gift_info['title']}")
            
        except FloodWaitError as e:
            logger.warning(f"محدودیت ارسال پیام. انتظار {e.seconds} ثانیه...")
            await asyncio.sleep(e.seconds)
            await self.send_gift_to_channel(gift_info, original_message)
        except ChatAdminRequiredError:
            logger.error("ربات دسترسی لازم برای ارسال پیام به کانال هدف را ندارد")
        except Exception as e:
            logger.error(f"خطا در ارسال گیفت به کانال: {e}")
    
    def create_gift_message(self, gift_info: Dict[str, Any]) -> str:
        """ایجاد متن پیام گیفت"""
        try:
            # ایموجی‌های مناسب
            gift_emoji = "🎁"
            channel_emoji = "📢"
            time_emoji = "⏰"
            
            # فرمت تاریخ
            date_str = gift_info['date'].strftime("%Y/%m/%d %H:%M")
            
            message = f"""
{gift_emoji} <b>گیفت جدید در تلگرام</b> {gift_emoji}

<b>عنوان:</b> {gift_info['title']}

<b>کانال:</b> {channel_emoji} {gift_info['channel_name']}

<b>زمان:</b> {time_emoji} {date_str}

<b>توضیحات:</b>
{gift_info['description']}

<b>لینک پیام اصلی:</b>
https://t.me/{gift_info['channel_name'].replace('@', '')}/{gift_info['message_id']}

#Gift #Giveaway #Telegram #هدیه #گیفت
"""
            return message.strip()
            
        except Exception as e:
            logger.error(f"خطا در ایجاد متن پیام: {e}")
            return f"🎁 گیفت جدید از {gift_info.get('channel_name', 'کانال ناشناس')}"

async def main():
    """تابع اصلی"""
    try:
        monitor = TelegramGiftMonitor()
        await monitor.start()
    except KeyboardInterrupt:
        logger.info("ربات متوقف شد")
    except Exception as e:
        logger.error(f"خطای کلی: {e}")
        sys.exit(1)

if __name__ == "__main__":
    # اجرای ربات
    asyncio.run(main())
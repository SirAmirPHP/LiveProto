#!/bin/bash
# -*- coding: utf-8 -*-
# اسکریپت نصب ربات مانیتور گیفت تلگرام
# Telegram Gift Monitor Bot Installation Script

# تنظیمات رنگ
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_message() {
    echo -e "${GREEN}[$(date '+%Y-%m-%d %H:%M:%S')]${NC} $1"
}

print_error() {
    echo -e "${RED}[$(date '+%Y-%m-%d %H:%M:%S')] ERROR:${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[$(date '+%Y-%m-%d %H:%M:%S')] WARNING:${NC} $1"
}

print_info() {
    echo -e "${BLUE}[$(date '+%Y-%m-%d %H:%M:%S')] INFO:${NC} $1"
}

# نمایش بنر
echo -e "${BLUE}"
echo "=========================================="
echo "    نصب ربات مانیتور گیفت تلگرام"
echo "    Telegram Gift Monitor Bot Installer"
echo "=========================================="
echo -e "${NC}"

# بررسی سیستم عامل
print_info "بررسی سیستم عامل..."
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    OS="linux"
elif [[ "$OSTYPE" == "darwin"* ]]; then
    OS="macos"
else
    print_error "سیستم عامل پشتیبانی نمی‌شود: $OSTYPE"
    exit 1
fi

print_message "سیستم عامل: $OS"

# بررسی Python
print_info "بررسی Python..."
if command -v python3 &> /dev/null; then
    PYTHON_VERSION=$(python3 --version 2>&1 | cut -d' ' -f2)
    print_message "Python 3 یافت شد: $PYTHON_VERSION"
    PYTHON_CMD="python3"
elif command -v python &> /dev/null; then
    PYTHON_VERSION=$(python --version 2>&1 | cut -d' ' -f2)
    if [[ $PYTHON_VERSION == 3.* ]]; then
        print_message "Python 3 یافت شد: $PYTHON_VERSION"
        PYTHON_CMD="python"
    else
        print_error "Python 3 مورد نیاز است. نسخه فعلی: $PYTHON_VERSION"
        exit 1
    fi
else
    print_error "Python نصب نشده است. لطفاً Python 3.7+ را نصب کنید."
    exit 1
fi

# بررسی pip
print_info "بررسی pip..."
if command -v pip3 &> /dev/null; then
    PIP_CMD="pip3"
elif command -v pip &> /dev/null; then
    PIP_CMD="pip"
else
    print_error "pip نصب نشده است. لطفاً pip را نصب کنید."
    exit 1
fi

print_message "استفاده از: $PIP_CMD"

# ایجاد پوشه‌های مورد نیاز
print_info "ایجاد پوشه‌های مورد نیاز..."
mkdir -p logs data
chmod 755 logs data
print_message "پوشه‌ها ایجاد شدند."

# کپی فایل .env
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        print_message "فایل .env از نمونه ایجاد شد."
    else
        print_warning "فایل .env.example یافت نشد."
    fi
else
    print_warning "فایل .env قبلاً وجود دارد."
fi

# نصب وابستگی‌ها
print_info "نصب وابستگی‌ها..."
if [ -f "requirements.txt" ]; then
    $PIP_CMD install -r requirements.txt --user
    if [ $? -eq 0 ]; then
        print_message "وابستگی‌ها با موفقیت نصب شدند."
    else
        print_error "خطا در نصب وابستگی‌ها."
        exit 1
    fi
else
    print_error "فایل requirements.txt یافت نشد."
    exit 1
fi

# تنظیم دسترسی‌ها
print_info "تنظیم دسترسی‌ها..."
chmod +x run.sh
chmod +x bot.py
print_message "دسترسی‌ها تنظیم شدند."

# بررسی تنظیمات
print_info "بررسی تنظیمات..."
if [ -f ".env" ]; then
    # بررسی وجود متغیرهای ضروری
    if grep -q "your_api_id_here" .env; then
        print_warning "لطفاً فایل .env را ویرایش کرده و اطلاعات خود را وارد کنید."
        print_info "فایل .env را با ویرایشگر متن باز کنید و موارد زیر را پر کنید:"
        echo "  - API_ID: شناسه API تلگرام"
        echo "  - API_HASH: کلید API تلگرام"
        echo "  - BOT_TOKEN: توکن ربات"
        echo "  - GIFT_CHANNELS: کانال‌های گیفت"
        echo "  - TARGET_CHANNEL: کانال هدف"
    else
        print_message "تنظیمات بررسی شدند."
    fi
else
    print_error "فایل .env یافت نشد."
    exit 1
fi

# نمایش راهنمای نهایی
echo ""
echo -e "${GREEN}=========================================="
echo "    نصب با موفقیت تکمیل شد!"
echo "==========================================${NC}"
echo ""
echo "مراحل بعدی:"
echo "1. فایل .env را ویرایش کنید و اطلاعات خود را وارد کنید"
echo "2. ربات را با دستور زیر شروع کنید:"
echo "   ./run.sh start"
echo ""
echo "یا برای اجرای در پس‌زمینه:"
echo "   ./run.sh background"
echo ""
echo "برای مشاهده راهنما:"
echo "   ./run.sh help"
echo ""

print_message "نصب تکمیل شد!"
#!/bin/bash
# -*- coding: utf-8 -*-
# اسکریپت اجرای ربات مانیتور گیفت تلگرام
# Telegram Gift Monitor Bot Runner Script

# تنظیمات رنگ برای خروجی
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# تابع نمایش پیام
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

# تابع بررسی وجود Python
check_python() {
    if command -v python3 &> /dev/null; then
        PYTHON_CMD="python3"
    elif command -v python &> /dev/null; then
        PYTHON_CMD="python"
    else
        print_error "Python نصب نشده است. لطفاً Python 3.7+ را نصب کنید."
        exit 1
    fi
    
    print_info "استفاده از: $PYTHON_CMD"
}

# تابع بررسی وجود pip
check_pip() {
    if ! command -v pip3 &> /dev/null && ! command -v pip &> /dev/null; then
        print_error "pip نصب نشده است. لطفاً pip را نصب کنید."
        exit 1
    fi
}

# تابع نصب وابستگی‌ها
install_dependencies() {
    print_info "بررسی و نصب وابستگی‌ها..."
    
    if [ -f "requirements.txt" ]; then
        if command -v pip3 &> /dev/null; then
            pip3 install -r requirements.txt --user
        else
            pip install -r requirements.txt --user
        fi
        
        if [ $? -eq 0 ]; then
            print_message "وابستگی‌ها با موفقیت نصب شدند."
        else
            print_error "خطا در نصب وابستگی‌ها."
            exit 1
        fi
    else
        print_warning "فایل requirements.txt یافت نشد."
    fi
}

# تابع بررسی فایل تنظیمات
check_config() {
    print_info "بررسی فایل تنظیمات..."
    
    if [ ! -f ".env" ]; then
        print_warning "فایل .env یافت نشد. ایجاد فایل نمونه..."
        $PYTHON_CMD config.py
        print_error "لطفاً فایل .env را ویرایش کرده و اطلاعات خود را وارد کنید."
        exit 1
    fi
    
    # بررسی وجود فایل‌های ضروری
    if [ ! -f "bot.py" ]; then
        print_error "فایل bot.py یافت نشد."
        exit 1
    fi
    
    if [ ! -f "config.py" ]; then
        print_error "فایل config.py یافت نشد."
        exit 1
    fi
    
    print_message "فایل‌های ضروری موجود هستند."
}

# تابع ایجاد پوشه‌های مورد نیاز
create_directories() {
    print_info "ایجاد پوشه‌های مورد نیاز..."
    
    # ایجاد پوشه logs
    mkdir -p logs
    
    # ایجاد پوشه data
    mkdir -p data
    
    # تنظیم دسترسی‌ها
    chmod 755 logs data
    
    print_message "پوشه‌ها ایجاد شدند."
}

# تابع بررسی دسترسی‌ها
check_permissions() {
    print_info "بررسی دسترسی‌ها..."
    
    # بررسی دسترسی نوشتن
    if [ ! -w "." ]; then
        print_error "دسترسی نوشتن در پوشه فعلی وجود ندارد."
        exit 1
    fi
    
    # بررسی دسترسی اجرا
    if [ ! -x "bot.py" ]; then
        chmod +x bot.py
    fi
    
    print_message "دسترسی‌ها بررسی شدند."
}

# تابع اجرای ربات
run_bot() {
    print_info "شروع ربات مانیتور گیفت تلگرام..."
    print_message "برای توقف ربات، Ctrl+C را فشار دهید."
    
    # اجرای ربات
    $PYTHON_CMD bot.py
    
    # بررسی وضعیت خروج
    if [ $? -eq 0 ]; then
        print_message "ربات با موفقیت متوقف شد."
    else
        print_error "ربات با خطا متوقف شد."
        exit 1
    fi
}

# تابع اجرای در پس‌زمینه
run_background() {
    print_info "اجرای ربات در پس‌زمینه..."
    
    # ایجاد فایل PID
    echo $$ > bot.pid
    
    # اجرای ربات در پس‌زمینه
    nohup $PYTHON_CMD bot.py > logs/bot.log 2>&1 &
    
    # ذخیره PID
    echo $! > bot.pid
    
    print_message "ربات در پس‌زمینه اجرا شد. PID: $!"
    print_info "برای مشاهده لاگ‌ها: tail -f logs/bot.log"
    print_info "برای توقف ربات: kill \$(cat bot.pid)"
}

# تابع توقف ربات
stop_bot() {
    if [ -f "bot.pid" ]; then
        PID=$(cat bot.pid)
        if ps -p $PID > /dev/null 2>&1; then
            print_info "توقف ربات با PID: $PID"
            kill $PID
            rm -f bot.pid
            print_message "ربات متوقف شد."
        else
            print_warning "ربات در حال اجرا نیست."
            rm -f bot.pid
        fi
    else
        print_warning "فایل PID یافت نشد."
    fi
}

# تابع نمایش وضعیت
show_status() {
    if [ -f "bot.pid" ]; then
        PID=$(cat bot.pid)
        if ps -p $PID > /dev/null 2>&1; then
            print_message "ربات در حال اجرا است. PID: $PID"
        else
            print_warning "ربات متوقف شده است."
            rm -f bot.pid
        fi
    else
        print_warning "ربات در حال اجرا نیست."
    fi
}

# تابع نمایش کمک
show_help() {
    echo "استفاده: $0 [گزینه]"
    echo ""
    echo "گزینه‌ها:"
    echo "  start      شروع ربات (پیش‌فرض)"
    echo "  stop       توقف ربات"
    echo "  restart    راه‌اندازی مجدد ربات"
    echo "  status     نمایش وضعیت ربات"
    echo "  background اجرای ربات در پس‌زمینه"
    echo "  install    نصب وابستگی‌ها"
    echo "  check      بررسی تنظیمات"
    echo "  help       نمایش این راهنما"
    echo ""
    echo "مثال‌ها:"
    echo "  $0                # شروع ربات"
    echo "  $0 start          # شروع ربات"
    echo "  $0 background     # اجرای در پس‌زمینه"
    echo "  $0 stop           # توقف ربات"
    echo "  $0 status         # نمایش وضعیت"
}

# تابع اصلی
main() {
    # نمایش بنر
    echo -e "${BLUE}"
    echo "=========================================="
    echo "    ربات مانیتور گیفت تلگرام"
    echo "    Telegram Gift Monitor Bot"
    echo "=========================================="
    echo -e "${NC}"
    
    # بررسی آرگومان‌ها
    case "${1:-start}" in
        "start")
            check_python
            check_pip
            check_config
            create_directories
            check_permissions
            install_dependencies
            run_bot
            ;;
        "stop")
            stop_bot
            ;;
        "restart")
            stop_bot
            sleep 2
            main start
            ;;
        "status")
            show_status
            ;;
        "background")
            check_python
            check_pip
            check_config
            create_directories
            check_permissions
            install_dependencies
            run_background
            ;;
        "install")
            check_python
            check_pip
            install_dependencies
            ;;
        "check")
            check_python
            check_pip
            check_config
            create_directories
            check_permissions
            print_message "همه چیز آماده است!"
            ;;
        "help"|"-h"|"--help")
            show_help
            ;;
        *)
            print_error "گزینه نامعتبر: $1"
            show_help
            exit 1
            ;;
    esac
}

# اجرای تابع اصلی
main "$@"
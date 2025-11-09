#!/bin/bash

# Script untuk setup cron job Laravel Scheduler
# Usage: ./setup-cron.sh

echo "=== Setup Cron Job untuk Laravel Scheduler ==="
echo ""

# Cek apakah dalam directory Laravel
if [ ! -f "artisan" ]; then
    echo "Error: File artisan tidak ditemukan. Pastikan Anda berada di directory Laravel project."
    exit 1
fi

# Get current directory
PROJECT_PATH=$(pwd)
echo "Project path: $PROJECT_PATH"

# Get PHP path
PHP_PATH=$(which php)
echo "PHP path: $PHP_PATH"

# Test PHP
echo ""
echo "Testing PHP..."
$PHP_PATH artisan --version

# Test schedule list
echo ""
echo "Testing schedule list..."
$PHP_PATH artisan schedule:list

# Create cron command
CRON_CMD="* * * * * cd $PROJECT_PATH && $PHP_PATH artisan schedule:run >> /dev/null 2>&1"

echo ""
echo "=== Cron Command ==="
echo "$CRON_CMD"
echo ""

# Check if cron already exists
if crontab -l 2>/dev/null | grep -q "schedule:run"; then
    echo "Warning: Cron job untuk schedule:run sudah ada!"
    echo "Cron job yang ada:"
    crontab -l | grep "schedule:run"
    echo ""
    read -p "Apakah Anda ingin menggantinya? (y/n) " -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        # Remove existing cron
        crontab -l | grep -v "schedule:run" | crontab -
        # Add new cron
        (crontab -l 2>/dev/null; echo "$CRON_CMD") | crontab -
        echo "Cron job berhasil diupdate!"
    else
        echo "Cron job tidak diubah."
        exit 0
    fi
else
    # Add new cron
    (crontab -l 2>/dev/null; echo "$CRON_CMD") | crontab -
    echo "Cron job berhasil ditambahkan!"
fi

echo ""
echo "=== Verifikasi Cron Job ==="
crontab -l | grep "schedule:run"

echo ""
echo "=== Setup Selesai ==="
echo "Cron job akan menjalankan scheduler setiap menit."
echo "Schedule yang akan berjalan:"
echo "  - Senin jam 12:00 WIB: ttd:remind"
echo "  - Kamis jam 12:00 WIB: ttd:remind"
echo ""
echo "Untuk test manual:"
echo "  php artisan schedule:run"
echo "  php artisan ttd:remind"
echo ""
echo "Untuk monitor log:"
echo "  tail -f storage/logs/laravel.log"

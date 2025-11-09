#!/bin/bash

# Script untuk setup cron job di server production
# Path: /home/u672201335/domains/sidarku.site
# PHP: /usr/bin/php

PROJECT_PATH="/home/u672201335/domains/sidarku.site"
PHP_PATH="/usr/bin/php"

# Cron command
CRON_CMD="* * * * * cd $PROJECT_PATH && $PHP_PATH artisan schedule:run >> /dev/null 2>&1"

echo "=== Setup Cron Job untuk Laravel Scheduler ==="
echo ""
echo "Project path: $PROJECT_PATH"
echo "PHP path: $PHP_PATH"
echo ""
echo "Cron command:"
echo "$CRON_CMD"
echo ""

# Check if cron already exists
if crontab -l 2>/dev/null | grep -q "schedule:run"; then
    echo "Warning: Cron job untuk schedule:run sudah ada!"
    crontab -l | grep "schedule:run"
    echo ""
    read -p "Apakah Anda ingin menggantinya? (y/n) " -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        # Remove existing cron
        crontab -l 2>/dev/null | grep -v "schedule:run" | crontab -
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
echo ""
echo "Untuk test manual:"
echo "  cd $PROJECT_PATH"
echo "  $PHP_PATH artisan schedule:run"
echo "  $PHP_PATH artisan ttd:remind"
echo ""
echo "Untuk monitor log:"
echo "  tail -f $PROJECT_PATH/storage/logs/laravel.log"


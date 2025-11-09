# Fix Schedule Cache - File Sudah Benar Tapi Schedule Tidak Muncul

## Problem
File `bootstrap/app.php` sudah memiliki schedule configuration, tapi `php artisan schedule:list` masih menunjukkan "No scheduled tasks have been defined".

## Penyebab
1. Cache config masih menggunakan versi lama
2. Autoload files belum di-refresh
3. Laravel belum membaca schedule dari bootstrap/app.php

## Solusi Lengkap

### Step 1: Clear Semua Cache

```bash
# Di server production
cd /home/u672201335/domains/sidarku.site

# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

### Step 2: Rebuild Autoload (Jika Menggunakan Composer)

```bash
# Rebuild autoload
composer dump-autoload
```

### Step 3: Clear Opcache (Jika Ada)

```bash
# Clear opcache (jika menggunakan PHP-FPM)
php artisan optimize:clear

# Atau restart PHP-FPM (jika perlu)
# sudo systemctl restart php-fpm
```

### Step 4: Verifikasi Schedule

```bash
# Cek schedule list
php artisan schedule:list

# Harus muncul:
# 0 12 * * 1  php artisan ttd:remind ............. Next Due: ...
# 0 12 * * 4  php artisan ttd:remind ............. Next Due: ...
```

### Step 5: Test Scheduler

```bash
# Test jalankan scheduler
php artisan schedule:run

# Test command
php artisan ttd:remind

# Cek log
tail -f storage/logs/laravel.log
```

## Quick Fix Command (Copy-Paste)

```bash
cd /home/u672201335/domains/sidarku.site
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
php artisan schedule:list
```

## Troubleshooting

### Jika Masih "No scheduled tasks"

1. **Cek syntax PHP:**
   ```bash
   php -l bootstrap/app.php
   ```
   Harus menunjukkan "No syntax errors"

2. **Cek apakah Laravel bisa membaca file:**
   ```bash
   php artisan tinker
   >>> file_exists(base_path('bootstrap/app.php'))
   >>> require base_path('bootstrap/app.php');
   ```

3. **Cek environment:**
   ```bash
   php artisan env
   # atau
   cat .env | grep APP_ENV
   ```

4. **Test manual schedule:**
   ```bash
   php artisan tinker
   >>> $app = require base_path('bootstrap/app.php');
   >>> $schedule = $app->make(\Illuminate\Console\Scheduling\Schedule::class);
   >>> $schedule->command('ttd:remind')->weeklyOn(1, '12:00')->timezone('Asia/Jakarta');
   ```

### Jika Cache Masih Bermasalah

1. **Hapus manual cache files:**
   ```bash
   rm -rf bootstrap/cache/*.php
   rm -rf storage/framework/cache/*
   rm -rf storage/framework/views/*
   ```

2. **Set permissions:**
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

3. **Rebuild cache:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

## Verifikasi Akhir

Setelah semua step, verifikasi:

```bash
# 1. Cek schedule list
php artisan schedule:list

# 2. Test scheduler
php artisan schedule:run

# 3. Test command
php artisan ttd:remind

# 4. Cek log
tail -f storage/logs/laravel.log
```

## Catatan

- `optimize:clear` adalah command yang lebih lengkap untuk clear semua cache
- Pastikan permissions file dan folder benar (775 untuk storage dan bootstrap/cache)
- Jika masih tidak bekerja, coba restart web server atau PHP-FPM


# Fix Scheduler di Production - "No scheduled tasks have been defined"

## Problem
Setelah setup cron job di hPanel, ketika dijalankan `php artisan schedule:list` muncul:
```
INFO  No scheduled tasks have been defined.
```

## Penyebab
1. File `bootstrap/app.php` di server production belum di-update (belum di-deploy)
2. Cache config masih menggunakan versi lama
3. Code belum di-push ke server

## Solusi

### Step 1: Cek File bootstrap/app.php di Server

```bash
# Login SSH
ssh -p 65002 u672201335@153.92.10.207
cd /home/u672201335/domains/sidarku.site

# Cek apakah file bootstrap/app.php sudah memiliki schedule
cat bootstrap/app.php | grep -A 10 "withSchedule"
```

### Step 2: Jika File Belum Ada Schedule

**Pastikan code sudah di-push dan di-pull di server:**

```bash
# Di server production
cd /home/u672201335/domains/sidarku.site

# Pull code terbaru (jika menggunakan git)
git pull origin main

# Atau jika tidak menggunakan git, pastikan file bootstrap/app.php sudah diupdate
```

### Step 3: Clear Cache

```bash
# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize (opsional)
php artisan config:cache
php artisan route:cache
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
```

## Jika Masih Tidak Bekerja

### Cek File bootstrap/app.php

File `bootstrap/app.php` harus memiliki bagian ini:

```php
->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule): void {
    // Schedule TTD reminder to run twice weekly (Monday & Thursday) at 12:00 WIB
    // 1 = Monday, 4 = Thursday
    $schedule->command('ttd:remind')
        ->weeklyOn(1, '12:00') // Senin jam 12:00
        ->timezone('Asia/Jakarta')
        ->withoutOverlapping();
        
    $schedule->command('ttd:remind')
        ->weeklyOn(4, '12:00') // Kamis jam 12:00
        ->timezone('Asia/Jakarta')
        ->withoutOverlapping();
})
```

### Deploy Code Terbaru

Jika menggunakan git:

```bash
# Di local machine
git add .
git commit -m "Add scheduler for TTD reminder"
git push origin main

# Di server production
cd /home/u672201335/domains/sidarku.site
git pull origin main
php artisan config:clear
php artisan cache:clear
```

Jika tidak menggunakan git, upload file `bootstrap/app.php` manual via FTP/hPanel File Manager.

## Verifikasi Cron Job di hPanel

1. Login ke hPanel: https://hpanel.hostinger.com/
2. Buka "Cron Jobs"
3. Pastikan cron job sudah dibuat dan status "Aktif"
4. Pastikan command benar:
   ```
   cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
   ```

## Troubleshooting

### Jika `crontab -l` masih "no crontab"

Ini normal jika menggunakan hPanel. hPanel menggunakan sistem cron yang berbeda, jadi `crontab -l` mungkin tidak menampilkannya.

**Cek di hPanel:**
- Pastikan cron job ada di daftar
- Pastikan status "Aktif"

### Jika `schedule:list` masih kosong

1. **Cek file bootstrap/app.php:**
   ```bash
   cat bootstrap/app.php | grep "withSchedule"
   ```

2. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Cek syntax PHP:**
   ```bash
   php -l bootstrap/app.php
   ```

4. **Test manual:**
   ```bash
   php artisan tinker
   >>> $schedule = app(\Illuminate\Console\Scheduling\Schedule::class);
   >>> $schedule->command('ttd:remind')->weeklyOn(1, '12:00')->timezone('Asia/Jakarta');
   ```

## Quick Fix Command

```bash
# Di server production
cd /home/u672201335/domains/sidarku.site

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Cek schedule
php artisan schedule:list

# Test
php artisan schedule:run
php artisan ttd:remind
```

## Catatan

- `crontab -l` mungkin tidak menampilkan cron job yang dibuat via hPanel (normal)
- Yang penting adalah `php artisan schedule:list` harus menampilkan schedule
- Pastikan file `bootstrap/app.php` sudah di-update di server


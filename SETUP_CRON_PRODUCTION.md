# Setup Cron Job di Server Production via SSH

## Langkah-langkah Setup

### 1. Login ke Server Production via SSH

```bash
ssh username@your-server-ip
# atau
ssh username@your-domain.com
```

### 2. Masuk ke Directory Project

```bash
cd /path/to/your/project
# Contoh:
# cd /var/www/sidarku
# atau
# cd /home/username/public_html
```

**Cari path project Anda:**
```bash
# Cari dimana project Laravel Anda berada
find / -name "artisan" -type f 2>/dev/null | grep sidarku
```

### 3. Pastikan Path PHP yang Benar

```bash
# Cek path PHP
which php
# atau
php -v

# Jika menggunakan full path, contoh:
# /usr/bin/php
# /opt/lampp/bin/php
# /usr/local/bin/php
```

### 4. Test Command Scheduler

```bash
# Test apakah command bisa dijalankan
php artisan schedule:list

# Test jalankan command manual
php artisan ttd:remind
```

### 5. Setup Cron Job

#### Cara 1: Edit Crontab (Recommended)

```bash
# Edit crontab
crontab -e

# Jika pertama kali, pilih editor (pilih nano atau vi)
# Pilih: 1 (nano) atau 2 (vi)
```

#### Cara 2: Tambahkan Cron Job

Tambahkan baris berikut di crontab (sesuaikan path dengan lokasi project Anda):

```bash
* * * * * cd /path/to/your/project && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

**Contoh untuk berbagai server:**

**Shared Hosting (cPanel):**
```bash
* * * * * cd /home/username/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

**VPS/Dedicated Server:**
```bash
* * * * * cd /var/www/sidarku && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

**Jika menggunakan PHP versi tertentu:**
```bash
* * * * * cd /var/www/sidarku && /usr/bin/php8.2 artisan schedule:run >> /dev/null 2>&1
```

### 6. Simpan dan Keluar

**Jika menggunakan nano:**
- Tekan `Ctrl + X`
- Tekan `Y` untuk save
- Tekan `Enter` untuk confirm

**Jika menggunakan vi:**
- Tekan `Esc`
- Ketik `:wq`
- Tekan `Enter`

### 7. Verifikasi Cron Job

```bash
# Lihat cron job yang sudah terdaftar
crontab -l

# Test jalankan scheduler secara manual
php artisan schedule:run

# Cek log Laravel
tail -f storage/logs/laravel.log
```

### 8. Troubleshooting

#### Cron Job Tidak Berjalan

1. **Cek path PHP:**
```bash
which php
# Gunakan full path di crontab
```

2. **Cek permissions:**
```bash
# Pastikan file artisan executable
chmod +x artisan

# Pastikan storage writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

3. **Test dengan log file:**
```bash
# Ubah cron job untuk logging
* * * * * cd /var/www/sidarku && /usr/bin/php artisan schedule:run >> /var/www/sidarku/storage/logs/cron.log 2>&1

# Cek log
tail -f storage/logs/cron.log
```

4. **Cek apakah cron service running:**
```bash
# Ubuntu/Debian
sudo service cron status

# CentOS/RHEL
sudo service crond status

# Systemd
sudo systemctl status cron
```

#### Email Tidak Terkirim

1. **Cek konfigurasi email di .env:**
```bash
# Edit .env
nano .env

# Pastikan konfigurasi email benar
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

2. **Test kirim email:**
```bash
php artisan tinker
>>> Mail::raw('Test email', function($message) { $message->to('test@example.com')->subject('Test'); });
```

3. **Cek log email:**
```bash
tail -f storage/logs/laravel.log | grep -i mail
```

### 9. Alternative: Setup via cPanel (Shared Hosting)

1. Login ke cPanel
2. Buka **Cron Jobs**
3. Tambahkan **Standard Cron Job**:
   - **Minute:** `*`
   - **Hour:** `*`
   - **Day:** `*`
   - **Month:** `*`
   - **Weekday:** `*`
   - **Command:** `cd /home/username/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1`
4. Klik **Add New Cron Job**

### 10. Monitor Cron Job

```bash
# Cek apakah cron job berjalan
ps aux | grep "schedule:run"

# Cek log cron
tail -f /var/log/cron
# atau
tail -f /var/log/syslog | grep CRON
```

### 11. Test Manual

```bash
# Test jalankan scheduler
php artisan schedule:run

# Test command reminder
php artisan ttd:remind

# Cek schedule list
php artisan schedule:list
```

## Contoh Lengkap Setup

```bash
# 1. Login ke server
ssh user@server.com

# 2. Masuk ke directory project
cd /var/www/sidarku

# 3. Cek path PHP
which php
# Output: /usr/bin/php

# 4. Test command
php artisan schedule:list

# 5. Edit crontab
crontab -e

# 6. Tambahkan baris ini:
* * * * * cd /var/www/sidarku && /usr/bin/php artisan schedule:run >> /dev/null 2>&1

# 7. Save dan exit (Ctrl+X, Y, Enter jika menggunakan nano)

# 8. Verifikasi
crontab -l

# 9. Test manual
php artisan schedule:run

# 10. Monitor log
tail -f storage/logs/laravel.log
```

## Catatan Penting

1. **Path harus absolute:** Gunakan full path untuk PHP dan project directory
2. **Permissions:** Pastikan file dan folder memiliki permissions yang benar
3. **Timezone:** Pastikan server timezone sama dengan aplikasi (Asia/Jakarta)
4. **Environment:** Pastikan `.env` sudah dikonfigurasi dengan benar
5. **Log:** Monitor log untuk memastikan cron job berjalan dengan baik

## Schedule yang Akan Berjalan

Setelah setup cron job, scheduler akan menjalankan:
- **Senin jam 12:00 WIB:** `php artisan ttd:remind`
- **Kamis jam 12:00 WIB:** `php artisan ttd:remind`

Email akan dikirim ke user yang belum minum TTD dalam 7 hari terakhir.


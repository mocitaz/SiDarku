# Setup Cron Job untuk Laravel Scheduler

## Masalah
Email reminder TTD tidak terkirim otomatis pada jam 12:00 WIB karena Laravel scheduler tidak berjalan. Laravel scheduler memerlukan cron job yang menjalankan `php artisan schedule:run` setiap menit.

## Solusi

### 1. Setup Cron Job di Server Production

Tambahkan cron job berikut di server production untuk menjalankan Laravel scheduler setiap menit:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

**Contoh untuk server dengan path `/var/www/sidarku`:**

```bash
* * * * * cd /var/www/sidarku && php artisan schedule:run >> /dev/null 2>&1
```

### 2. Cara Menambahkan Cron Job

#### Via SSH ke Server:
```bash
# Edit crontab
crontab -e

# Tambahkan baris berikut (sesuaikan path dengan lokasi project Anda)
* * * * * cd /var/www/sidarku && php artisan schedule:run >> /dev/null 2>&1

# Simpan dan keluar (Ctrl+X, lalu Y, lalu Enter jika menggunakan nano)
```

#### Via cPanel (jika menggunakan shared hosting):
1. Login ke cPanel
2. Buka "Cron Jobs"
3. Tambahkan cron job baru:
   - **Minute:** `*`
   - **Hour:** `*`
   - **Day:** `*`
   - **Month:** `*`
   - **Weekday:** `*`
   - **Command:** `cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1`
   (Sesuaikan path dengan lokasi project Anda)

### 3. Verifikasi Cron Job

Setelah menambahkan cron job, verifikasi bahwa scheduler berjalan:

```bash
# Cek apakah cron job sudah terdaftar
crontab -l

# Test scheduler secara manual
php artisan schedule:run

# Cek daftar scheduled tasks
php artisan schedule:list
```

### 4. Test Scheduler

Untuk memastikan scheduler berjalan dengan benar:

```bash
# Jalankan scheduler secara manual
php artisan schedule:run

# Cek log reminder
php artisan tinker
>>> \App\Models\TtdReminderLog::latest()->first();
```

### 5. Troubleshooting

#### Scheduler tidak berjalan:
1. **Cek path project:** Pastikan path di cron job benar
2. **Cek PHP path:** Gunakan full path ke PHP jika perlu, contoh: `/usr/bin/php`
3. **Cek permissions:** Pastikan user yang menjalankan cron memiliki akses ke project
4. **Cek log:** Lihat log Laravel di `storage/logs/laravel.log`

#### Email tidak terkirim:
1. **Cek konfigurasi mail:** Pastikan `.env` sudah dikonfigurasi dengan benar
2. **Test email:** Jalankan `php artisan tinker` dan test kirim email
3. **Cek log:** Lihat log Laravel untuk error saat mengirim email

### 6. Catatan Penting

- **Timezone:** Scheduler sudah dikonfigurasi untuk berjalan di timezone `Asia/Jakarta` (WIB)
- **Waktu:** Email reminder akan dikirim **2 kali seminggu** (Senin dan Kamis) jam 12:00 WIB
- **Hari:** 
  - **Senin** (Monday) jam 12:00 WIB
  - **Kamis** (Thursday) jam 12:00 WIB
- **Overlapping:** Scheduler menggunakan `withoutOverlapping()` untuk mencegah eksekusi ganda
- **Log:** Semua aktivitas scheduler akan tercatat di `storage/logs/laravel.log`

### 7. Alternatif: Manual Run (Untuk Testing)

Jika cron job belum bisa di-setup, Anda bisa menjalankan command secara manual:

```bash
php artisan ttd:remind
```

Atau untuk testing, Anda bisa mengubah waktu schedule sementara di `bootstrap/app.php`:

```php
// Contoh: jalankan setiap 5 menit untuk testing
$schedule->command('ttd:remind')
    ->everyFiveMinutes()
    ->timezone('Asia/Jakarta')
    ->withoutOverlapping();
```

**Jangan lupa kembalikan ke `dailyAt('12:00')` setelah testing!**


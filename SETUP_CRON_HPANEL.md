# Setup Cron Job via hPanel (Hostinger Control Panel)

## Mengapa menggunakan hPanel?
- Lebih mudah dan reliable
- Tidak perlu akses SSH untuk setup cron
- Hostinger mengelola permissions secara otomatis
- Interface yang user-friendly

## Langkah-langkah Setup via hPanel

### 1. Login ke hPanel
1. Buka: https://hpanel.hostinger.com/
2. Login dengan akun Hostinger Anda

### 2. Akses Cron Jobs
1. Di hPanel, cari menu **"Cron Jobs"**
2. Atau di sidebar, klik **"Advanced"** → **"Cron Jobs"**
3. Klik **"Add Cron Job"** atau **"Create Cron Job"**

### 3. Konfigurasi Cron Job

#### Pilihan A: Standard Cron Job (Recommended)

Isi form dengan data berikut:

- **Minute:** `*`
- **Hour:** `*`
- **Day:** `*`
- **Month:** `*`
- **Weekday:** `*`
- **Command:**
  ```bash
  cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
  ```

#### Pilihan B: Advanced Cron Job

Jika ada pilihan "Advanced", gunakan format:
```
* * * * * cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

### 4. Simpan Cron Job
1. Klik **"Add"** atau **"Save"** atau **"Create"**
2. Tunggu konfirmasi bahwa cron job berhasil dibuat

### 5. Verifikasi

Setelah setup, verifikasi dengan:

1. **Login via SSH:**
   ```bash
   ssh -p 65002 u672201335@153.92.10.207
   cd /home/u672201335/domains/sidarku.site
   ```

2. **Cek cron job:**
   ```bash
   crontab -l
   ```
   Harus muncul cron job yang baru dibuat

3. **Test scheduler:**
   ```bash
   php artisan schedule:run
   php artisan schedule:list
   ```

4. **Test command:**
   ```bash
   php artisan ttd:remind
   ```

## Alternatif: Jika hPanel tidak memiliki Cron Jobs

Beberapa hosting menggunakan nama yang berbeda:

1. **Cron Manager**
2. **Scheduled Tasks**
3. **Task Scheduler**
4. **Automated Tasks**

Cari di menu "Advanced" atau "Tools"

## Troubleshooting

### Jika cron job tidak muncul di `crontab -l`

1. **Cek di hPanel:**
   - Pastikan cron job sudah dibuat
   - Pastikan status "Active" atau "Enabled"

2. **Cek path:**
   - Pastikan path project benar: `/home/u672201335/domains/sidarku.site`
   - Pastikan path PHP benar: `/usr/bin/php`

3. **Test manual:**
   ```bash
   cd /home/u672201335/domains/sidarku.site
   /usr/bin/php artisan schedule:run
   ```

### Jika cron job tidak berjalan

1. **Cek log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Cek dengan logging:**
   - Ubah command di hPanel menjadi:
     ```bash
     cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /home/u672201335/domains/sidarku.site/storage/logs/cron.log 2>&1
     ```
   - Cek log: `tail -f storage/logs/cron.log`

3. **Cek timezone:**
   - Pastikan timezone server adalah Asia/Jakarta
   - Atau sesuaikan waktu di schedule

## Screenshot Referensi (jika perlu)

Jika hPanel memiliki interface berbeda, cari:
- Field untuk "Minute", "Hour", "Day", "Month", "Weekday"
- Field untuk "Command" atau "Script"
- Button "Add", "Save", atau "Create"

## Catatan Penting

1. **Schedule yang akan berjalan:**
   - Senin jam 12:00 WIB: `php artisan ttd:remind`
   - Kamis jam 12:00 WIB: `php artisan ttd:remind`

2. **Email akan dikirim ke:**
   - User yang belum minum TTD dalam 7 hari terakhir

3. **Monitoring:**
   - Monitor log di `storage/logs/laravel.log`
   - Cek admin panel untuk melihat log reminder

## Quick Command untuk Copy-Paste

```
* * * * * cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

## Setelah Setup Berhasil

1. **Tunggu beberapa menit** untuk cron job mulai berjalan
2. **Test dengan:**
   ```bash
   php artisan schedule:run
   php artisan ttd:remind
   ```
3. **Monitor log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Support

Jika masih mengalami masalah:
1. Hubungi support Hostinger
2. Tanyakan tentang akses cron job untuk user `u672201335`
3. Atau minta bantuan untuk setup cron job via hPanel


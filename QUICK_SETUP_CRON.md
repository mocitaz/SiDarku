# Quick Setup Cron Job - Hostinger Server

## Langkah-langkah di Server

### 1. Masuk ke directory project
```bash
cd /home/u672201335/domains/sidarku.site
```

### 2. Tambahkan cron job (satu baris command)

Copy-paste command ini:

```bash
(crontab -l 2>/dev/null; echo "* * * * * cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1") | crontab -
```

### 3. Verifikasi cron job sudah terdaftar

```bash
crontab -l
```

Harus muncul:
```
* * * * * cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

### 4. Test scheduler

```bash
php artisan schedule:run
php artisan schedule:list
```

## Alternatif: Manual Edit

Jika command di atas tidak bekerja, gunakan cara manual:

```bash
# 1. Buat crontab baru
crontab -e

# 2. Jika muncul pilihan editor, pilih 1 (nano) atau 2 (vi)

# 3. Tambahkan baris ini:
* * * * * cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1

# 4. Simpan:
# - Nano: Ctrl+X, lalu Y, lalu Enter
# - Vi: Esc, lalu :wq, lalu Enter
```

## Troubleshooting

### Jika "no crontab" masih muncul setelah setup:

1. **Cek apakah cron service aktif:**
```bash
ps aux | grep cron
```

2. **Cek permissions:**
```bash
ls -la /var/spool/cron/
```

3. **Coba dengan logging untuk debug:**
```bash
# Hapus cron lama (jika ada)
crontab -r

# Tambahkan dengan logging
(crontab -l 2>/dev/null; echo "* * * * * cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /home/u672201335/domains/sidarku.site/storage/logs/cron.log 2>&1") | crontab -

# Cek log
tail -f storage/logs/cron.log
```

## Verifikasi Setup Berhasil

1. **Cek cron job:**
```bash
crontab -l
```

2. **Test manual:**
```bash
php artisan schedule:run
php artisan ttd:remind
```

3. **Monitor log:**
```bash
tail -f storage/logs/laravel.log
```

## Catatan

- Cron job akan berjalan setiap menit
- Scheduler akan mengecek jadwal dan menjalankan command jika waktunya tepat
- Email reminder akan dikirim setiap Senin & Kamis jam 12:00 WIB (server time)
- Pastikan timezone server sudah benar (Asia/Jakarta)


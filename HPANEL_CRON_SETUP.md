# Setup Cron Job di hPanel untuk 2x Seminggu (Senin & Kamis) Jam 12:00 WIB

## ⚠️ PENTING: Pilih Salah Satu Opsi

### Opsi 1: SETIAP MENIT (Recommended - Standar Laravel)

**Ini adalah cara yang benar dan recommended oleh Laravel!**

Laravel scheduler (`schedule:run`) dirancang untuk berjalan **setiap menit**. Scheduler akan mengecek jadwal internal dan hanya menjalankan command jika waktunya tepat (Senin & Kamis jam 12:00).

#### Konfigurasi di hPanel:

- **PHP Path:** `/usr/bin/php` (atau biarkan kosong jika sudah ada di field)
- **Perintah untuk dijalankan:**
  ```
  cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
  ```
- **menit (minute):** `*` (Setiap Menit)
- **jam (hour):** `*` (Setiap Jam)
- **hari (day of month):** `*` (Setiap Hari)
- **bulan (month):** `*` (Setiap Bulan)
- **weekDay:** `*` (Setiap Hari)

**Cron Expression:** `* * * * *`

---

### Opsi 2: Hanya Senin & Kamis Jam 12:00 (Alternatif)

Jika Anda ingin lebih efisien dan hanya menjalankan scheduler pada hari Senin & Kamis jam 12:00:

#### Konfigurasi di hPanel:

- **PHP Path:** `/usr/bin/php`
- **Perintah untuk dijalankan:**
  ```
  cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
  ```
- **menit (minute):** `0` atau `:00 di awal jam (0)`
- **jam (hour):** `12`
- **hari (day of month):** `*` (Setiap Hari)
- **bulan (month):** `*` (Setiap Bulan)
- **weekDay:** `1 dan 4` (Senin=1, Kamis=4)

**Cron Expression:** `0 12 * * 1,4`

---

## 📝 Langkah-langkah di hPanel:

### 1. Pilih Opsi PHP
- ✅ Pilih **"PHP"** (bukan "Kustom")

### 2. Isi PHP Path (opsional)
- Field ini bisa dikosongkan atau diisi: `/usr/bin/php`
- Command sudah lengkap, jadi field ini tidak wajib

### 3. Isi Perintah untuk dijalankan
```
cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

### 4. Atur Jadwal

#### Jika memilih Opsi 1 (Recommended):
- **menit:** Pilih `*` (Setiap Menit)
- **jam:** Pilih `*` (Setiap Jam)
- **hari:** Pilih `*` (Setiap Hari)
- **bulan:** Pilih `*` (Setiap Bulan)
- **weekDay:** Pilih `*` (Setiap Hari)

#### Jika memilih Opsi 2 (Alternatif):
- **menit:** Pilih `0` atau `:00 di awal jam (0)`
- **jam:** Pilih `12`
- **hari:** Pilih `*` (Setiap Hari)
- **bulan:** Pilih `*` (Setiap Bulan)
- **weekDay:** Pilih `1` dan `4` (Senin & Kamis)

### 5. Klik "Simpan"

---

## ✅ Verifikasi Setelah Setup

### 1. Cek di hPanel
- Pastikan cron job muncul di daftar
- Pastikan status "Aktif" atau "Enabled"

### 2. Login SSH dan Test
```bash
# Login SSH
ssh -p 65002 u672201335@153.92.10.207

# Masuk ke directory
cd /home/u672201335/domains/sidarku.site

# Cek cron job
crontab -l

# Test scheduler
php artisan schedule:run

# Test command
php artisan ttd:remind

# Cek schedule list
php artisan schedule:list
```

### 3. Monitor Log
```bash
# Monitor log Laravel
tail -f storage/logs/laravel.log

# Atau dengan log khusus cron
tail -f storage/logs/cron.log
```

---

## 🎯 Rekomendasi

**Gunakan Opsi 1 (Setiap Menit)** karena:
1. ✅ Ini adalah cara standar Laravel
2. ✅ Lebih reliable dan akurat
3. ✅ Scheduler Laravel sudah dikonfigurasi untuk Senin & Kamis jam 12:00
4. ✅ Resource yang digunakan minimal (hanya cek jadwal, tidak eksekusi jika belum waktunya)

**Opsi 2** hanya digunakan jika Anda ingin lebih hemat resource (tapi tidak recommended).

---

## 📋 Summary

### Command untuk Copy-Paste:
```
cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

### Cron Expression:
- **Opsi 1 (Recommended):** `* * * * *`
- **Opsi 2 (Alternatif):** `0 12 * * 1,4`

### Hasil:
- Email reminder TTD akan dikirim setiap **Senin & Kamis jam 12:00 WIB**
- Hanya user yang **belum minum TTD dalam 7 hari terakhir** yang akan menerima email

---

## 🔍 Troubleshooting

### Jika cron job tidak berjalan:

1. **Cek di hPanel:**
   - Pastikan cron job status "Aktif"
   - Pastikan waktu server benar (WIB)

2. **Cek dengan logging:**
   - Ubah command menjadi:
     ```
     cd /home/u672201335/domains/sidarku.site && /usr/bin/php artisan schedule:run >> /home/u672201335/domains/sidarku.site/storage/logs/cron.log 2>&1
     ```
   - Cek log: `tail -f storage/logs/cron.log`

3. **Test manual:**
   ```bash
   php artisan schedule:run
   php artisan ttd:remind
   ```

---

## 📞 Support

Jika masih mengalami masalah:
1. Hubungi support Hostinger
2. Tanyakan tentang timezone server (harus Asia/Jakarta/WIB)
3. Atau minta bantuan untuk setup cron job


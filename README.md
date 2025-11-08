# SiDarku - Selalu Ingat Darah Ku

<div align="center">

![SiDarku](public/images/icon.png)

**Platform Kesehatan Remaja Putri untuk Mengingat Konsumsi Tablet Tambah Darah, Melacak Siklus Menstruasi, dan Mendapatkan Edukasi Kesehatan**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.6-blue.svg)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0-38bdf8.svg)](https://tailwindcss.com)

</div>

## 📋 Tentang SiDarku

SiDarku adalah aplikasi web berbasis Laravel yang dirancang khusus untuk membantu remaja putri dalam mengelola kesehatan mereka, khususnya:

- **Tracking Konsumsi Tablet Tambah Darah (TTD)** - Mencatat dan melacak konsumsi TTD untuk mencegah anemia
- **Pelacakan Siklus Menstruasi** - Mencatat dan memprediksi siklus menstruasi dengan akurat
- **Edukasi Kesehatan** - Akses ke artikel dan informasi kesehatan remaja putri

## ✨ Fitur Utama

### 🔴 Tracking Tablet Tambah Darah (TTD)
- ✅ Pencatatan konsumsi TTD harian
- ✅ Reminder otomatis untuk konsumsi TTD
- ✅ Statistik konsumsi (streak, compliance rate)
- ✅ Progress chart visual
- ✅ Weekly dan monthly tracking

### 🌸 Pelacakan Siklus Menstruasi
- 📅 Pencatatan tanggal mulai dan selesai haid
- 🔮 Prediksi haid berikutnya berdasarkan rata-rata siklus
- 📊 Riwayat siklus menstruasi
- 🎯 Perhitungan panjang siklus yang akurat
- 🔄 Fitur reset siklus untuk memulai dari awal
- ⚠️ Validasi tanggal untuk mencegah kesalahan input

### 📚 Edukasi Kesehatan
- 📖 Artikel edukasi tentang kesehatan remaja putri
- 💡 Tips kesehatan berdasarkan fase siklus
- 📱 Konten yang mudah diakses

### 👤 Manajemen Profil
- 📝 Update profil pengguna
- 🔐 Manajemen akun
- 🔒 Keamanan data pribadi

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12.x
- **Frontend**: Livewire 3.6, TailwindCSS 4.0
- **Database**: SQLite (dapat diganti dengan MySQL/PostgreSQL)
- **PHP**: 8.2+
- **Node.js**: untuk asset compilation
- **Chart.js**: untuk visualisasi data

## 📦 Instalasi

### Prasyarat

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js dan npm
- SQLite (atau MySQL/PostgreSQL)

### Langkah-langkah Instalasi

1. **Clone repository**
```bash
git clone https://github.com/mocitaz/SiDarku.git
cd SiDarku
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database**

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

Atau untuk MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sidarku
DB_USERNAME=root
DB_PASSWORD=
```

5. **Buat database SQLite (jika menggunakan SQLite)**
```bash
touch database/database.sqlite
```

6. **Jalankan migrasi**
```bash
php artisan migrate
php artisan db:seed
```

7. **Setup storage link**
```bash
php artisan storage:link
```

8. **Build assets**
```bash
npm run build
```

9. **Jalankan aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🚀 Penggunaan

### Development Mode

Untuk development dengan hot reload:
```bash
npm run dev
```

Dan di terminal terpisah:
```bash
php artisan serve
```

### Production Mode

1. Build assets untuk production:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Struktur Project

```
SiDarku/
├── app/
│   ├── Console/          # Artisan commands
│   ├── Http/             # Controllers & Middleware
│   ├── Livewire/         # Livewire components
│   ├── Mail/             # Email templates
│   ├── Models/           # Eloquent models
│   └── Notifications/    # Notification classes
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── public/               # Public assets
├── resources/
│   ├── views/            # Blade templates
│   ├── css/              # Stylesheets
│   └── js/               # JavaScript files
├── routes/               # Route definitions
└── storage/              # Storage files
```

## 🔐 Default Credentials

Setelah menjalankan seeder, Anda dapat login dengan:

- **Email**: admin@sidarku.com
- **Password**: (cek di AdminSeeder)

## 📝 Fitur Perhitungan Siklus

Aplikasi ini menggunakan algoritma yang akurat untuk menghitung prediksi haid berikutnya:

- Menghitung panjang siklus berdasarkan selisih hari dari start_date siklus N ke start_date siklus N+1
- Menggunakan rata-rata 6 siklus terakhir untuk prediksi yang lebih akurat
- Memfilter siklus dengan panjang tidak wajar (21-45 hari)
- Prediksi haid = start_date terakhir + rata-rata panjang siklus

## 🔒 Keamanan

- Password hashing menggunakan bcrypt
- CSRF protection
- SQL injection protection (Eloquent ORM)
- XSS protection
- Authentication & authorization
- Data validation

## 🧪 Testing

```bash
php artisan test
```

## 📄 License

MIT License - lihat file [LICENSE](LICENSE) untuk detail

## 👥 Kontribusi

Kontribusi sangat diterima! Silakan buat issue atau pull request.

## 📧 Kontak

Untuk pertanyaan atau dukungan, silakan buat issue di repository ini.

## 🙏 Acknowledgments

- Laravel Framework
- Livewire
- TailwindCSS
- Chart.js
- Semua kontributor open source

## 📱 Screenshots

(Anda dapat menambahkan screenshot aplikasi di sini)

---

<div align="center">

**Dibuat dengan ❤️ untuk kesehatan remaja putri Indonesia**

⭐ Berikan star jika project ini membantu Anda!

</div>


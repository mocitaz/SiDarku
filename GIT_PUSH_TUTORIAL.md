# Tutorial Git Push ke GitHub

Panduan lengkap untuk push code SiDarku ke GitHub repository.

## 📋 Prasyarat

1. **Git sudah terinstall** di komputer Anda
2. **Akun GitHub** sudah dibuat
3. **Repository GitHub** sudah dibuat di https://github.com/mocitaz/SiDarku

## 🚀 Langkah-langkah Push ke GitHub

### 1. Inisialisasi Git Repository (Jika Belum Ada)

```bash
cd /Users/Luthfi/Project/sidarku
git init
```

### 2. Tambahkan Remote Repository

```bash
git remote add origin https://github.com/mocitaz/SiDarku.git
```

Jika remote sudah ada tapi salah, hapus dulu:
```bash
git remote remove origin
git remote add origin https://github.com/mocitaz/SiDarku.git
```

### 3. Pastikan File .gitignore Sudah Benar

Pastikan file `.gitignore` sudah mengabaikan file-file sensitif:
- `.env` (tidak boleh di-commit)
- `vendor/`
- `node_modules/`
- `storage/logs/*`
- dll

### 4. Hapus Secret dari File Example

**⚠️ PENTING:** GitHub akan memblokir push jika ada secret di commit history!

Pastikan file `.env.example` dan `env.production.example` **TIDAK** berisi password/secret yang real.

Contoh yang BENAR:
```env
MAIL_PASSWORD=your_sendinblue_smtp_password_here
```

Contoh yang SALAH:
```env
MAIL_PASSWORD="xsmtpsib-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-xxxxxxxxxxxx"
```

### 5. Add File ke Staging Area

```bash
git add .
```

Atau add file tertentu saja:
```bash
git add README.md
git add app/
git add resources/
```

### 6. Commit Perubahan

```bash
git commit -m "Initial commit: SiDarku - Platform Kesehatan Remaja Putri

- Tracking konsumsi Tablet Tambah Darah (TTD)
- Pelacakan siklus menstruasi dengan prediksi akurat
- Edukasi kesehatan remaja putri
- Built with Laravel 12, Livewire 3.6, and TailwindCSS 4.0"
```

### 7. Set Branch ke Main

```bash
git branch -M main
```

### 8. Push ke GitHub

**Opsi 1: Push Normal (Jika repository baru/kosong)**
```bash
git push -u origin main
```

**Opsi 2: Force Push (Jika ada masalah dengan history)**
```bash
git push -u origin main --force
```

⚠️ **Hati-hati dengan force push!** Hanya gunakan jika Anda yakin tidak ada orang lain yang bekerja di repository ini.

## 🔒 Menangani GitHub Secret Detection

Jika GitHub memblokir push karena mendeteksi secret:

### Solusi 1: Hapus Secret dari File (RECOMMENDED)

1. Edit file yang berisi secret (misalnya `.env.example`)
2. Ganti dengan placeholder:
   ```bash
   sed -i '' 's/MAIL_PASSWORD="xsmtpsib.*"/MAIL_PASSWORD=your_sendinblue_smtp_password_here/' .env.example
   ```
3. Commit perubahan:
   ```bash
   git add .env.example
   git commit -m "Remove sensitive credentials from example files"
   ```
4. Push ulang

### Solusi 2: Reset dan Re-commit (Jika Secret Sudah di History)

Jika secret sudah ter-commit sebelumnya:

```bash
# 1. Reset commit terakhir (jaga file tetap ada)
git reset --soft HEAD~1

# 2. Pastikan file sudah di-fix (hapus secret)
# Edit file secara manual atau gunakan sed

# 3. Commit ulang
git add .
git commit -m "Initial commit: SiDarku - Platform Kesehatan Remaja Putri"

# 4. Force push
git push -u origin main --force
```

### Solusi 3: Menggunakan GitHub Secret Scanning Unblock

Jika Anda yakin secret tersebut tidak berbahaya (misalnya sudah expired):

1. Buka URL yang diberikan GitHub saat error
2. Ikuti instruksi untuk unblock secret
3. Push ulang

**⚠️ TIDAK DISARANKAN** untuk unblock secret yang masih aktif!

## 📝 Command yang Lengkap (Copy-Paste Ready)

```bash
# 1. Navigate ke project directory
cd /Users/Luthfi/Project/sidarku

# 2. Initialize git (jika belum)
git init

# 3. Add remote
git remote add origin https://github.com/mocitaz/SiDarku.git

# 4. Check remote
git remote -v

# 5. Check status
git status

# 6. Add semua file
git add .

# 7. Commit
git commit -m "Initial commit: SiDarku - Platform Kesehatan Remaja Putri"

# 8. Set branch
git branch -M main

# 9. Push
git push -u origin main
```

## 🔍 Troubleshooting

### Error: "remote: Repository not found"

**Penyebab:** Repository belum dibuat di GitHub atau URL salah

**Solusi:**
1. Pastikan repository sudah dibuat di https://github.com/mocitaz/SiDarku
2. Cek URL remote: `git remote -v`
3. Perbaiki URL jika salah: `git remote set-url origin https://github.com/mocitaz/SiDarku.git`

### Error: "Authentication failed"

**Penyebab:** Belum login ke GitHub

**Solusi:**
1. Gunakan Personal Access Token (PAT)
2. Atau setup SSH key
3. Atau gunakan GitHub CLI: `gh auth login`

### Error: "Push cannot contain secrets"

**Penyebab:** Ada secret di file yang di-commit

**Solusi:**
1. Hapus secret dari semua file
2. Gunakan placeholder
3. Reset commit dan commit ulang
4. Push dengan force jika perlu

### Error: "Updates were rejected because the remote contains work"

**Penyebab:** Repository di GitHub sudah ada file yang berbeda

**Solusi:**
```bash
# Pull dulu, lalu merge
git pull origin main --allow-unrelated-histories

# Atau force push (HATI-HATI!)
git push -u origin main --force
```

## 🔐 Setup Authentication

### Opsi 1: Personal Access Token (PAT)

1. Buat PAT di GitHub: Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Copy token
3. Saat push, gunakan token sebagai password:
   ```bash
   Username: mocitaz
   Password: <your-token>
   ```

### Opsi 2: SSH Key

1. Generate SSH key:
   ```bash
   ssh-keygen -t ed25519 -C "your_email@example.com"
   ```

2. Add SSH key ke GitHub: Settings → SSH and GPG keys → New SSH key

3. Update remote URL:
   ```bash
   git remote set-url origin git@github.com:mocitaz/SiDarku.git
   ```

### Opsi 3: GitHub CLI

```bash
# Install GitHub CLI
brew install gh

# Login
gh auth login

# Clone atau push akan otomatis menggunakan credential
```

## 📚 Best Practices

1. **Jangan commit file .env** - Gunakan .env.example dengan placeholder
2. **Commit message yang jelas** - Jelaskan apa yang diubah
3. **Jangan commit vendor/node_modules** - Gunakan .gitignore
4. **Review sebelum push** - Cek `git status` dan `git diff`
5. **Jangan force push ke main branch** jika ada collaborator
6. **Gunakan branch** untuk fitur baru:
   ```bash
   git checkout -b feature/nama-fitur
   git push -u origin feature/nama-fitur
   ```

## 🎯 Quick Reference

| Command | Deskripsi |
|---------|-----------|
| `git status` | Lihat status file |
| `git add .` | Tambah semua file ke staging |
| `git commit -m "message"` | Commit dengan message |
| `git push -u origin main` | Push ke GitHub |
| `git log` | Lihat history commit |
| `git remote -v` | Lihat remote repository |
| `git pull origin main` | Pull perubahan dari GitHub |

## ✅ Checklist Sebelum Push

- [ ] File `.env` sudah di-ignore (tidak di-commit)
- [ ] File example tidak berisi secret real
- [ ] `.gitignore` sudah benar
- [ ] Commit message sudah jelas
- [ ] Sudah test aplikasi berjalan
- [ ] Tidak ada file sensitive yang ter-commit
- [ ] Remote repository sudah benar

## 🆘 Butuh Bantuan?

Jika masih mengalami masalah:
1. Cek error message dengan detail
2. Cari solusi di GitHub Documentation
3. Buat issue di repository GitHub
4. Atau tanyakan di forum/community

---

**Selamat! 🎉 Code Anda sudah ter-push ke GitHub!**


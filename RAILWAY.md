# Deploy ke Railway - Absensi Staff

## ✅ Persiapan Lokal

Pastikan project bisa jalan lokal sebelum deploy:

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Jika semua berjalan tanpa error, project siap dideploy!

## 🚀 Langkah Deploy ke Railway

### 1. Push ke GitHub

```bash
git add .
git commit -m "Ready for Railway deployment"
git push origin main
```

### 2. Buat Project di Railway

1. Login ke [Railway.app](https://railway.app)
2. Klik **"New Project"**
3. Pilih **"Deploy from GitHub repo"**
4. Pilih repository `absensi-siswa`
5. Railway akan otomatis mendeteksi Laravel dan mulai build

### 3. Tambahkan Database MySQL

1. Di project Railway, klik **"New"** → **"Database"** → **"MySQL"**
2. Railway akan membuat MySQL database baru
3. Catat kredensial database yang diberikan

### 4. Set Environment Variables

Di service Laravel kamu, buka tab **"Variables"** dan tambahkan:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxx  # Generate dengan: php artisan key:generate --show
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app  # Dari Railway MySQL
DB_PORT=3306
DB_DATABASE=railway  # Dari Railway MySQL
DB_USERNAME=root  # Dari Railway MySQL
DB_PASSWORD=xxxxx  # Dari Railway MySQL
```

**Cara generate APP_KEY:**
```bash
php artisan key:generate --show
```
Copy hasilnya ke `APP_KEY` di Railway.

### 5. Jalankan Migration & Seeder

Setelah deploy pertama berhasil, buka tab **"Deployments"** → klik deployment terbaru → **"View Logs"** atau gunakan **"Shell"**.

Jalankan command berikut:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Catatan:** 
- `--force` wajib di production (tanpa konfirmasi)
- Seeder sudah diperbaiki, tidak akan error jika dijalankan berkali-kali

### 6. Akses Aplikasi

Setelah deployment sukses, buka URL yang diberikan Railway:
- Contoh: `https://absensi-staff-production.up.railway.app`

**Login Admin:**
- Email: `admin@absensi.test`
- Password: `password`

## 📁 File Konfigurasi

Project ini sudah include:

- ✅ `Procfile` - Start command untuk Railway
- ✅ `railway.json` - Konfigurasi build & deploy
- ✅ `nixpacks.toml` - Konfigurasi PHP & Composer
- ✅ Seeder yang aman (tidak error jika dijalankan berkali-kali)

## ⚠️ Catatan Penting

### Upload File (Foto & PDF)

Fitur absen staff menggunakan upload file ke `storage/app/public`.

**Masalah:** Di Railway, filesystem bersifat **ephemeral** (file hilang saat redeploy/restart).

**Solusi untuk Production:**

1. **Gunakan Object Storage** (Recommended):
   - Setup AWS S3, DigitalOcean Spaces, atau Cloudflare R2
   - Update `config/filesystems.php` untuk menggunakan S3 driver
   - File akan tersimpan permanen

2. **Railway Volume** (jika tersedia):
   - Tambahkan Volume di Railway
   - Mount ke `/app/storage/app/public`
   - File akan persist

3. **Untuk Testing/Demo:**
   - File akan hilang saat redeploy, tapi aplikasi tetap berfungsi
   - Pastikan jalankan `php artisan storage:link` setelah deploy

### Troubleshooting

**Error: "No application encryption key"**
- Pastikan `APP_KEY` sudah di-set di Railway Variables
- Generate dengan: `php artisan key:generate --show`

**Error: "Database connection failed"**
- Cek semua variable `DB_*` sudah benar
- Pastikan MySQL service sudah running di Railway

**Error: "Storage link failed"**
- Jalankan manual: `php artisan storage:link`
- Pastikan folder `public/storage` bisa diakses

**Seeder error: "Duplicate entry"**
- ✅ Sudah diperbaiki! Seeder sekarang menggunakan `firstOrCreate()` 
- Aman dijalankan berkali-kali tanpa error

## 🔄 Update/Redepoy

Setelah update code:

1. Push ke GitHub
2. Railway otomatis rebuild & redeploy
3. Jika ada migration baru, jalankan: `php artisan migrate --force`
4. Clear cache: `php artisan config:clear && php artisan cache:clear`

## 📞 Support

Jika ada masalah saat deploy, cek:
- Railway deployment logs
- Environment variables sudah lengkap
- Database sudah connected
- Migration sudah dijalankan


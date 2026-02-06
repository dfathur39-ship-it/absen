# Aplikasi Absensi Staff

Aplikasi web absensi staff berbasis Laravel dengan absen menggunakan upload foto + status (hadir/sakit/izin) serta lampiran PDF untuk sakit/izin.

## Fitur Utama

✅ **Autentikasi Multi-Role**
- Admin dapat login (tidak bisa register)
- Staff dapat login dan register menggunakan nama + email (tanpa NIS)

✅ **Dashboard**
- Dashboard berbeda untuk Admin dan Staff
- Statistik real-time absensi
- Grafik absensi 7 hari terakhir (Admin)

✅ **Profil Data**
- Edit profil pengguna
- Update password
- Data staff (untuk staff)

✅ **Absen Staff**
- Staff absen dengan upload foto
- Pilih status: hadir / sakit / izin
- Jika sakit/izin: wajib keterangan + lampiran PDF

✅ **Manajemen Data**
- CRUD Kelas (Admin only)
- CRUD Staff (Admin only)
- Input absensi manual (Admin)
- Rekap absensi bulanan & tahunan

✅ **Laporan**
- Download laporan PDF (Harian, Bulanan, Tahunan)

## Teknologi yang Digunakan

- **Backend**: Laravel 10.x
- **Database**: MySQL (via Laragon)
- **Frontend**: Bootstrap 5, Chart.js
- **Server**: Laragon (Apache/Nginx + PHP + MySQL)

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Laragon (atau XAMPP/WAMP)
- MySQL/MariaDB
- DBeaver (untuk manajemen database)
- Visual Studio Code

## Instalasi

### 1. Clone/Download Project

Pastikan project sudah ada di folder Laragon:
```
C:\laragon\www\absensi-siswa
```

### 2. Install Dependencies

Buka terminal di folder project dan jalankan:

```bash
composer install
```

### 3. Setup Environment

Copy file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Atau secara manual:
- Buka `.env.example`
- Copy semua isinya
- Buat file baru bernama `.env`
- Paste isinya ke file `.env`

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_siswa
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan**: 
- `DB_DATABASE`: Buat database baru di Laragon/DBeaver dengan nama `absensi_siswa`
- `DB_PASSWORD`: Kosongkan jika menggunakan default Laragon

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buka Laragon → Database → MySQL atau gunakan DBeaver untuk membuat database baru:

**Via DBeaver:**
1. Buka DBeaver
2. Connect ke MySQL (localhost:3306)
3. Buat database baru: `absensi_siswa`
4. Set charset: `utf8mb4`, collation: `utf8mb4_unicode_ci`

**Via Laragon Terminal:**
```sql
CREATE DATABASE absensi_siswa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Jalankan Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Ini akan membuat:
- Tabel-tabel database (users, kelas, siswa, absensi)
- User admin default
- Data kelas dan siswa contoh

### 8. Setup Storage Link (Optional)

Jika ingin upload foto:

```bash
php artisan storage:link
```

### 9. Jalankan Development Server

**Via Laragon:**
- Start Laragon
- Pastikan Apache/Nginx dan MySQL running
- Akses: `http://absensi-siswa.test` atau `http://localhost/absensi-siswa/public`

**Via Artisan (Alternative):**
```bash
php artisan serve
```
Akses: `http://localhost:8000`

## Kredensial Default

Setelah menjalankan seeder, gunakan kredensial berikut:

### Admin
- **Email**: `admin@absensi.test`
- **Password**: `password`

### Staff
- Staff dapat register menggunakan nama + email (tanpa NIS)

## Cara Menggunakan

### Untuk Admin

1. **Login**
   - Buka halaman login
   - Masukkan email: `admin@absensi.test`
   - Masukkan password: `password`
   - Setelah login, akan redirect ke dashboard admin

2. **Input Absensi Manual (Admin)**
   - Klik menu "Absensi Harian"
   - Pilih kelas dan staff
   - Input status absensi (Hadir/Izin/Sakit/Alpha)

3. **Manajemen Data**
   - **Kelas**: Tambah/edit/hapus kelas
   - **Staff**: Tambah/edit/hapus staff

4. **Laporan**
   - Klik menu "Download Report"
   - Pilih periode (Harian/Bulanan/Tahunan)
   - Download PDF

### Untuk Staff

1. **Register**
   - Klik "Daftar di sini" di halaman login
   - Isi nama, email, jenis kelamin, dan password
   - Setelah register, otomatis login ke dashboard

2. **Login**
   - Masukkan email dan password yang sudah didaftarkan
   - Setelah login, akan redirect ke dashboard staff

3. **Absen (Foto + Status)**
   - Pastikan sudah login
   - Buka menu **Absen (Foto)**
   - Upload foto dan pilih status hadir/sakit/izin
   - Jika sakit/izin: isi keterangan + lampirkan PDF

4. **Lihat Profil**
   - Klik menu "Profil"
   - Edit data profil
   - Update password jika perlu

## Struktur Database

### Tabel `users`
- `id`, `name`, `email`, `password`, `role` (admin/siswa)
- `siswa_id`, `kelas_id` (untuk staff)

### Tabel `kelas`
- `id`, `nama_kelas`, `tingkat`, `jurusan`, `wali_kelas`, `tahun_ajaran`

### Tabel `siswa`
- `id`, `nis` (unique), `nama_lengkap`, `jenis_kelamin`, `kelas_id`

### Tabel `absensi`
- `id`, `siswa_id`, `kelas_id`, `tanggal`, `waktu_masuk`, `status`

## Troubleshooting

### Error: "SQLSTATE[HY000] [1045] Access denied"
- Pastikan username dan password database di `.env` benar
- Pastikan MySQL service di Laragon sudah running

### Error: "No application encryption key"
- Jalankan: `php artisan key:generate`

### QR Code tidak muncul
Bagian ini sudah tidak digunakan karena fitur QR dihapus.

### Halaman blank setelah login
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`

### Database tidak ditemukan
- Pastikan database sudah dibuat di Laragon/DBeaver
- Cek nama database di `.env` sesuai dengan yang dibuat

## Development

### Menambah Data Staff Baru

1. Login sebagai admin
2. Menu: Data Staff → Tambah Staff
3. Isi form (ID Staff bisa dikosongkan untuk auto-generate)

### Menambah Kelas Baru

1. Login sebagai admin
2. Menu: Data Kelas → Tambah Kelas
3. Isi form kelas

## Support

Untuk pertanyaan atau masalah, silakan hubungi developer atau buat issue di repository.

## License

MIT License

# Cara Login untuk Staff - Panduan Singkat

## ✅ Langkah-Langkah Login Staff

### 1. Buka Halaman Login
- Akses: `http://absensi-siswa.test/login`
- Atau: `http://localhost/absensi-siswa/public/login`
- Atau: `http://localhost:8000/login` (jika pakai `php artisan serve`)

### 2. Masukkan Kredensial
- **Email**: Email yang digunakan saat register
- **Password**: Password yang dibuat saat register
- **Ingat saya** (opsional): Centang jika ingin tetap login

### 3. Klik "Masuk"
- Jika berhasil → Redirect ke Dashboard Staff
- Jika gagal → Cek email dan password

---

## 📋 Syarat Login Staff

✅ **Harus sudah register terlebih dahulu**
- Buka: `http://absensi-siswa.test/register`
- Isi nama, email, dan password

✅ **Email dan password harus benar**
- Email harus sesuai dengan yang digunakan saat register
- Password harus sesuai (case-sensitive)

---

## 🎯 Setelah Login Berhasil

Staff akan melihat:
- ✅ Dashboard Staff dengan informasi pribadi
- ✅ Email, Unit, Status Absen Hari Ini
- ✅ Rekap Bulan Ini (Hadir, Izin, Sakit, Alpha)
- ✅ Riwayat Absensi Terbaru
- ✅ Form absen (upload foto + status)

---

## 🔐 Jika Lupa Password

**Saat ini belum ada fitur reset password otomatis.**

**Solusi:**
1. Hubungi admin untuk reset password
2. Admin bisa reset via database atau artisan command

**Admin bisa reset dengan:**
```bash
php artisan tinker
```

Kemudian:
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'email_staff@email.com')->first();
$user->password = Hash::make('passwordbaru123');
$user->save();
```

---

## ⚠️ Troubleshooting

### Error: "Email atau password salah"
**Solusi:**
- Pastikan email benar (cek typo)
- Pastikan password benar (case-sensitive)
- Pastikan sudah register terlebih dahulu
- Coba clear browser cache

### Error: "Tidak bisa login"
**Solusi:**
- Pastikan sudah register terlebih dahulu
- Pastikan staff sudah aktif (jika nonaktif, hubungi admin)
- Cek apakah akun masih aktif

### Setelah login, tidak redirect ke dashboard
**Solusi:**
- Refresh halaman
- Clear browser cache
- Coba logout dan login lagi

### Dashboard kosong atau error
**Solusi:**
- Hubungi admin untuk memastikan data staff benar

---

## 📱 Login via HP (Mobile)

Staff juga bisa login menggunakan HP:
1. Buka browser di HP (Chrome, Firefox, Safari, dll)
2. Akses: `http://absensi-siswa.test/login`
3. Masukkan email dan password
4. Login berhasil → Dashboard staff akan tampil di HP

**Keuntungan login via HP:**
- Bisa langsung absen dengan upload foto
- Lebih mudah dan praktis
- Bisa absen langsung dari HP

---

## ✅ Checklist Sebelum Login

- [ ] Sudah register dengan nama + email
- [ ] Ingat email yang digunakan saat register
- [ ] Ingat password yang dibuat
- [ ] Koneksi internet aktif

---

## 🎓 Contoh Login

**Contoh jika sudah register:**
- Email: `staff1@email.com`
- Password: `password123`

**Langkah:**
1. Buka `http://absensi-siswa.test/login`
2. Masukkan email: `staff1@email.com`
3. Masukkan password: `password123`
4. Klik "Masuk"
5. ✅ Berhasil → Dashboard Staff muncul

---

**Selamat menggunakan aplikasi!**

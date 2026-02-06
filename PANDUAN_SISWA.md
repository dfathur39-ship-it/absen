# Panduan Lengkap untuk Staff - Aplikasi Absensi Staff

## 📋 Daftar Isi
1. [Cara Register Akun](#cara-register-akun)
2. [Cara Login](#cara-login)
3. [Dashboard Staff](#dashboard-staff)
4. [Cara Absen (Foto + Status)](#cara-absen-foto--status)
5. [Edit Profil](#edit-profil)
6. [Troubleshooting](#troubleshooting)

---

## 1. Cara Register Akun

### Syarat Register:
- ✅ Email belum pernah digunakan
- ✅ Password minimal 8 karakter

### Langkah-Langkah:

1. **Buka halaman register**
   - Akses: `http://absensi-siswa.test/register`
   - Atau klik "Daftar di sini" di halaman login

2. **Isi form register:**
   - **Nama**: Isi nama lengkap staff
   - **Email**: Masukkan email yang valid
     - Contoh: `staff1@email.com`, `nama.staff@gmail.com`
     - Email harus unik (belum pernah digunakan)
   - **Jenis kelamin**: L / P
   - **Password**: Minimal 8 karakter
     - Contoh: `password123`, `staff2026`, dll
   - **Konfirmasi Password**: Ketik ulang password yang sama

3. **Klik "Daftar Sekarang"**
   - Jika berhasil, Anda akan otomatis login
   - Redirect ke dashboard siswa

### Catatan Penting:
- ⚠️ **Admin tidak bisa register** - Hanya staff yang bisa register

---

## 2. Cara Login

### Langkah-Langkah:

1. **Buka halaman login**
   - Akses: `http://absensi-siswa.test/login`
   - Atau langsung dari halaman utama

2. **Masukkan kredensial:**
   - **Email**: Email yang digunakan saat register
   - **Password**: Password yang dibuat saat register
   - **Ingat saya** (opsional): Centang jika ingin tetap login

3. **Klik "Masuk"**
   - Jika berhasil, redirect ke dashboard staff
   - Jika gagal, cek email dan password

### Lupa Password?
- Saat ini belum ada fitur reset password
- Hubungi admin untuk reset password
- Atau admin bisa reset via database

---

## 3. Dashboard Staff

Setelah login, Anda akan melihat dashboard dengan informasi:

### Informasi Personal:
- **Email**: Email akun Anda
- **Unit**: Unit/bagian Anda saat ini
- **Status Absen Hari Ini**: Hadir/Izin/Sakit/Alpha

### Rekap Bulan Ini:
- **Hadir**: Jumlah hari hadir bulan ini
- **Izin**: Jumlah hari izin bulan ini
- **Sakit**: Jumlah hari sakit bulan ini
- **Alpha**: Jumlah hari alpha bulan ini

### Riwayat Absensi Terbaru:
- Tabel menampilkan 15 absensi terbaru
- Menampilkan: Tanggal, Status, Waktu Masuk

### Informasi Absen:
- Tombol menuju halaman absen (upload foto)
- Jika sakit/izin wajib keterangan + PDF

---

## 4. Cara Absen (Foto + Status)

### Langkah-Langkah:

1. **Pastikan sudah login**
   - Login ke aplikasi menggunakan HP atau laptop
   - Buka dashboard staff

2. **Buka halaman absen**
   - Klik menu **Absen (Foto)** di sidebar

3. **Isi form absen**
   - Upload **foto**
   - Pilih status **hadir/sakit/izin**
   - Jika **sakit/izin**: isi **keterangan** + upload **PDF**

4. **Simpan**
   - Setelah disimpan, akan muncul pesan sukses
   - Status absen hari ini akan ter-update

### Catatan Penting:
- ⚠️ **Hanya bisa absen sekali per hari** - Jika sudah absen, tidak bisa absen lagi
- ⚠️ **Harus sudah login** - Pastikan sudah login sebelum absen

---

## 5. Edit Profil

### Langkah-Langkah:

1. **Buka halaman profil**
   - Klik menu "Profil" di sidebar
   - Atau klik avatar di kanan atas → Profil

2. **Edit data profil:**
   - **Nama**: Bisa diubah
   - **Email**: Bisa diubah (harus unik)
   - **NIS**: Tidak bisa diubah (dari database)
   - **No. Telepon**: Bisa diubah
   - **Alamat**: Bisa diubah

3. **Ubah password (opsional):**
   - Isi "Password Baru" jika ingin mengubah password
   - Isi "Konfirmasi Password"
   - Kosongkan jika tidak ingin mengubah password

4. **Klik "Simpan Perubahan"**
   - Data akan tersimpan
   - Muncul notifikasi sukses

### Catatan:
- NIS dan Kelas tidak bisa diubah (harus melalui admin)
- Password minimal 8 karakter
- Email harus unik (tidak boleh sama dengan user lain)

---

## 6. Troubleshooting

### Masalah: NIS tidak ditemukan saat register
**Solusi:**
- Abaikan: register staff tidak membutuhkan NIS

### Masalah: Email sudah terdaftar
**Solusi:**
- Gunakan email lain yang belum pernah digunakan
- Atau hubungi admin jika email Anda sudah digunakan

### Masalah: Tidak bisa login
**Solusi:**
- Pastikan email dan password benar
- Cek apakah caps lock aktif
- Pastikan sudah register terlebih dahulu
- Hubungi admin jika masih tidak bisa

### Masalah: Sudah absen tapi tidak tercatat
**Solusi:**
- Refresh dashboard untuk melihat update terbaru
- Cek di menu "Riwayat Absensi Terbaru"
- Hubungi admin jika masih tidak muncul

### Masalah: Data staff tidak ditemukan di dashboard
**Solusi:**
- Hubungi admin untuk memastikan data staff lengkap

---

## 📞 Bantuan

Jika mengalami masalah yang tidak bisa diselesaikan:
1. Hubungi admin sekolah
2. Sertakan screenshot error jika ada
3. Jelaskan langkah-langkah yang sudah dilakukan

---

## ✅ Checklist Sebelum Menggunakan Aplikasi

- [ ] Sudah register dengan email dan password
- [ ] Sudah login ke aplikasi
- [ ] Memahami bahwa hanya bisa absen sekali per hari

---

**Selamat menggunakan aplikasi absensi staff!**

# Panduan Admin: Menambahkan Staff Baru

Sebagai admin, Anda dapat menambahkan data staff terlebih dahulu (opsional). Staff juga bisa register sendiri menggunakan nama + email.

## 📋 Cara Menambahkan Staff Baru

### Langkah-Langkah:

1. **Login sebagai Admin**
   - Email: `admin@absensi.test`
   - Password: `password` (atau password yang sudah diubah)

2. **Buka Menu "Data Staff"**
   - Klik menu "Data Staff" di sidebar
   - Atau akses: `http://absensi-siswa.test/siswa`

3. **Klik "Tambah Staff"**
   - Tombol biasanya di kanan atas atau di bawah tabel

4. **Isi Form Data Staff:**
   - **ID Staff** (opsional): Kosongkan untuk auto-generate
   - **Nama Lengkap** (wajib): Nama lengkap staff
   - **Jenis Kelamin**: L (Laki-laki) atau P (Perempuan)
   - **Tempat Lahir**: Tempat lahir (opsional)
   - **Tanggal Lahir**: Tanggal lahir (opsional)
   - **Alamat**: Alamat (opsional)
   - **No. Telepon**: Nomor telepon (opsional)
   - **Email**: Email (opsional)
   - **Unit/Kelas**: Pilih unit/bagian (wajib)
   - **Status Aktif**: Centang jika staff aktif

5. **Klik "Simpan"**
   - Data siswa akan tersimpan
   - Siswa sekarang bisa register menggunakan NIS tersebut

## ✅ Setelah Staff Ditambahkan

Staff dapat:
1. Buka halaman register: `http://absensi-siswa.test/register`
2. Isi nama, email, jenis kelamin, dan password
3. Register berhasil dan otomatis login

## 📝 Tips untuk Admin

### 1. ID Staff Unik (jika diisi)
- Jika Anda mengisi ID Staff manual, pastikan unik
- Jika kosong, sistem akan auto-generate

### 2. Pastikan Unit/Kelas Sudah Ada
- Sebelum menambahkan staff, pastikan unit/kelas sudah dibuat
- Buka menu "Data Kelas" untuk menambahkan kelas baru

### 3. Status Aktif
- Nonaktifkan staff jika sudah tidak aktif

### 4. Batch Import (Manual)
- Saat ini belum ada fitur import Excel
- Tambahkan siswa satu per satu atau gunakan seeder untuk data contoh

## 🔍 Cara Melihat Daftar Staff

1. Buka menu "Data Staff"
2. Tabel menampilkan:
   - ID Staff
   - Nama Lengkap
   - Unit/Kelas
   - Status (Aktif/Tidak Aktif)
   - Aksi (Edit/Hapus)

## ✏️ Edit Data Staff

1. Klik tombol "Edit" pada siswa yang ingin diubah
2. Ubah data yang diperlukan
3. Klik "Simpan"
4. Data akan terupdate

## 🗑️ Hapus Staff

1. Klik tombol "Hapus" pada siswa yang ingin dihapus
2. Konfirmasi penghapusan
3. ⚠️ Hati-hati: Jika staff sudah memiliki akun, hapus akun terlebih dahulu

## 🔐 Reset Password Staff

Jika siswa lupa password, admin bisa reset via database:

### Via Artisan Command:
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

### Via DBeaver:
1. Buka tabel `users`
2. Cari staff berdasarkan email
3. Update kolom `password` dengan hash baru
4. Generate hash via tinker (lihat di atas)

## 📊 Data Contoh dari Seeder

Jika sudah menjalankan `php artisan db:seed`, data contoh mungkin masih bertuliskan "siswa" (legacy).

## ⚠️ Catatan Penting

1. **Siswa harus ditambahkan admin dulu** sebelum bisa register
2. **NIS adalah kunci** - Siswa harus tahu NIS mereka untuk register
3. **Satu NIS = Satu Akun** - Setiap NIS hanya bisa digunakan sekali untuk register
4. **Email harus unik** - Setiap siswa harus menggunakan email yang berbeda

## 🆘 Troubleshooting

### Siswa tidak bisa register dengan NIS tertentu
- Cek apakah NIS sudah ditambahkan di "Data Siswa"
- Pastikan status siswa "Aktif"
- Pastikan NIS yang dimasukkan benar (tanpa spasi)

### NIS sudah digunakan
- Cek apakah siswa sudah memiliki akun
- Lihat di tabel `users` dengan `siswa_id` yang sesuai
- Jika perlu, reset akun siswa tersebut

### Kelas tidak muncul saat tambah siswa
- Pastikan kelas sudah dibuat di menu "Data Kelas"
- Pastikan kelas memiliki status "Aktif"

---

**Selamat mengelola data siswa!** 👨‍💼

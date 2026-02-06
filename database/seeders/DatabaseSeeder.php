<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (hanya bisa login, tidak bisa register)
        User::firstOrCreate(
            ['email' => 'admin@absensi.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Kelas contoh (opsional, untuk backward compatibility)
        $kelasData = [
            ['nama_kelas' => 'STAFF', 'tingkat' => 'STAFF', 'jurusan' => null, 'wali_kelas' => null, 'tahun_ajaran' => now()->year],
        ];

        foreach ($kelasData as $k) {
            Kelas::firstOrCreate(
                ['nama_kelas' => $k['nama_kelas'], 'tingkat' => $k['tingkat']],
                $k
            );
        }

        // Staff contoh (opsional, untuk testing)
        $namaLaki = ['Ahmad', 'Budi', 'Cahyo', 'Dani', 'Eko'];
        $namaPerempuan = ['Anisa', 'Bella', 'Citra', 'Dina', 'Eka'];
        $namaBelakang = ['Pratama', 'Saputra', 'Wijaya', 'Kusuma', 'Santoso'];

        $staffId = 1;
        $kelasStaff = Kelas::where('nama_kelas', 'STAFF')->first();
        if ($kelasStaff) {
            for ($i = 0; $i < 5; $i++) {
                $isLaki = $i < 3;
                $namaDepan = $isLaki ? $namaLaki[array_rand($namaLaki)] : $namaPerempuan[array_rand($namaPerempuan)];
                $nama = $namaDepan . ' ' . $namaBelakang[array_rand($namaBelakang)];
                $nis = 'STF-' . now()->format('Ymd') . '-' . str_pad($staffId, 3, '0', STR_PAD_LEFT);

                Siswa::firstOrCreate(
                    ['nis' => $nis],
                    [
                        'nama_lengkap' => $nama,
                        'jenis_kelamin' => $isLaki ? 'L' : 'P',
                        'tempat_lahir' => 'Jakarta',
                        'tanggal_lahir' => Carbon::now()->subYears(rand(25, 40)),
                        'alamat' => 'Jl. Contoh No. ' . rand(1, 50),
                        'no_telepon' => '08' . rand(100000000, 999999999),
                        'kelas_id' => $kelasStaff->id,
                        'is_active' => true,
                    ]
                );
                $staffId++;
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin login: admin@absensi.test');
        $this->command->info('🔑 Password: password');
        $this->command->info('👥 Staff dapat register menggunakan nama + email di halaman register.');
    }
}

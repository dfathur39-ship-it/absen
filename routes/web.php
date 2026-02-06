<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\StaffAbsenController;
use Illuminate\Support\Facades\Route;

// Guest: redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login untuk semua (admin & staff)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Register untuk Staff (admin tidak bisa register)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (setelah login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Absen Staff (foto + status + PDF jika sakit/izin)
    Route::get('/absen', [StaffAbsenController::class, 'create'])->name('staff.absen.create');
    Route::post('/absen', [StaffAbsenController::class, 'store'])->name('staff.absen.store');

    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin only: Kelas, Siswa, Absensi manual, Report
    Route::middleware('role:admin')->group(function () {
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
        Route::resource('siswa', SiswaController::class);

        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::post('/absensi/quick', [AbsensiController::class, 'quickAttendance'])->name('absensi.quick');
        Route::get('/absensi/bulanan', [AbsensiController::class, 'bulanan'])->name('absensi.bulanan');
        Route::get('/absensi/tahunan', [AbsensiController::class, 'tahunan'])->name('absensi.tahunan');

        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::post('/report/download/harian', [ReportController::class, 'downloadHarian'])->name('report.download.harian');
        Route::post('/report/download/bulanan', [ReportController::class, 'downloadBulanan'])->name('report.download.bulanan');
        Route::post('/report/download/tahunan', [ReportController::class, 'downloadTahunan'])->name('report.download.tahunan');
    });
});

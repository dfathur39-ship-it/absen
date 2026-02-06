<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAbsenController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Pastikan akun staff terhubung ke profil (pakai relasi siswa yang dipakai sebagai staff)
        if (! $user->siswa_id) {
            return redirect()->route('dashboard')->with('error', 'Profil staff belum lengkap. Hubungi admin.');
        }

        $existing = Absensi::where('siswa_id', $user->siswa_id)
            ->whereDate('tanggal', $today)
            ->first();

        return view('staff_absen.create', compact('user', 'today', 'existing'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        if (! $user->siswa_id) {
            return redirect()->route('dashboard')->with('error', 'Profil staff belum lengkap. Hubungi admin.');
        }

        $existing = Absensi::where('siswa_id', $user->siswa_id)
            ->whereDate('tanggal', $today)
            ->first();
        if ($existing) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah melakukan absen hari ini (' . $existing->status . ').');
        }

        $validated = $request->validate([
            'status' => 'required|in:hadir,izin,sakit',
            'foto' => 'required|image|max:4096',
            'keterangan' => 'required_if:status,izin,sakit|nullable|string|max:1000',
            'pdf' => 'required_if:status,izin,sakit|file|mimes:pdf|max:5120',
        ]);

        $fotoPath = $request->file('foto')->store('absensi/foto', 'public');
        $pdfPath = null;

        if (in_array($validated['status'], ['izin', 'sakit'], true) && $request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('absensi/keterangan', 'public');
        }

        $kelasId = $user->kelas_id ?? $user->siswa?->kelas_id;
        if (! $kelasId) {
            $kelasStaff = Kelas::firstOrCreate(
                ['nama_kelas' => 'STAFF', 'tingkat' => 'STAFF'],
                ['jurusan' => null, 'wali_kelas' => null, 'tahun_ajaran' => now()->year, 'is_active' => true]
            );
            $kelasId = $kelasStaff->id;
        }

        Absensi::create([
            'siswa_id' => $user->siswa_id,
            'kelas_id' => $kelasId,
            'tanggal' => $today,
            'waktu_masuk' => now()->format('H:i:s'),
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'] ?? null,
            'foto_bukti' => $fotoPath,
            'pdf_keterangan' => $pdfPath,
            'recorded_by' => $user->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Absen berhasil disimpan.');
    }
}


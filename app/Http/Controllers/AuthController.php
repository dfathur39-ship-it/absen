<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Register untuk Staff. Admin tidak bisa register.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $kelasStaff = Kelas::firstOrCreate(
            ['nama_kelas' => 'STAFF', 'tingkat' => 'STAFF'],
            ['jurusan' => null, 'wali_kelas' => null, 'tahun_ajaran' => now()->year, 'is_active' => true]
        );

        // Simpan profil staff ke tabel siswa (dipakai sebagai master staff agar laporan tetap jalan)
        $nisAuto = 'STF-' . now()->format('YmdHis') . '-' . random_int(100, 999);
        $siswa = Siswa::create([
            'nis' => $nisAuto,
            'nama_lengkap' => $request->name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $kelasStaff->id,
            'email' => $request->email,
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // secara tampilan disebut "staff"
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelasStaff->id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di Absensi Staff.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}

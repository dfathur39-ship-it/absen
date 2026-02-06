<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(15);
        $kelas = Kelas::where('is_active', true)->get();

        return view('siswa.index', compact('siswa', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::where('is_active', true)->get();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'nullable|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');
        if (empty($data['nis'])) {
            $data['nis'] = 'STF-' . now()->format('YmdHis') . '-' . random_int(100, 999);
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($data);

        return redirect()->route('siswa.index')->with('success', 'Staff berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::where('is_active', true)->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'nullable|unique:siswa,nis,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');
        if (empty($data['nis'])) {
            $data['nis'] = $siswa->nis;
        }

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data staff berhasil diupdate!');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Staff berhasil dihapus!');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'absensi' => fn ($q) => $q->orderBy('tanggal', 'desc')->limit(30)]);
        return view('siswa.show', compact('siswa'));
    }
}

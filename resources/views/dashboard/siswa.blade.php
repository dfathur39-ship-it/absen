@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="live-clock h-100">
            <div class="clock-time" id="liveClock">00:00:00</div>
            <div class="clock-date" id="liveDate">Loading...</div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row g-3">
            @if($siswa)
                <div class="col-6 col-md-4">
                    <div class="stat-card primary">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon primary"><i class="bi bi-envelope-at-fill"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.1rem;">{{ Auth::user()->email }}</div>
                                <div class="stat-label">Email</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="stat-card success">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon success"><i class="bi bi-building"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ $siswa->kelas->tingkat ?? '-' }} {{ $siswa->kelas->nama_kelas ?? '' }}</div>
                                <div class="stat-label">Unit</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="stat-card info">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon info"><i class="bi bi-calendar-check"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ isset($statsHariIni['status']) ? ucfirst($statsHariIni['status']) : '-' }}</div>
                                <div class="stat-label">Absen Hari Ini</div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($statsHariIni['waktu_masuk']) && $statsHariIni['waktu_masuk'])
                <div class="col-6 col-md-4">
                    <div class="stat-card primary">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon primary"><i class="bi bi-clock-history"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ \Carbon\Carbon::parse($statsHariIni['waktu_masuk'])->format('H:i') }}</div>
                                <div class="stat-label">Jam datang</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

@if($siswa)
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-camera-fill me-2 text-primary"></i>Absen Staff (Foto)</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Absen dilakukan dengan upload <strong>foto</strong> dan memilih status <strong>hadir/sakit/izin</strong>. Jika <strong>sakit/izin</strong>, lampirkan <strong>PDF</strong> dan isi keterangan.</p>
                <a href="{{ route('staff.absen.create') }}" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-2"></i>Isi Absen Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@if($siswa)
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Rekap Bulan Ini</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#d1fae5;"><div class="fs-2 fw-bold text-success">{{ $statsBulanIni['hadir'] ?? 0 }}</div><div class="text-success">Hadir</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#fef3c7;"><div class="fs-2 fw-bold text-warning">{{ $statsBulanIni['izin'] ?? 0 }}</div><div class="text-warning">Izin</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#cffafe;"><div class="fs-2 fw-bold text-info">{{ $statsBulanIni['sakit'] ?? 0 }}</div><div class="text-info">Sakit</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#fee2e2;"><div class="fs-2 fw-bold text-danger">{{ $statsBulanIni['alpha'] ?? 0 }}</div><div class="text-danger">Alpha</div></div></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Riwayat Absensi Terbaru</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height:280px;">
                    <table class="table mb-0">
                        <thead style="position:sticky;top:0;background:white;"><tr><th>Tanggal</th><th>Status</th><th>Jam datang</th></tr></thead>
                        <tbody>
                            @forelse($absensiTerbaru as $absen)
                                <tr>
                                    <td>{{ $absen->tanggal->format('d/m/Y') }}</td>
                                    <td>{!! $absen->status_badge !!}</td>
                                    <td>{{ $absen->waktu_masuk ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada riwayat</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">Data staff tidak ditemukan. Hubungi admin.</div>
@endif
@endsection

@push('scripts')
<script>
function updateClock() {
    const now = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString('id-ID');
    document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}
setInterval(updateClock, 1000); updateClock();
</script>
@endpush

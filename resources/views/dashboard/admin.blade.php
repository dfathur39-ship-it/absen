@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="live-clock h-100">
            <div class="clock-time" id="liveClock">00:00:00</div>
            <div class="clock-date" id="liveDate">Loading...</div>
            <div class="mt-3"><i class="bi bi-geo-alt me-1"></i> Indonesia (WIB)</div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-6 col-md-4">
                <div class="stat-card primary">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon primary"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="stat-value">{{ $totalSiswa }}</div>
                            <div class="stat-label">Total Staff</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card info">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon info"><i class="bi bi-percent"></i></div>
                        <div>
                            <div class="stat-value">{{ $persentaseHadir }}%</div>
                            <div class="stat-label">Kehadiran</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Statistik Absensi 7 Hari Terakhir</h5></div>
            <div class="card-body"><canvas id="attendanceChart" height="100"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-calendar-check me-2 text-success"></i>Absensi Hari Ini</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#d1fae5;"><div class="fs-2 fw-bold text-success">{{ $statsHariIni['hadir'] }}</div><div class="text-success">Hadir</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#fef3c7;"><div class="fs-2 fw-bold text-warning">{{ $statsHariIni['izin'] }}</div><div class="text-warning">Izin</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#cffafe;"><div class="fs-2 fw-bold text-info">{{ $statsHariIni['sakit'] }}</div><div class="text-info">Sakit</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#fee2e2;"><div class="fs-2 fw-bold text-danger">{{ $statsHariIni['alpha'] }}</div><div class="text-danger">Alpha</div></div></div>
                </div>
                <hr>
                <h6 class="mb-3">Rekap Bulan Ini</h6>
                <div class="d-flex justify-content-between mb-2"><span>Hadir</span><span class="badge bg-success">{{ $statsBulanIni['hadir'] }}</span></div>
                <div class="d-flex justify-content-between mb-2"><span>Izin</span><span class="badge bg-warning">{{ $statsBulanIni['izin'] }}</span></div>
                <div class="d-flex justify-content-between mb-2"><span>Sakit</span><span class="badge bg-info">{{ $statsBulanIni['sakit'] }}</span></div>
                <div class="d-flex justify-content-between"><span>Alpha</span><span class="badge bg-danger">{{ $statsBulanIni['alpha'] }}</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-clock-history me-2 text-info"></i>Absensi Terbaru</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height:400px;overflow-y:auto;">
                    <table class="table mb-0">
                        <thead style="position:sticky;top:0;background:#f1f5f9;"><tr><th>Staff</th><th>Status</th><th>Waktu</th></tr></thead>
                        <tbody>
                            @forelse($absensiTerbaru as $absen)
                                <tr>
                                    <td>{{ $absen->siswa->nama_lengkap ?? '-' }}</td>
                                    <td>{!! $absen->status_badge !!}</td>
                                    <td><small class="text-muted">{{ $absen->created_at->diffForHumans() }}</small></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data absensi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateClock() {
    const now = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString('id-ID');
    document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}
setInterval(updateClock, 1000); updateClock();
const ctx = document.getElementById('attendanceChart').getContext('2d');
const chartData = @json($chartData);
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.map(d => d.tanggal),
        datasets: [
            { label: 'Hadir', data: chartData.map(d => d.hadir), backgroundColor: '#10b981', borderRadius: 6 },
            { label: 'Izin', data: chartData.map(d => d.izin), backgroundColor: '#f59e0b', borderRadius: 6 },
            { label: 'Sakit', data: chartData.map(d => d.sakit), backgroundColor: '#06b6d4', borderRadius: 6 },
            { label: 'Alpha', data: chartData.map(d => d.alpha), backgroundColor: '#ef4444', borderRadius: 6 }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush

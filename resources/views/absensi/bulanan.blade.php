@extends('layouts.app')

@section('title', 'Rekap Absensi Bulanan')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('absensi.bulanan') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Bulan</label>
                        <select name="bulan" class="form-select">
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tahun</label>
                        <select name="tahun" class="form-select">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(count($absensiData) > 0)
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-month me-2 text-primary"></i>Rekap Absensi {{ $months[$selectedMonth] }} {{ $selectedYear }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" style="font-size: 0.85rem;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle" style="min-width: 50px;">No</th>
                                <th rowspan="2" class="align-middle" style="min-width: 150px;">Nama Staff</th>
                                <th colspan="{{ $daysInMonth }}" class="text-center">Tanggal</th>
                                <th colspan="4" class="text-center">Jumlah</th>
                            </tr>
                            <tr>
                                @for($i = 1; $i <= $daysInMonth; $i++)
                                    <th class="text-center" style="min-width: 30px;">{{ $i }}</th>
                                @endfor
                                <th class="text-center bg-success text-white" style="min-width: 40px;">H</th>
                                <th class="text-center bg-warning" style="min-width: 40px;">I</th>
                                <th class="text-center bg-info text-white" style="min-width: 40px;">S</th>
                                <th class="text-center bg-danger text-white" style="min-width: 40px;">A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensiData as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $data['siswa']->nama_lengkap }}</td>
                                    @for($i = 1; $i <= $daysInMonth; $i++)
                                        @php
                                            $absen = $data['absensi']->get($i);
                                            $status = $absen ? strtoupper(substr($absen->status, 0, 1)) : '-';
                                            $class = match($absen?->status ?? '') {
                                                'hadir' => 'bg-success text-white',
                                                'izin' => 'bg-warning',
                                                'sakit' => 'bg-info text-white',
                                                'alpha' => 'bg-danger text-white',
                                                default => ''
                                            };
                                        @endphp
                                        <td class="text-center {{ $class }}">{{ $status }}</td>
                                    @endfor
                                    <td class="text-center fw-bold">{{ $data['summary']['hadir'] }}</td>
                                    <td class="text-center fw-bold">{{ $data['summary']['izin'] }}</td>
                                    <td class="text-center fw-bold">{{ $data['summary']['sakit'] }}</td>
                                    <td class="text-center fw-bold">{{ $data['summary']['alpha'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

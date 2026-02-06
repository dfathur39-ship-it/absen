@extends('layouts.app')

@section('title', 'Absen Staff')

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1"><i class="bi bi-camera-fill me-2 text-primary"></i>Absen Staff</h5>
                        <div class="text-muted small">
                            Tanggal: <strong>{{ $today->translatedFormat('l, d F Y') }}</strong>
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($existing)
                    <div class="alert alert-info mb-0">
                        Anda sudah absen hari ini. Status: <strong>{{ strtoupper($existing->status) }}</strong>
                    </div>
                @else
                    <form action="{{ route('staff.absen.store') }}" method="POST" enctype="multipart/form-data" id="form-absen-staff">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required id="status-select">
                                    <option value="">-- Pilih status --</option>
                                    <option value="hadir" @selected(old('status')==='hadir')>Hadir</option>
                                    <option value="sakit" @selected(old('status')==='sakit')>Sakit</option>
                                    <option value="izin" @selected(old('status')==='izin')>Izin</option>
                                </select>
                                @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Foto (wajib)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" required>
                                <div class="text-muted small mt-1">Format: JPG/PNG. Maks 4MB.</div>
                                @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Keterangan (wajib jika sakit/izin)</label>
                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: demam, izin urusan keluarga...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Lampiran PDF (wajib jika sakit/izin)</label>
                                <input type="file" name="pdf" class="form-control" accept="application/pdf">
                                <div class="text-muted small mt-1">Format: PDF. Maks 5MB.</div>
                                @error('pdf')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-2"></i>Simpan Absen
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const status = document.getElementById('status-select');
    const form = document.getElementById('form-absen-staff');
    if (!status || !form) return;

    const keterangan = form.querySelector('textarea[name="keterangan"]');
    const pdf = form.querySelector('input[name="pdf"]');

    function syncRequired() {
        const need = status.value === 'izin' || status.value === 'sakit';
        if (keterangan) keterangan.required = need;
        if (pdf) pdf.required = need;
    }

    status.addEventListener('change', syncRequired);
    syncRequired();
})();
</script>
@endpush


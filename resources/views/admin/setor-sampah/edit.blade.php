@extends('layouts.admin')

@section('title', 'Edit Setor Sampah')
@section('header_title', 'Edit Setor Sampah')

@section('content')
<form action="{{ route('admin.setor-sampah.update', $setorSampah->id) }}" method="POST" id="edit-setor-form">
    @csrf
    @method('PUT')
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.setor-sampah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">TRX-S{{ str_pad($setorSampah->id, 4, '0', STR_PAD_LEFT) }}</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm" id="submit-btn">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-12 col-lg-9 mx-auto">
            <!-- Member Info Card (Read-only) -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex justify-content-between align-items-center">
                    <h5 class="admin-card-title mb-0 fw-bold fs-6">Anggota Penyetor</h5>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Terkunci</span>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 48px; height: 48px;">
                            <span class="fw-bold fs-5">{{ substr($setorSampah->user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark text-base">{{ $setorSampah->user->name }}</h6>
                            <span class="text-muted text-xs">ID: {{ $setorSampah->user->nomor_anggota }} | No. HP: {{ $setorSampah->user->no_hp }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Form (Single Item as per Backend) -->
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Edit Detail Rincian Setoran Sampah</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-sm">Tanggal Setor <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-sm" id="tanggal" name="tanggal" value="{{ old('tanggal', $setorSampah->created_at->format('Y-m-d')) }}" style="max-width: 250px;" required>
                    </div>

                    <!-- Container Items -->
                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-2">Item Sampah Diterima</div>
                    <div class="item-row p-3 border rounded-3 bg-light position-relative mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-xs fw-semibold text-muted mb-1">Kategori Sampah</label>
                                <select class="form-select text-sm kategori-select" name="items[0][kategori_id]" required onchange="calculateGrandTotal()">
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat->id }}" data-harga="{{ $kat->harga_beli }}" {{ old('items.0.kategori_id', $setorSampah->kategori_sampah_id) == $kat->id ? 'selected' : '' }}>
                                            {{ $kat->nama }} (Rp {{ number_format($kat->harga_beli, 0, ',', '.') }} / kg)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label text-xs fw-semibold text-muted mb-1">Berat (kg)</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" min="0.1" class="form-control text-sm berat-input" name="items[0][berat]" value="{{ old('items.0.berat', $setorSampah->berat) }}" required oninput="calculateGrandTotal()">
                                    <span class="input-group-text bg-white text-muted text-xs">kg</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label text-xs fw-semibold text-muted mb-1">Subtotal (Rp)</label>
                                <div class="fw-bold text-success text-sm py-2 px-2 bg-white rounded border subtotal-text">Rp {{ number_format($setorSampah->total, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total Summary Card -->
                    <div class="p-3 p-md-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-sm-6 border-end-sm">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Total Berat Keseluruhan</span>
                                <span class="fs-4 fw-bold text-dark" id="total_berat_display">{{ old('items.0.berat', $setorSampah->berat) }} kg</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block">Grand Total Pendapatan</span>
                                <div class="d-flex align-items-center">
                                    <span class="fs-4 fw-bold text-success me-1">Rp</span>
                                    <span class="fs-2 fw-bold text-success" id="grand_total_display">{{ number_format($setorSampah->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@section('scripts')
<script>
    function calculateGrandTotal() {
        const select = document.querySelector('.kategori-select');
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const berat = parseFloat(document.querySelector('.berat-input').value) || 0;
        const subtotal = harga * berat;

        document.querySelector('.subtotal-text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        document.getElementById('total_berat_display').innerText = berat.toFixed(1) + ' kg';
        document.getElementById('grand_total_display').innerText = new Intl.NumberFormat('id-ID').format(subtotal);

        checkFormValidity();
    }

    function checkFormValidity() {
        const hasKategori = document.querySelector('.kategori-select').value !== '';
        const hasBerat = document.querySelector('.berat-input').value > 0;

        document.getElementById('submit-btn').disabled = !(hasKategori && hasBerat);
    }

    // Call on load to ensure initial state matches old or db data
    calculateGrandTotal();
</script>
@endsection
@endsection

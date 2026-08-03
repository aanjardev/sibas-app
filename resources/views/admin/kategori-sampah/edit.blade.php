@extends('layouts.admin')

@section('title', 'Edit Jenis Sampah')
@section('header_title', 'Edit Jenis Sampah')

@section('content')
<form action="#" method="POST" id="edit-kategori-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.kategori-sampah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">Kode: SMP-001</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="admin-card border-0 shadow-sm">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Form Edit Jenis & Harga Sampah</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label for="kode" class="form-label fw-semibold text-sm">Kode Sampah</label>
                            <input type="text" class="form-control text-sm" id="kode" name="kode" value="SMP-001" readonly>
                        </div>
                        <div class="col-12 col-md-8">
                            <label for="nama" class="form-label fw-semibold text-sm">Nama Jenis / Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-sm" id="nama" name="nama" value="Plastik PET (Botol Bening)" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="harga_per_kg" class="form-label fw-semibold text-sm">Harga Beli per Kg (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                <input type="number" step="100" min="0" class="form-control text-sm fw-bold text-success" id="harga_per_kg" name="harga_per_kg" value="3000" required>
                                <span class="input-group-text bg-light text-muted text-sm">/ kg</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="status" class="form-label fw-semibold text-sm">Status Kategori</label>
                            <select class="form-select text-sm" id="status" name="is_active">
                                <option value="1" selected>Aktif (Dapat Dipilih Transaksi)</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold text-sm">Deskripsi / Kriteria Sampah</label>
                        <textarea class="form-control text-sm" id="deskripsi" name="deskripsi" rows="3">Botol plastik air mineral bersih & kering tanpa tutup botol berlebihan.</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

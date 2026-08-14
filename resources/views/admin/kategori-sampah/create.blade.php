@extends('layouts.admin')

@section('title', 'Tambah Jenis Sampah Baru')
@section('header_title', 'Tambah Jenis Sampah Baru')

@section('content')
<form action="{{ route('admin.kategori-sampah.store') }}" method="POST" id="create-kategori-form">
    @csrf
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.kategori-sampah.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-check-lg me-1"></i> Simpan Jenis Sampah
            </button>
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
        <div class="col-12 col-lg-8 mx-auto">
            <div class="admin-card border-0 shadow-sm">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Form Data Jenis & Harga Sampah</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label for="kode" class="form-label fw-semibold text-sm">Kode Sampah</label>
                            <input type="text" class="form-control text-sm" id="kode" name="kode" value="{{ $kode }}" readonly>
                        </div>
                        <div class="col-12 col-md-8">
                            <label for="nama" class="form-label fw-semibold text-sm">Nama Jenis / Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-sm @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Kaleng Alumunium, Plastik HD" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="harga_beli" class="form-label fw-semibold text-sm">Harga Beli per Kg (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                <input type="number" step="1" min="0" class="form-control text-sm fw-bold text-success @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" placeholder="0" required>
                                <span class="input-group-text bg-light text-muted text-sm">/ kg</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="status" class="form-label fw-semibold text-sm">Status Kategori</label>
                            <select class="form-select text-sm @error('is_active') is-invalid @enderror" id="status" name="is_active">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Dapat Dipilih Transaksi)</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold text-sm">Deskripsi / Kriteria Sampah</label>
                        <textarea class="form-control text-sm @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan kondisi atau contoh barang (misal: Bersih, kering, tidak tercampur oli)...">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

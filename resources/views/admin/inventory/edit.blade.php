@extends('layouts.admin')

@section('title', 'Edit Produk Inventory')
@section('header_title', 'Edit Produk Inventory')

@section('content')
<form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST" enctype="multipart/form-data" id="edit-inventory-form">
    @csrf
    @method('PUT')
    <!-- Top Header Bar with Back & Save Buttons on a single row -->
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2">
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border d-none d-sm-inline-block">SKU: {{ $sku }}</span>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
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
        <div class="col-12 col-lg-8 mx-auto">
            <div class="admin-card border-0 shadow-sm">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h5 class="admin-card-title mb-0 fw-bold fs-5">Form Edit Produk Koperasi</h5>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <!-- Photo Product Section (1 Image Only) -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-sm">Foto Produk <span class="text-muted font-normal text-xs">(1 Foto Utama)</span></label>
                        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                            <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center flex-shrink-0 overflow-hidden" id="photo-preview-box" style="width: 110px; height: 110px;">
                                @if($inventory->foto)
                                    <img src="{{ asset('storage/' . $inventory->foto) }}" alt="Preview" class="w-100 h-100" id="preview-img" style="object-fit: cover;">
                                    <i class="bi bi-box-seam fs-1 text-secondary d-none" id="placeholder-icon"></i>
                                @else
                                    <img src="#" alt="Preview" class="w-100 h-100 d-none" id="preview-img" style="object-fit: cover;">
                                    <i class="bi bi-box-seam fs-1 text-secondary" id="placeholder-icon"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1 text-center text-sm-start">
                                <input type="file" class="form-control text-sm d-none" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                                <button type="button" class="btn btn-outline-primary btn-sm mb-2" onclick="document.getElementById('foto').click()">
                                    <i class="bi bi-arrow-repeat me-1"></i> Ganti Foto Produk
                                </button>
                                <p class="text-muted text-xs mb-0">Format: JPG, PNG, atau WEBP (Maksimal 2MB).</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-3 pt-2 border-top">Informasi Produk</div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label for="sku" class="form-label fw-semibold text-sm">SKU / Kode Barcode</label>
                            <input type="text" class="form-control text-sm" id="sku" name="sku" value="{{ $sku }}" readonly>
                        </div>
                        <div class="col-12 col-md-8">
                            <label for="nama" class="form-label fw-semibold text-sm">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-sm @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $inventory->nama) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="kategori_produk_id" class="form-label fw-semibold text-sm">Kategori Produk <span class="text-danger">*</span></label>
                            <select class="form-select text-sm @error('kategori_produk_id') is-invalid @enderror" id="kategori_produk_id" name="kategori_produk_id" required>
                                <option value="" disabled>Pilih Kategori...</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_produk_id', $inventory->kategori_produk_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="satuan" class="form-label fw-semibold text-sm">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-sm @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $inventory->satuan) }}" required>
                        </div>
                    </div>

                    <div class="text-xs fw-bold text-uppercase text-muted tracking-wider mb-3 pt-2 border-top">Harga & Stok</div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="harga_beli" class="form-label fw-semibold text-sm">Harga Beli Modal (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                <input type="number" step="1" min="0" class="form-control text-sm @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $inventory->harga_beli) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="harga_jual" class="form-label fw-semibold text-sm">Harga Jual Anggota (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                <input type="number" step="1" min="0" class="form-control text-sm fw-bold text-success @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $inventory->harga_jual) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label for="stok" class="form-label fw-semibold text-sm">Jumlah Sisa Stok <span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control text-sm @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $inventory->stok) }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="min_stok" class="form-label fw-semibold text-sm">Batas Peringatan Stok Menipis</label>
                            <input type="number" min="1" class="form-control text-sm @error('min_stok') is-invalid @enderror" id="min_stok" name="min_stok" value="{{ old('min_stok', $inventory->min_stok) }}">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="deskripsi" class="form-label fw-semibold text-sm">Deskripsi / Spesifikasi Produk</label>
                        <textarea class="form-control text-sm @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $inventory->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-img').classList.remove('d-none');
                document.getElementById('placeholder-icon').classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
@endsection

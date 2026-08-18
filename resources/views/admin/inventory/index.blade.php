@extends('layouts.admin')

@section('title', 'Inventory Barang Koperasi')
@section('header_title', 'Inventory Barang Koperasi')

@section('content')
<!-- Header Bar & Action Button -->
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-auto">
        <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary btn-sm text-white shadow-sm d-flex align-items-center justify-content-center py-2 px-3" style="min-width: 180px;">
            <i class="bi bi-plus-circle me-2"></i> Tambah Produk
        </a>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="col-12 col-md">
        <form action="{{ route('admin.inventory.index') }}" method="GET">
            <div class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-white border-start-0 text-sm" placeholder="Cari nama produk, SKU...">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
                <select name="stok" class="form-select bg-white text-sm" style="min-width: 160px; max-width: 200px;" onchange="this.form.submit()">
                    <option value="">Semua Stok</option>
                    <option value="aman" {{ request('stok') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                    <option value="menipis" {{ request('stok') == 'menipis' ? 'selected' : '' }}>Stok Menipis</option>
                    <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Summary Widgets -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Jenis Produk</span>
            <h4 class="fw-bold text-dark mb-0">{{ $totalProduk ?? 0 }} Produk</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Produk Stok Menipis</span>
            <h4 class="fw-bold text-warning mb-0">{{ $stokMenipis ?? 0 }} Produk</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Estimasi Nilai Inventaris</span>
            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($estimasiNilai ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-0">
                <!-- Desktop Table View (>= 768px) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">Produk</th>
                                <th class="py-3 text-xs text-uppercase text-muted">SKU / Kode</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Harga Jual</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Sisa Stok</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produkList as $produk)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 48px; height: 48px; overflow: hidden;">
                                            @if($produk->foto)
                                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <i class="bi bi-box-seam fs-4 text-secondary"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-sm">{{ $produk->nama }}</h6>
                                            <span class="text-xs text-muted">Satuan: {{ $produk->satuan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3"><span class="badge bg-light text-dark border fw-medium">PRD-{{ str_pad($produk->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="py-3 text-end fw-bold text-success text-sm">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                <td class="py-3 text-center">
                                    <span class="fw-bold {{ $produk->stok <= 0 ? 'text-danger' : ($produk->stok <= 5 ? 'text-warning' : 'text-dark') }} text-sm d-block">{{ floatval($produk->stok) }} {{ $produk->satuan }}</span>
                                    @if($produk->stok <= 0)
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-0.5 text-xs">Habis</span>
                                    @elseif($produk->stok <= 5)
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-0.5 text-xs">Menipis</span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0.5 text-xs">Stok Aman</span>
                                    @endif
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-success" title="Restock / Tambah Stok" onclick="setRestockData({{ $produk->id }}, 'PRD-{{ str_pad($produk->id, 4, '0', STR_PAD_LEFT) }}', '{{ addslashes($produk->nama) }}', {{ floatval($produk->stok) }}, '{{ $produk->satuan }}')">
                                            <i class="bi bi-plus-lg me-1"></i> Restock
                                        </button>
                                        <a href="{{ route('admin.inventory.edit', $produk->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Produk">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Produk" onclick="confirmDelete({{ $produk->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data produk inventaris.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View (< 768px) -->
                <div class="d-block d-md-none p-3">
                    @forelse($produkList as $produk)
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">PRD-{{ str_pad($produk->id, 4, '0', STR_PAD_LEFT) }}</span>
                            @if($produk->stok <= 0)
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Habis: {{ floatval($produk->stok) }} {{ $produk->satuan }}</span>
                            @elseif($produk->stok <= 5)
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Menipis: {{ floatval($produk->stok) }} {{ $produk->satuan }}</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Stok: {{ floatval($produk->stok) }} {{ $produk->satuan }}</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 44px; height: 44px; overflow: hidden;">
                                @if($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <i class="bi bi-box-seam fs-4 text-secondary"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark text-sm">{{ $produk->nama }}</h6>
                                <span class="text-xs text-muted">Satuan: {{ $produk->satuan }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div class="text-start">
                                <span class="text-muted text-xs d-block">Status Aktif</span>
                                @if($produk->is_active)
                                    <span class="fw-bold text-success text-xs">Aktif</span>
                                @else
                                    <span class="fw-bold text-danger text-xs">Nonaktif</span>
                                @endif
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Harga Jual</span>
                                <span class="fw-bold text-success text-base">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-success flex-fill text-xs py-1.5 text-white shadow-xs" onclick="setRestockData({{ $produk->id }}, 'PRD-{{ str_pad($produk->id, 4, '0', STR_PAD_LEFT) }}', '{{ addslashes($produk->nama) }}', {{ floatval($produk->stok) }}, '{{ $produk->satuan }}')"><i class="bi bi-plus-lg me-1"></i> Restock</button>
                            <a href="{{ route('admin.inventory.edit', $produk->id) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1.5 px-3" onclick="confirmDelete({{ $produk->id }})"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted border rounded-3 bg-light">Belum ada data produk inventaris.</div>
                    @endforelse
                </div>
            </div>

            <!-- Footer Pagination -->
            <div class="admin-card-footer p-3 p-md-4 border-top">
                {{ $produkList->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Quick Restock -->
<div class="modal fade" id="restockModal" tabindex="-1" aria-labelledby="restockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 380px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 pt-4 pb-2">
                <h5 class="fw-bold mb-0 text-dark fs-6"><i class="bi bi-plus-circle-fill text-success me-1"></i> Restock Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <span class="text-xs text-muted d-block" id="restock_sku">SKU: -</span>
                    <h6 class="fw-bold mb-0 text-dark" id="restock_nama">-</h6>
                    <span class="text-xs text-muted">Stok Saat Ini: <b class="text-dark" id="restock_stok_saat_ini">0</b></span>
                </div>

                <form id="restockForm" action="" method="POST" style="margin:0;">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tambah_stok" class="form-label fw-semibold text-sm">Jumlah Stok Masuk (Restock) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" min="1" class="form-control text-sm fw-bold fs-5 text-success" id="tambah_stok" name="tambah_stok" placeholder="Contoh: 20" required>
                            <span class="input-group-text bg-light text-muted text-sm" id="restock_satuan">pcs</span>
                        </div>
                    </div>

                    <div class="row g-2 mt-4">
                        <div class="col-6">
                            <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2 text-sm text-white shadow-sm" style="border-radius: 8px;">Simpan Stok</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Produk -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Produk Koperasi?</h5>
                <p class="text-muted text-xs mb-4">Master data barang ini akan terhapus dari katalog inventaris Koperasi.</p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    </div>
                    <div class="col-6">
                        <form id="deleteForm" action="" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 fw-bold py-2 text-sm shadow-sm" style="border-radius: 8px;">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function setRestockData(id, sku, nama, stok, satuan) {
        document.getElementById('restock_sku').innerText = 'SKU: ' + sku;
        document.getElementById('restock_nama').innerText = nama;
        document.getElementById('restock_stok_saat_ini').innerText = stok + ' ' + satuan;
        document.getElementById('restock_satuan').innerText = satuan;
        
        var form = document.getElementById('restockForm');
        form.action = '/admin/inventory/' + id + '/restock';
        
        var modal = new bootstrap.Modal(document.getElementById('restockModal'));
        modal.show();
    }

    function confirmDelete(id) {
        var form = document.getElementById('deleteForm');
        form.action = '/admin/inventory/' + id;
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection
@endsection

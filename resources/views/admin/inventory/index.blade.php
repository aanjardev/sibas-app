@extends('layouts.admin')

@section('title', 'Inventory Barang Koperasi')
@section('header_title', 'Inventory Barang Koperasi')

@section('content')
<!-- Header Bar & Action Button -->
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between justify-content-md-start">
        <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary text-white shadow-sm w-100 w-md-auto d-flex align-items-center justify-content-center py-2 px-3">
            <i class="bi bi-plus-circle me-2 fs-6"></i> Tambah Produk Baru
        </a>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="col-12 col-md-6">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-white border-start-0 text-sm" placeholder="Cari nama produk, SKU...">
            </div>
            <select class="form-select bg-white text-sm" style="max-width: 140px;">
                <option value="">Semua Stok</option>
                <option value="aman">Stok Aman</option>
                <option value="menipis">Stok Menipis</option>
                <option value="habis">Habis</option>
            </select>
        </div>
    </div>
</div>

<!-- Summary Widgets -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Jenis Produk</span>
            <h4 class="fw-bold text-dark mb-0">48 Produk</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Produk Stok Menipis</span>
            <h4 class="fw-bold text-warning mb-0">3 Produk</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Estimasi Nilai Inventaris</span>
            <h4 class="fw-bold text-success mb-0">Rp 18.250.000</h4>
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
                                <th class="py-3 text-xs text-uppercase text-muted">Kategori</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Harga Beli</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Harga Jual</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Sisa Stok</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Product Item 1 (Stok Aman) -->
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 48px; height: 48px; overflow: hidden;">
                                            <i class="bi bi-box-seam fs-4 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-sm">Minyak Goreng Sawit 1L</h6>
                                            <span class="text-xs text-muted">Pouch Refill 1000ml</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3"><span class="badge bg-light text-dark border fw-medium">PRD-001</span></td>
                                <td class="py-3"><span class="badge bg-light text-secondary border">Sembako</span></td>
                                <td class="py-3 text-end text-muted text-sm">Rp 14.000</td>
                                <td class="py-3 text-end fw-bold text-success text-sm">Rp 16.500</td>
                                <td class="py-3 text-center">
                                    <span class="fw-bold text-dark text-sm d-block">45 pcs</span>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0.5 text-xs">Stok Aman</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-success" title="Restock / Tambah Stok" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="setRestockData('PRD-001', 'Minyak Goreng Sawit 1L', 45)">
                                            <i class="bi bi-plus-lg me-1"></i> Restock
                                        </button>
                                        <a href="{{ route('admin.inventory.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit Produk">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Produk" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Product Item 2 (Stok Menipis) -->
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 48px; height: 48px; overflow: hidden;">
                                            <i class="bi bi-box-seam fs-4 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-sm">Gula Pasir Premium 1kg</h6>
                                            <span class="text-xs text-muted">Kemasan Kuning</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3"><span class="badge bg-light text-dark border fw-medium">PRD-002</span></td>
                                <td class="py-3"><span class="badge bg-light text-secondary border">Sembako</span></td>
                                <td class="py-3 text-end text-muted text-sm">Rp 15.500</td>
                                <td class="py-3 text-end fw-bold text-success text-sm">Rp 17.500</td>
                                <td class="py-3 text-center">
                                    <span class="fw-bold text-warning text-sm d-block">4 pcs</span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-0.5 text-xs">Menipis (&lt;5)</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-success" title="Restock / Tambah Stok" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="setRestockData('PRD-002', 'Gula Pasir Premium 1kg', 4)">
                                            <i class="bi bi-plus-lg me-1"></i> Restock
                                        </button>
                                        <a href="{{ route('admin.inventory.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit Produk">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Produk" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View (< 768px) -->
                <div class="d-block d-md-none p-3">
                    <!-- Mobile Item 1 -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">PRD-001</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Stok: 45 pcs</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="bi bi-box-seam fs-4 text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark text-sm">Minyak Goreng Sawit 1L</h6>
                                <span class="text-xs text-muted">Sembako • Refill 1000ml</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div>
                                <span class="text-muted text-xs d-block">Harga Beli</span>
                                <span class="text-dark text-xs">Rp 14.000</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Harga Jual</span>
                                <span class="fw-bold text-success text-base">Rp 16.500</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-success flex-fill text-xs py-1.5 text-white shadow-xs" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="setRestockData('PRD-001', 'Minyak Goreng Sawit 1L', 45)"><i class="bi bi-plus-lg me-1"></i> Restock</button>
                            <a href="{{ route('admin.inventory.edit', 1) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1.5 px-3" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>

                    <!-- Mobile Item 2 -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">PRD-002</span>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Menipis: 4 pcs</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="bi bi-box-seam fs-4 text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark text-sm">Gula Pasir Premium 1kg</h6>
                                <span class="text-xs text-muted">Sembako • Kemasan Kuning</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div>
                                <span class="text-muted text-xs d-block">Harga Beli</span>
                                <span class="text-dark text-xs">Rp 15.500</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Harga Jual</span>
                                <span class="fw-bold text-success text-base">Rp 17.500</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-success flex-fill text-xs py-1.5 text-white shadow-xs" data-bs-toggle="modal" data-bs-target="#restockModal" onclick="setRestockData('PRD-002', 'Gula Pasir Premium 1kg', 4)"><i class="bi bi-plus-lg me-1"></i> Restock</button>
                            <a href="{{ route('admin.inventory.edit', 2) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1.5 px-3" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Pagination -->
            <div class="admin-card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 p-md-4 border-top gap-3">
                <span class="text-muted text-xs text-center text-sm-start">Menampilkan 1-2 dari 48 produk</span>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                    </ul>
                </nav>
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
                    <span class="text-xs text-muted d-block" id="restock_sku">SKU: PRD-001</span>
                    <h6 class="fw-bold mb-0 text-dark" id="restock_nama">Minyak Goreng Sawit 1L</h6>
                    <span class="text-xs text-muted">Stok Saat Ini: <b class="text-dark" id="restock_stok_saat_ini">45 pcs</b></span>
                </div>

                <form action="#" method="POST" style="margin:0;">
                    @csrf
                    <div class="mb-3">
                        <label for="tambah_stok" class="form-label fw-semibold text-sm">Jumlah Stok Masuk (Restock) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" min="1" class="form-control text-sm fw-bold fs-5 text-success" id="tambah_stok" name="tambah_stok" placeholder="Contoh: 20" required>
                            <span class="input-group-text bg-light text-muted text-sm">pcs</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan_restock" class="form-label fw-semibold text-sm">Catatan Pengadaan (Opsional)</label>
                        <input type="text" class="form-control text-sm" id="catatan_restock" name="catatan_restock" placeholder="Contoh: Pengadaan Suplier PT Sinar Mas">
                    </div>

                    <div class="row g-2">
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
                        <form action="#" method="POST" style="margin:0;">
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

<script>
    function setRestockData(sku, nama, stok) {
        document.getElementById('restock_sku').innerText = 'SKU: ' + sku;
        document.getElementById('restock_nama').innerText = nama;
        document.getElementById('restock_stok_saat_ini').innerText = stok + ' pcs';
    }
</script>

<style>
.pagination .page-link {
    color: var(--primary);
}
.pagination .page-item.active .page-link {
    background-color: var(--primary);
    border-color: var(--primary);
    color: white;
}
.pagination .page-link:hover {
    color: var(--primary-dark);
    background-color: #e9ecef;
}
</style>
@endsection

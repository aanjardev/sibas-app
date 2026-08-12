@extends('layouts.admin')

@section('title', 'Belanja Koperasi')
@section('header_title', 'Belanja Koperasi')

@section('content')

{{-- Action Bar --}}
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between justify-content-md-start gap-2">
        <a href="{{ route('admin.belanja-koperasi.pos') }}" class="btn btn-primary text-white shadow-sm d-flex align-items-center justify-content-center py-2 px-4 fw-semibold" style="border-radius: 10px;">
            <i class="bi bi-cart-plus me-2 fs-6"></i> Buka Kasir
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="col-12 col-md-6">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control bg-white border-start-0 text-sm" placeholder="Cari No TRX, nama pembeli...">
            </div>
            <select id="filterStatus" class="form-select bg-white text-sm" style="max-width: 145px;">
                <option value="">Semua Status</option>
                <option value="lunas">Lunas</option>
                <option value="pending">Pending</option>
                <option value="batal">Dibatalkan</option>
            </select>
        </div>
    </div>
</div>

{{-- Summary Widgets --}}
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-receipt text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Transaksi Hari Ini</span>
            </div>
            <h4 class="fw-bold text-dark mb-0">24 Transaksi</h4>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-success bg-opacity-10 text-success rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-cash-stack text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Omzet Hari Ini</span>
            </div>
            <h4 class="fw-bold text-success mb-0">Rp 1.482.500</h4>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-warning bg-opacity-10 text-warning rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-box-seam text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Item Terjual Hari Ini</span>
            </div>
            <h4 class="fw-bold text-dark mb-0">87 Item</h4>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3 d-none d-lg-block">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-info bg-opacity-10 text-info rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-graph-up-arrow text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Omzet Bulan Ini</span>
            </div>
            <h4 class="fw-bold text-dark mb-0">Rp 28.750.000</h4>
        </div>
    </div>
</div>

{{-- Riwayat Transaksi Table --}}
<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-0">

                {{-- Desktop Table View (>= 768px) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0" id="trxTable">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Waktu</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Pembeli</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Item Dibeli</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Metode</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Total</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Status</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- TRX 1 --}}
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B089</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 14:22</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Budi Santoso</div>
                                    <div class="text-xs text-muted">AGT-001 · Anggota</div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-light text-dark border text-xs">Minyak Goreng x2</span>
                                        <span class="badge bg-light text-dark border text-xs">Gula 1kg x1</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2 py-1 text-xs">
                                        <i class="bi bi-wallet2 me-1"></i>Tabungan
                                    </span>
                                </td>
                                <td class="py-3 text-end fw-bold text-dark text-sm">Rp 50.500</td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">Lunas</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.belanja-koperasi.show', 1) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Cetak Nota"
                                            onclick="window.open('{{ route('admin.belanja-koperasi.show', 1) }}?print=1','_blank')">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <a href="{{ route('admin.belanja-koperasi.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            onclick="setDeleteData('TRX-B089', 'Budi Santoso', 'Rp 50.500')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- TRX 2 --}}
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B088</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 13:05</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Pelanggan Umum</div>
                                    <div class="text-xs text-muted">Non-Anggota</div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-light text-dark border text-xs">Beras 5kg x1</span>
                                        <span class="badge bg-light text-dark border text-xs">Sabun x3</span>
                                        <span class="badge bg-light text-dark border text-xs">+2 item</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">
                                        <i class="bi bi-cash me-1"></i>Tunai
                                    </span>
                                </td>
                                <td class="py-3 text-end fw-bold text-dark text-sm">Rp 128.000</td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">Lunas</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.belanja-koperasi.show', 2) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Cetak Nota"
                                            onclick="window.open('{{ route('admin.belanja-koperasi.show', 2) }}?print=1','_blank')">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <a href="{{ route('admin.belanja-koperasi.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            onclick="setDeleteData('TRX-B088', 'Pelanggan Umum', 'Rp 128.000')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- TRX 3 (Pending) --}}
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B087</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 11:47</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Siti Aminah</div>
                                    <div class="text-xs text-muted">AGT-002 · Anggota</div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-light text-dark border text-xs">Mie Instan x12</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 text-xs">
                                        <i class="bi bi-credit-card me-1"></i>Debit
                                    </span>
                                </td>
                                <td class="py-3 text-end fw-bold text-dark text-sm">Rp 36.000</td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-medium">Pending</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.belanja-koperasi.show', 3) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Cetak Nota"
                                            onclick="window.open('{{ route('admin.belanja-koperasi.show', 3) }}?print=1','_blank')">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <a href="{{ route('admin.belanja-koperasi.edit', 3) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            onclick="setDeleteData('TRX-B087', 'Siti Aminah', 'Rp 36.000')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card List View (< 768px) --}}
                <div class="d-block d-md-none p-3">
                    {{-- Mobile Item 1 --}}
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border">TRX-B089</span>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs">Lunas</span>
                            </div>
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>14:22</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Pembeli</span>
                            <span class="fw-bold text-sm text-dark">Budi Santoso <small class="text-muted fw-normal">(AGT-001)</small></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Metode</span>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill text-xs"><i class="bi bi-wallet2 me-1"></i>Tabungan</span>
                        </div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-light text-dark border text-xs">Minyak Goreng x2</span>
                            <span class="badge bg-light text-dark border text-xs">Gula 1kg x1</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <span class="text-muted text-xs">Total Belanja</span>
                            <span class="fw-bold text-dark text-base">Rp 50.500</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.belanja-koperasi.show', 1) }}" class="btn btn-sm btn-outline-secondary flex-fill text-xs py-1"><i class="bi bi-eye me-1"></i>Detail</a>
                            <button class="btn btn-sm btn-outline-secondary text-xs py-1 px-2" onclick="window.open('{{ route('admin.belanja-koperasi.show', 1) }}?print=1','_blank')"><i class="bi bi-printer"></i></button>
                            <a href="{{ route('admin.belanja-koperasi.edit', 1) }}" class="btn btn-sm btn-outline-primary text-xs py-1 px-2"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1 px-2" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteData('TRX-B089', 'Budi Santoso', 'Rp 50.500')"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>

                    {{-- Mobile Item 2 --}}
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border">TRX-B088</span>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs">Lunas</span>
                            </div>
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>13:05</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Pembeli</span>
                            <span class="fw-bold text-sm text-dark">Pelanggan Umum</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Metode</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs"><i class="bi bi-cash me-1"></i>Tunai</span>
                        </div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-light text-dark border text-xs">Beras 5kg x1</span>
                            <span class="badge bg-light text-dark border text-xs">Sabun x3</span>
                            <span class="badge bg-light text-dark border text-xs">+2 item</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <span class="text-muted text-xs">Total Belanja</span>
                            <span class="fw-bold text-dark text-base">Rp 128.000</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.belanja-koperasi.show', 2) }}" class="btn btn-sm btn-outline-secondary flex-fill text-xs py-1"><i class="bi bi-eye me-1"></i>Detail</a>
                            <button class="btn btn-sm btn-outline-secondary text-xs py-1 px-2" onclick="window.open('{{ route('admin.belanja-koperasi.show', 2) }}?print=1','_blank')"><i class="bi bi-printer"></i></button>
                            <a href="{{ route('admin.belanja-koperasi.edit', 2) }}" class="btn btn-sm btn-outline-primary text-xs py-1 px-2"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1 px-2" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteData('TRX-B088', 'Pelanggan Umum', 'Rp 128.000')"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>

                    {{-- Mobile Item 3 (Pending) --}}
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border">TRX-B087</span>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill text-xs">Pending</span>
                            </div>
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>11:47</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Pembeli</span>
                            <span class="fw-bold text-sm text-dark">Siti Aminah <small class="text-muted fw-normal">(AGT-002)</small></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Metode</span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill text-xs"><i class="bi bi-credit-card me-1"></i>Debit</span>
                        </div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-light text-dark border text-xs">Mie Instan x12</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <span class="text-muted text-xs">Total Belanja</span>
                            <span class="fw-bold text-dark text-base">Rp 36.000</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.belanja-koperasi.show', 3) }}" class="btn btn-sm btn-outline-secondary flex-fill text-xs py-1"><i class="bi bi-eye me-1"></i>Detail</a>
                            <button class="btn btn-sm btn-outline-secondary text-xs py-1 px-2" onclick="window.open('{{ route('admin.belanja-koperasi.show', 3) }}?print=1','_blank')"><i class="bi bi-printer"></i></button>
                            <a href="{{ route('admin.belanja-koperasi.edit', 3) }}" class="btn btn-sm btn-outline-primary text-xs py-1 px-2"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1 px-2" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteData('TRX-B087', 'Siti Aminah', 'Rp 36.000')"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Pagination --}}
            <div class="admin-card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 p-md-4 border-top gap-3">
                <span class="text-muted text-xs text-center text-sm-start">Menampilkan 1-3 dari 89 transaksi</span>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Transaksi --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-1 text-dark">Hapus Transaksi?</h5>
                <p class="text-muted text-xs mb-1">No. Transaksi: <strong id="del_trx_id" class="text-dark">-</strong></p>
                <p class="text-muted text-xs mb-1">Pembeli: <strong id="del_pembeli" class="text-dark">-</strong></p>
                <p class="text-muted text-xs mb-4">Total: <strong id="del_total" class="text-danger">-</strong></p>
                <p class="text-muted text-xs mb-4">Data transaksi dan rincian item akan dihapus permanen. Stok barang akan dikembalikan.</p>
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

<style>
.pagination .page-link { color: var(--primary); }
.pagination .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: white; }
.pagination .page-link:hover { color: var(--primary-dark); background-color: #e9ecef; }
</style>

@endsection

@section('scripts')
<script>
    function setDeleteData(trxId, pembeli, total) {
        document.getElementById('del_trx_id').innerText = trxId;
        document.getElementById('del_pembeli').innerText = pembeli;
        document.getElementById('del_total').innerText = total;
    }

    // Live search filter
    document.getElementById('searchInput').addEventListener('input', function () {
        filterTable();
    });
    document.getElementById('filterStatus').addEventListener('change', function () {
        filterTable();
    });

    function filterTable() {
        // Frontend-only demo filter
        const q = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#trxTable tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    }
</script>
@endsection

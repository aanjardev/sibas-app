@extends('layouts.admin')

@section('title', 'Kelola Tabungan Anggota')
@section('header_title', 'Kelola Tabungan Anggota')

@section('content')
<!-- Action Bar & Create Button -->
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between justify-content-md-start">
        <a href="{{ route('admin.tabungan.create') }}" class="btn btn-primary text-white shadow-sm w-100 w-md-auto d-flex align-items-center justify-content-center py-2 px-3">
            <i class="bi bi-plus-circle me-2 fs-6"></i> Transaksi Tabungan Baru
        </a>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="col-12 col-md-6">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-white border-start-0 text-sm" placeholder="Cari No TRX, nama nasabah...">
            </div>
            <select class="form-select bg-white text-sm" style="max-width: 140px;">
                <option value="">Semua Transaksi</option>
                <option value="setor">Setor Tunai</option>
                <option value="tarik">Tarik Tunai</option>
            </select>
        </div>
    </div>
</div>

<!-- Summary Widgets -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Tabungan Terhimpun</span>
            <h4 class="fw-bold text-success mb-0">Rp 124.500.000</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Setor Tunai Hari Ini</span>
            <h4 class="fw-bold text-dark mb-0">+ Rp 1.250.000</h4>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="admin-card border-0 shadow-sm p-3">
            <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Penarikan Tunai Hari Ini</span>
            <h4 class="fw-bold text-danger mb-0">- Rp 500.000</h4>
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
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Waktu</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Nama Anggota</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Jenis Transaksi</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Nominal</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Saldo Akhir</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Item 1 (Setor Tunai) -->
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T102</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 10:15</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Budi Santoso</div>
                                    <div class="text-xs text-muted">ID: AGT-001</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">
                                        <i class="bi bi-arrow-down-left me-1"></i> Setor Tunai
                                    </span>
                                </td>
                                <td class="py-3 text-end fw-bold text-success text-sm">+ Rp 200.000</td>
                                <td class="py-3 text-end text-muted text-sm">Rp 450.000</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.tabungan.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit Transaksi">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 2 (Penarikan Tunai) -->
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T101</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 08:45</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Siti Aminah</div>
                                    <div class="text-xs text-muted">ID: AGT-002</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 fw-medium">
                                        <i class="bi bi-arrow-up-right me-1"></i> Tarik Tunai
                                    </span>
                                </td>
                                <td class="py-3 text-end fw-bold text-danger text-sm">- Rp 500.000</td>
                                <td class="py-3 text-end text-muted text-sm">Rp 1.200.000</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.tabungan.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit Transaksi">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Hari ini, 10:15</span>
                            <span class="badge bg-light text-dark border">TRX-T102</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Budi Santoso <small class="text-muted fw-normal">(AGT-001)</small></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Jenis Transaksi</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Setor Tunai</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div>
                                <span class="text-muted text-xs d-block">Saldo Akhir</span>
                                <span class="text-dark text-xs">Rp 450.000</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Nominal Setor</span>
                                <span class="fw-bold text-success text-base">+ Rp 200.000</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.tabungan.edit', 1) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>

                    <!-- Mobile Item 2 -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Hari ini, 08:45</span>
                            <span class="badge bg-light text-dark border">TRX-T101</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Siti Aminah <small class="text-muted fw-normal">(AGT-002)</small></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Jenis Transaksi</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Tarik Tunai</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div>
                                <span class="text-muted text-xs d-block">Saldo Akhir</span>
                                <span class="text-dark text-xs">Rp 1.200.000</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Nominal Tarik</span>
                                <span class="fw-bold text-danger text-base">- Rp 500.000</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.tabungan.edit', 2) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Pagination -->
            <div class="admin-card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 p-md-4 border-top gap-3">
                <span class="text-muted text-xs text-center text-sm-start">Menampilkan 1-2 dari 84 transaksi</span>
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

<!-- Modal Konfirmasi Hapus Transaksi Tabungan -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Transaksi Tabungan?</h5>
                <p class="text-muted text-xs mb-4">Transaksi ini akan dibatalkan dan saldo tabungan anggota yang bersangkutan akan dikembalikan ke posisi semula.</p>
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

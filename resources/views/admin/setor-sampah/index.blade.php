@extends('layouts.admin')

@section('title', 'Riwayat Setor Sampah')
@section('header_title', 'Riwayat Setor Sampah')

@section('content')
<!-- Header Bar & Actions -->
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between justify-content-md-start">
        <a href="{{ route('admin.setor-sampah.create') }}" class="btn btn-primary text-white shadow-sm w-100 w-md-auto d-flex align-items-center justify-content-center py-2 px-3">
            <i class="bi bi-plus-circle me-2 fs-6"></i> Input Setor Sampah Baru
        </a>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="col-12 col-md-6">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-white border-start-0 text-sm" placeholder="Cari TRX, nama, kategori...">
            </div>
            <select class="form-select bg-white text-sm" style="max-width: 130px;">
                <option value="">Semua Kategori</option>
                <option value="Plastik">Plastik PET</option>
                <option value="Kardus">Kardus Bekas</option>
                <option value="Besi">Besi/Logam</option>
            </select>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-0">
                <!-- Desktop & Tablet Table View (>= 768px) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Tanggal</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Nama Anggota</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Rincian Item Sampah</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Total Berat</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Total Nilai</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- TRX 1 (Multi-Item) -->
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S045</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 09:41</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Budi Santoso</div>
                                    <div class="text-xs text-muted">ID: AGT-001</div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Plastik PET (5kg)</span>
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Kardus (10kg)</span>
                                    </div>
                                </td>
                                <td class="py-3 text-end fw-semibold text-sm">15.0 kg</td>
                                <td class="py-3 text-end text-success fw-bold">+ Rp 25.000</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.setor-sampah.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- TRX 2 (Single Item) -->
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S044</span></td>
                                <td class="py-3 text-muted text-sm">Hari ini, 08:30</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">Siti Aminah</div>
                                    <div class="text-xs text-muted">ID: AGT-002</div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Kardus Bekas (10kg)</span>
                                </td>
                                <td class="py-3 text-end fw-semibold text-sm">10.0 kg</td>
                                <td class="py-3 text-end text-success fw-bold">+ Rp 10.000</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.setor-sampah.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
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
                    <!-- Item 1 (Multi-Item) -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Hari ini, 09:41</span>
                            <span class="badge bg-light text-dark border">TRX-S045</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Budi Santoso <small class="text-muted fw-normal">(AGT-001)</small></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted text-xs d-block mb-1">Rincian Item Setor</span>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Plastik PET: 5.0 kg</span>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Kardus: 10.0 kg</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div>
                                <span class="text-muted text-xs d-block">Total Berat</span>
                                <span class="fw-semibold text-dark text-xs">15.0 kg</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Grand Total</span>
                                <span class="fw-bold text-success text-base">+ Rp 25.000</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.setor-sampah.edit', 1) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Hari ini, 08:30</span>
                            <span class="badge bg-light text-dark border">TRX-S044</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Siti Aminah <small class="text-muted fw-normal">(AGT-002)</small></span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted text-xs d-block mb-1">Rincian Item Setor</span>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Kardus Bekas: 10.0 kg</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <div>
                                <span class="text-muted text-xs d-block">Total Berat</span>
                                <span class="fw-semibold text-dark text-xs">10.0 kg</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted text-xs d-block">Grand Total</span>
                                <span class="fw-bold text-success text-base">+ Rp 10.000</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.setor-sampah.edit', 2) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Pagination -->
            <div class="admin-card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 p-md-4 border-top gap-3">
                <span class="text-muted text-xs text-center text-sm-start">Menampilkan 1-2 dari 45 transaksi</span>
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

<!-- Modal Konfirmasi Hapus Setor Sampah -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Transaksi?</h5>
                <p class="text-muted text-xs mb-4">Catatan transaksi setor sampah ini akan terhapus dan saldo anggota akan disesuaikan.</p>
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

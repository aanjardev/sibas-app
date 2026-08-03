@extends('layouts.admin')

@section('title', 'Data Anggota')
@section('header_title', 'Data Anggota')

@section('content')
<!-- Header Bar & Actions -->
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between justify-content-md-start">
        <!-- <h5 class="mb-0 fw-bold fs-5 text-dark d-none d-md-block">Daftar Anggota</h5> -->
        <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary text-white shadow-sm w-100 w-md-auto d-flex align-items-center justify-content-center py-2 px-3">
            <i class="bi bi-person-plus me-2 fs-6"></i> Tambah Anggota Baru
        </a>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="col-12 col-md-6">
        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-white border-start-0 text-sm" placeholder="Cari nama, ID, no hp...">
            </div>
            <select class="form-select bg-white text-sm" style="max-width: 130px;">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
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
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">ID Anggota</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Nama Anggota</th>
                                <th class="py-3 text-xs text-uppercase text-muted">No. Telepon</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Alamat</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Status</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">AGT-001</span></td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 38px; height: 38px;">
                                            <span class="fw-bold">B</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-sm">Budi Santoso</h6>
                                            <span class="text-muted text-xs">Bergabung sejak Jan 2026</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted text-sm">0812-3456-7890</td>
                                <td class="py-3 text-muted text-sm text-truncate" style="max-width: 200px;">Jl. Merdeka No. 10, Jakarta</td>
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Aktif</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.anggota.show', 1) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.anggota.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Anggota" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">AGT-002</span></td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 38px; height: 38px;">
                                            <span class="fw-bold">S</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-sm">Siti Aminah</h6>
                                            <span class="text-muted text-xs">Bergabung sejak Feb 2026</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted text-sm">0856-7890-1234</td>
                                <td class="py-3 text-muted text-sm text-truncate" style="max-width: 200px;">Jl. Melati No. 5, Bandung</td>
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Aktif</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.anggota.show', 2) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.anggota.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Anggota" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">AGT-003</span></td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 38px; height: 38px;">
                                            <span class="fw-bold">A</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-muted text-sm">Ahmad Fausi</h6>
                                            <span class="text-muted text-xs">Bergabung sejak Mar 2026</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted text-sm">0813-5555-4444</td>
                                <td class="py-3 text-muted text-sm text-truncate" style="max-width: 200px;">Jl. Pahlawan No. 2, Surabaya</td>
                                <td class="py-3">
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Nonaktif</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.anggota.show', 3) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.anggota.edit', 3) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Anggota" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                    <!-- Anggota Item 1 -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">AGT-001</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Aktif</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
                                <span class="fw-bold">B</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Budi Santoso</h6>
                                <span class="text-muted text-xs">Bergabung: Jan 2026</span>
                            </div>
                        </div>
                        <div class="text-xs text-muted mb-1"><i class="bi bi-telephone me-1"></i>0812-3456-7890</div>
                        <div class="text-xs text-muted mb-3"><i class="bi bi-geo-alt me-1"></i>Jl. Merdeka No. 10, Jakarta</div>
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('admin.anggota.show', 1) }}" class="btn btn-sm btn-outline-info flex-fill text-xs py-1.5"><i class="bi bi-eye me-1"></i> Detail</a>
                            <a href="{{ route('admin.anggota.edit', 1) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>

                    <!-- Anggota Item 2 -->
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">AGT-002</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Aktif</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
                                <span class="fw-bold">S</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Siti Aminah</h6>
                                <span class="text-muted text-xs">Bergabung: Feb 2026</span>
                            </div>
                        </div>
                        <div class="text-xs text-muted mb-1"><i class="bi bi-telephone me-1"></i>0856-7890-1234</div>
                        <div class="text-xs text-muted mb-3"><i class="bi bi-geo-alt me-1"></i>Jl. Melati No. 5, Bandung</div>
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('admin.anggota.show', 2) }}" class="btn btn-sm btn-outline-info flex-fill text-xs py-1.5"><i class="bi bi-eye me-1"></i> Detail</a>
                            <a href="{{ route('admin.anggota.edit', 2) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>

                    <!-- Anggota Item 3 -->
                    <div class="p-3 mb-0 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="badge bg-light text-dark border">AGT-003</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Nonaktif</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
                                <span class="fw-bold">A</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-muted">Ahmad Fausi</h6>
                                <span class="text-muted text-xs">Bergabung: Mar 2026</span>
                            </div>
                        </div>
                        <div class="text-xs text-muted mb-1"><i class="bi bi-telephone me-1"></i>0813-5555-4444</div>
                        <div class="text-xs text-muted mb-3"><i class="bi bi-geo-alt me-1"></i>Jl. Pahlawan No. 2, Surabaya</div>
                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('admin.anggota.show', 3) }}" class="btn btn-sm btn-outline-info flex-fill text-xs py-1.5"><i class="bi bi-eye me-1"></i> Detail</a>
                            <a href="{{ route('admin.anggota.edit', 3) }}" class="btn btn-sm btn-outline-primary flex-fill text-xs py-1.5"><i class="bi bi-pencil me-1"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill text-xs py-1.5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash me-1"></i> Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Pagination -->
            <div class="admin-card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 p-md-4 border-top gap-3">
                <span class="text-muted text-xs text-center text-sm-start">Menampilkan 1-3 dari 142 anggota</span>
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

<!-- Modal Konfirmasi Hapus Anggota -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Data Anggota?</h5>
                <p class="text-muted text-xs mb-4">Data anggota beserta riwayat transaksi yang bersangkutan akan terhapus secara permanen.</p>
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

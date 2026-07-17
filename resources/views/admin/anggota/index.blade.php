@extends('layouts.admin')

@section('title', 'Data Anggota')
@section('header_title', 'Data Anggota')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <!-- <h5 class="mb-0 fw-bold">Daftar Anggota</h5> -->
        <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Anggota Baru
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card shadow-sm border">
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">ID</th>
                                <th class="py-3 border-bottom-0">Nama Anggota</th>
                                <th class="py-3 border-bottom-0">No. Telepon</th>
                                <th class="py-3 border-bottom-0">Alamat</th>
                                <th class="py-3 border-bottom-0">Status</th>
                                <th class="pe-4 py-3 border-bottom-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted">AGT-001</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">B</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Budi Santoso</h6>
                                            <span class="text-muted text-sm">Bergabung sejak Jan 2026</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted">0812-3456-7890</td>
                                <td class="py-3 text-muted">Jl. Merdeka No. 10, Jakarta</td>
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Aktif</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.anggota.show', 1) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.anggota.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Anggota">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted">AGT-002</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">S</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Siti Aminah</h6>
                                            <span class="text-muted text-sm">Bergabung sejak Feb 2026</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted">0856-7890-1234</td>
                                <td class="py-3 text-muted">Jl. Melati No. 5, Bandung</td>
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Aktif</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.anggota.show', 2) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.anggota.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Anggota">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted">AGT-003</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">A</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-muted">Ahmad Fausi</h6>
                                            <span class="text-muted text-sm">Bergabung sejak Mar 2026</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-muted">0813-5555-4444</td>
                                <td class="py-3 text-muted">Jl. Pahlawan No. 2, Surabaya</td>
                                <td class="py-3">
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Nonaktif</span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.anggota.show', 3) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.anggota.edit', 3) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Anggota">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="admin-card-footer d-flex justify-content-between align-items-center p-4 border-top">
                <span class="text-muted text-sm">Menampilkan 1 hingga 3 dari 142 anggota</span>
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

<style>
/* Custom Pagination Colors to match Green Theme */
.pagination .page-link {
    color: #198754;
}
.pagination .page-item.active .page-link {
    background-color: #198754;
    border-color: #198754;
    color: white;
}
.pagination .page-link:hover {
    color: #146c43;
    background-color: #e9ecef;
}
</style>
@endsection

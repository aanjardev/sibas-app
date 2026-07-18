@extends('layouts.admin')

@section('title', 'Riwayat Setor Sampah')
@section('header_title', 'Riwayat Setor Sampah')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <!-- <h5 class="mb-0 fw-bold">Riwayat Setor Sampah</h5> -->
        <a href="{{ route('admin.setor-sampah.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Input Setor Sampah Baru
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card shadow-sm border">
            <div class="admin-card-header d-flex justify-content-between align-items-center bg-transparent border-bottom p-4">
                <h5 class="mb-0 fw-bold">Transaksi Terbaru</h5>
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Cari No TRX atau Nama...">
                </div>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">No. TRX</th>
                                <th class="py-3 border-bottom-0">Tanggal</th>
                                <th class="py-3 border-bottom-0">Nama Anggota</th>
                                <th class="py-3 border-bottom-0">Kategori</th>
                                <th class="py-3 border-bottom-0 text-end">Berat (kg)</th>
                                <th class="py-3 border-bottom-0 text-end">Total Nilai</th>
                                <th class="pe-4 py-3 border-bottom-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted">TRX-S045</td>
                                <td class="py-3 text-muted">Hari ini, 09:41</td>
                                <td class="py-3">
                                    <div class="fw-bold">Budi Santoso</div>
                                    <div class="text-xs text-muted">AGT-001</div>
                                </td>
                                <td class="py-3">Plastik PET</td>
                                <td class="py-3 text-end fw-semibold">5.0</td>
                                <td class="py-3 text-end text-success fw-semibold">Rp 15.000</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.setor-sampah.edit', 1) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted">TRX-S044</td>
                                <td class="py-3 text-muted">Hari ini, 08:30</td>
                                <td class="py-3">
                                    <div class="fw-bold">Siti Aminah</div>
                                    <div class="text-xs text-muted">AGT-002</div>
                                </td>
                                <td class="py-3">Kardus Bekas</td>
                                <td class="py-3 text-end fw-semibold">10.0</td>
                                <td class="py-3 text-end text-success fw-semibold">Rp 10.000</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.setor-sampah.edit', 2) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted">TRX-S043</td>
                                <td class="py-3 text-muted">Kemarin, 14:15</td>
                                <td class="py-3">
                                    <div class="fw-bold">Ahmad Fausi</div>
                                    <div class="text-xs text-muted">AGT-003</div>
                                </td>
                                <td class="py-3">Besi/Logam</td>
                                <td class="py-3 text-end fw-semibold">2.5</td>
                                <td class="py-3 text-end text-success fw-semibold">Rp 12.500</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.setor-sampah.edit', 3) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi">
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
                <span class="text-muted text-sm">Menampilkan 1 hingga 3 dari 45 transaksi</span>
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

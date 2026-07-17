@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard Admin')

@section('content')

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <!-- <div class="admin-card-header bg-transparent border-0 pb-0 pt-4 px-4">
                <h5 class="admin-card-title mb-0 fw-bold">Aksi Cepat</h5>
            </div> -->
            <div class="admin-card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <button class="btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Input Setor Sampah</div>
                                <div class="text-xs text-white opacity-75">Catat setoran sampah baru</div>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="bi bi-recycle fs-5 text-white"></i>
                            </div>
                        </button>
                    </div>
                    <div class="col-12 col-md-4">
                        <button class="btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Kasir Koperasi</div>
                                <div class="text-xs text-white opacity-75">Input penjualan barang koperasi</div>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="bi bi-cart-plus fs-5 text-white"></i>
                            </div>
                        </button>
                    </div>
                    <div class="col-12 col-md-4">
                        <button class="btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Setor/Tarik Tabungan</div>
                                <div class="text-xs text-white opacity-75">Kelola saldo tabungan anggota</div>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                <i class="bi bi-wallet2 fs-5 text-white"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1 fw-semibold text-sm">Total Anggota</h6>
                <h3 class="mb-0 fw-bold">142</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-recycle"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1 fw-semibold text-sm">Sampah Masuk ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h6>
                <h3 class="mb-0 fw-bold">1,250 <small class="text-muted fs-6">kg</small></h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-cart-check"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1 fw-semibold text-sm">Penjualan Koperasi ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h6>
                <h3 class="mb-0 fw-bold">Rp 3.5M</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <h6 class="text-muted mb-1 fw-semibold text-sm">Total Saldo Tabungan</h6>
                <h3 class="mb-0 fw-bold">Rp 12.4M</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Transactions Activity -->
    <div class="col-12">
        <div class="admin-card h-100 border-0 shadow-sm">
            <div class="admin-card-header d-flex justify-content-between align-items-center pt-4 px-4 bg-transparent border-bottom-0">
                <h5 class="admin-card-title mb-0 fw-bold">Aktivitas Transaksi Terbaru</h5>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-4">
                <div class="table-responsive border rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 border-bottom-0 py-3">No. TRX</th>
                                <th class="border-bottom-0 py-3">Anggota</th>
                                <th class="border-bottom-0 py-3 text-center">Jenis</th>
                                <th class="border-bottom-0 py-3">Tanggal</th>
                                <th class="text-end pe-4 border-bottom-0 py-3">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-S010</span></td>
                                <td class="py-3">Budi Santoso</td>
                                <td class="py-3 text-center"><span class="badge text-dark rounded-pill px-3" style="background-color: rgba(40, 167, 69, 0.2);">Setor Sampah</span></td>
                                <td class="text-muted text-sm py-3">Hari ini, 09:41</td>
                                <td class="text-end pe-4 fw-semibold text-success py-3">+ Rp 15.000</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-B045</span></td>
                                <td class="py-3">Siti Aminah</td>
                                <td class="py-3 text-center"><span class="badge text-dark rounded-pill px-3" style="background-color: rgba(253, 126, 20, 0.2);">Belanja Koperasi</span></td>
                                <td class="text-muted text-sm py-3">Hari ini, 08:30</td>
                                <td class="text-end pe-4 fw-semibold text-danger py-3">- Rp 45.000</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-T002</span></td>
                                <td class="py-3">Ahmad Fausi</td>
                                <td class="py-3 text-center"><span class="badge text-dark rounded-pill px-3" style="background-color: rgba(144, 238, 144, 0.4);">Setor Tabungan</span></td>
                                <td class="text-muted text-sm py-3">Kemarin, 14:15</td>
                                <td class="text-end pe-4 fw-semibold text-success py-3">+ Rp 100.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

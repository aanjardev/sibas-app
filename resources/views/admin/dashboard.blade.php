@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard Admin')

@section('content')

<!-- Quick Actions -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <button class="btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Input Setor Sampah</div>
                                <div class="text-xs text-white opacity-75">Catat setoran sampah baru</div>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
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
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
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
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="bi bi-wallet2 fs-5 text-white"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-success bg-opacity-10 text-success">
                <i class="bi bi-people"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="text-muted mb-1 fw-semibold text-xs text-uppercase tracking-wider">Total Anggota</h6>
                <h3 class="mb-0 fw-bold">142</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-recycle"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="text-muted mb-1 fw-semibold text-xs text-uppercase tracking-wider">Sampah Masuk (Bulan Ini)</h6>
                <h3 class="mb-0 fw-bold">1,250 <small class="text-muted fs-6 fw-normal">kg</small></h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="text-muted mb-1 fw-semibold text-xs text-uppercase tracking-wider">Penjualan Koperasi</h6>
                <h3 class="mb-0 fw-bold">Rp 3.5M</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-info bg-opacity-10 text-info">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="text-muted mb-1 fw-semibold text-xs text-uppercase tracking-wider">Total Saldo Tabungan</h6>
                <h3 class="mb-0 fw-bold">Rp 12.4M</h3>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Activity -->
<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-header d-flex justify-content-between align-items-center p-3 p-md-4 bg-transparent border-bottom">
                <h5 class="admin-card-title mb-0 fw-bold fs-6 fs-md-5">Aktivitas Transaksi Terbaru</h5>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-xs fw-semibold">Lihat Semua</a>
            </div>

            <div class="admin-card-body p-3 p-md-4">
                <!-- Desktop & Tablet Table View (>= 768px) -->
                <div class="table-responsive border rounded-3 d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 border-bottom-0 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                <th class="border-bottom-0 py-3 text-xs text-uppercase text-muted">Anggota</th>
                                <th class="border-bottom-0 py-3 text-center text-xs text-uppercase text-muted">Jenis</th>
                                <th class="border-bottom-0 py-3 text-xs text-uppercase text-muted">Tanggal</th>
                                <th class="text-end pe-4 border-bottom-0 py-3 text-xs text-uppercase text-muted">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S010</span></td>
                                <td class="py-3 fw-semibold">Budi Santoso</td>
                                <td class="py-3 text-center"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">Setor Sampah</span></td>
                                <td class="text-muted text-sm py-3">Hari ini, 09:41</td>
                                <td class="text-end pe-4 fw-bold text-success py-3">+ Rp 15.000</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B045</span></td>
                                <td class="py-3 fw-semibold">Siti Aminah</td>
                                <td class="py-3 text-center"><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-medium">Belanja Koperasi</span></td>
                                <td class="text-muted text-sm py-3">Hari ini, 08:30</td>
                                <td class="text-end pe-4 fw-bold text-danger py-3">- Rp 45.000</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T002</span></td>
                                <td class="py-3 fw-semibold">Ahmad Fausi</td>
                                <td class="py-3 text-center"><span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1 fw-medium">Setor Tabungan</span></td>
                                <td class="text-muted text-sm py-3">Kemarin, 14:15</td>
                                <td class="text-end pe-4 fw-bold text-success py-3">+ Rp 100.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile List View (< 768px) -->
                <div class="trx-mobile-list d-block d-md-none">
                    <!-- Item 1 -->
                    <div class="trx-mobile-item p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Hari ini, 09:41</span>
                            <span class="badge bg-light text-dark border">TRX-S010</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Budi Santoso</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Jenis</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Setor Sampah</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted text-xs fw-semibold">Nominal</span>
                            <span class="fw-bold text-success text-base">+ Rp 15.000</span>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="trx-mobile-item p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Hari ini, 08:30</span>
                            <span class="badge bg-light text-dark border">TRX-B045</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Siti Aminah</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Jenis</span>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Belanja Koperasi</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted text-xs fw-semibold">Nominal</span>
                            <span class="fw-bold text-danger text-base">- Rp 45.000</span>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="trx-mobile-item p-3 mb-0 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>Kemarin, 14:15</span>
                            <span class="badge bg-light text-dark border">TRX-T002</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">Ahmad Fausi</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Jenis</span>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2 py-1 text-xs">Setor Tabungan</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted text-xs fw-semibold">Nominal</span>
                            <span class="fw-bold text-success text-base">+ Rp 100.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        <a href="{{ route('admin.setor-sampah.create') }}" class="text-decoration-none btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Input Setor Sampah</div>
                                <div class="text-xs text-white opacity-75">Catat setoran sampah baru</div>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="bi bi-recycle fs-5 text-white"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ route('admin.belanja-koperasi.pos') }}" class="text-decoration-none btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Kasir Koperasi</div>
                                <div class="text-xs text-white opacity-75">Input penjualan barang koperasi</div>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="bi bi-cart-plus fs-5 text-white"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ route('admin.tabungan.create') }}" class="text-decoration-none btn btn-primary text-white w-100 d-flex justify-content-between align-items-center p-3 text-start border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div>
                                <div class="fw-bold mb-1 text-white">Setor/Tarik Tabungan</div>
                                <div class="text-xs text-white opacity-75">Kelola saldo tabungan anggota</div>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="bi bi-wallet2 fs-5 text-white"></i>
                            </div>
                        </a>
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
                <h3 class="mb-0 fw-bold">{{ number_format($totalAnggota, 0, ',', '.') }}</h3>
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
                <h3 class="mb-0 fw-bold">{{ number_format($sampahMasukBulanIni, 1, ',', '.') }} <small class="text-muted fs-6 fw-normal">kg</small></h3>
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
                <h3 class="mb-0 fw-bold">Rp {{ number_format($penjualanKoperasiBulanIni, 0, ',', '.') }}</h3>
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
                <h3 class="mb-0 fw-bold">Rp {{ number_format($totalSaldoTabungan, 0, ',', '.') }}</h3>
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
                            @forelse($aktivitasTerbaru as $aktivitas)
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-{{ str_pad($aktivitas->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="py-3 fw-semibold">{{ $aktivitas->user->name ?? 'User Terhapus' }}</td>
                                <td class="py-3 text-center">
                                    @if($aktivitas->jenis == 'penukaran_sampah')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">Setor Sampah</span>
                                    @elseif($aktivitas->jenis == 'belanja')
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-medium">Belanja Koperasi</span>
                                    @elseif($aktivitas->jenis == 'deposit')
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1 fw-medium">Setor Tabungan</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 fw-medium">Penarikan</span>
                                    @endif
                                </td>
                                <td class="text-muted text-sm py-3">{{ $aktivitas->created_at->diffForHumans() }}</td>
                                <td class="text-end pe-4 fw-bold {{ in_array($aktivitas->jenis, ['penukaran_sampah', 'deposit']) ? 'text-success' : 'text-danger' }} py-3">
                                    {{ in_array($aktivitas->jenis, ['penukaran_sampah', 'deposit']) ? '+' : '-' }} Rp {{ number_format($aktivitas->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada aktivitas transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile List View (< 768px) -->
                <div class="trx-mobile-list d-block d-md-none">
                    @forelse($aktivitasTerbaru as $aktivitas)
                    <div class="trx-mobile-item p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>{{ $aktivitas->created_at->diffForHumans() }}</span>
                            <span class="badge bg-light text-dark border">TRX-{{ str_pad($aktivitas->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Anggota</span>
                            <span class="fw-bold text-sm text-dark">{{ $aktivitas->user->name ?? 'User Terhapus' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Jenis</span>
                            @if($aktivitas->jenis == 'penukaran_sampah')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Setor Sampah</span>
                            @elseif($aktivitas->jenis == 'belanja')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Belanja Koperasi</span>
                            @elseif($aktivitas->jenis == 'deposit')
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2 py-1 text-xs">Setor Tabungan</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Penarikan</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted text-xs fw-semibold">Nominal</span>
                            <span class="fw-bold {{ in_array($aktivitas->jenis, ['penukaran_sampah', 'deposit']) ? 'text-success' : 'text-danger' }} text-base">
                                {{ in_array($aktivitas->jenis, ['penukaran_sampah', 'deposit']) ? '+' : '-' }} Rp {{ number_format($aktivitas->nominal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted border rounded-3 bg-light">Belum ada aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

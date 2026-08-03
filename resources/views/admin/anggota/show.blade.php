@extends('layouts.admin')

@section('title', 'Detail Anggota')
@section('header_title', 'Detail Anggota')

@section('content')
<!-- Header Bar & Nav Back -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 d-flex align-items-center justify-content-between gap-2">
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.anggota.edit', 1) }}" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
            <button class="btn btn-outline-danger btn-sm px-3" title="Hapus Anggota" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-1"></i> Hapus
            </button>
        </div>
    </div>
</div>

<!-- Profile Hero Card -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm overflow-hidden">
            <div class="admin-card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start text-center text-sm-start mb-4 border-bottom pb-4 gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 72px; height: 72px; font-size: 1.8rem;">
                        <span class="fw-bold">B</span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start justify-content-between gap-2">
                            <div>
                                <h4 class="mb-1 fw-bold text-dark fs-4">Budi Santoso</h4>
                                <div class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center gap-2">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Anggota Aktif</span>
                                    <span class="badge bg-light text-dark border">ID: AGT-001</span>
                                </div>
                            </div>
                            <div class="bg-light p-2 px-3 rounded-3 border mt-2 mt-sm-0 text-center text-sm-end">
                                <span class="text-muted text-xs d-block mb-1">Total Saldo Tabungan</span>
                                <span class="fw-bold text-success fs-5">Rp 450.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-light text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-telephone fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs mb-1 text-uppercase tracking-wider">No. Telepon / WA</h6>
                                <p class="mb-0 fw-semibold text-sm text-dark">0812-3456-7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-light text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-card-heading fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs mb-1 text-uppercase tracking-wider">NIK Kependudukan</h6>
                                <p class="mb-0 fw-semibold text-sm text-dark">3171234567890001</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-light text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-geo-alt fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs mb-1 text-uppercase tracking-wider">Alamat Domisili</h6>
                                <p class="mb-0 fw-semibold text-sm text-dark">Jl. Merdeka No. 10 (RT 001 / RW 005), Jakarta</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-light text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-calendar-check fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs mb-1 text-uppercase tracking-wider">Bergabung Sejak</h6>
                                <p class="mb-0 fw-semibold text-sm text-dark">12 Januari 2026</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Section -->
<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <!-- Scrollable Tabs Header -->
            <div class="admin-card-header bg-transparent border-bottom-0 pt-3 px-3 px-md-4 pb-0 overflow-x-auto">
                <ul class="nav nav-tabs admin-tabs flex-nowrap text-nowrap" id="anggotaTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold text-xs text-md-sm" id="tabungan-tab" data-bs-toggle="tab" data-bs-target="#tabungan" type="button" role="tab">
                            <i class="bi bi-wallet2 me-1"></i> Riwayat Tabungan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-xs text-md-sm" id="sampah-tab" data-bs-toggle="tab" data-bs-target="#sampah" type="button" role="tab">
                            <i class="bi bi-recycle me-1"></i> Setor Sampah
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-xs text-md-sm" id="penjualan-tab" data-bs-toggle="tab" data-bs-target="#penjualan" type="button" role="tab">
                            <i class="bi bi-shop me-1"></i> Belanja Koperasi
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="admin-card-body p-3 p-md-4">
                <div class="tab-content" id="anggotaTabsContent">
                    <!-- TAB 1: Riwayat Tabungan -->
                    <div class="tab-pane fade show active" id="tabungan" role="tabpanel">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mb-md-4">
                            <h6 class="fw-bold mb-0 text-dark">Transaksi Saldo Tabungan</h6>
                            <button class="btn btn-outline-primary btn-sm rounded-pill align-self-start align-self-sm-center px-3">
                                <i class="bi bi-printer me-1"></i> Cetak Rekap Tabungan
                            </button>
                        </div>

                        <!-- Table View (Desktop & Tablet >= 768px) -->
                        <div class="table-responsive border rounded-3 d-none d-md-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Tanggal</th>
                                        <th class="py-3 text-center text-xs text-uppercase text-muted">Jenis Transaksi</th>
                                        <th class="py-3 text-end text-xs text-uppercase text-muted">Setor</th>
                                        <th class="py-3 text-end text-xs text-uppercase text-muted">Tarik</th>
                                        <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Sisa Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T040</span></td>
                                        <td class="py-3 text-muted text-sm">15 Jul 2026, 09:41</td>
                                        <td class="py-3 text-center"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Setor (Sampah)</span></td>
                                        <td class="py-3 text-end text-success fw-bold">+ Rp 25.000</td>
                                        <td class="py-3 text-end text-muted">-</td>
                                        <td class="pe-4 py-3 text-end fw-bold text-dark">Rp 450.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T035</span></td>
                                        <td class="py-3 text-muted text-sm">10 Jul 2026, 14:20</td>
                                        <td class="py-3 text-center"><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Tarik Tunai</span></td>
                                        <td class="py-3 text-end text-muted">-</td>
                                        <td class="py-3 text-end text-danger fw-bold">- Rp 100.000</td>
                                        <td class="pe-4 py-3 text-end fw-bold text-dark">Rp 425.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T020</span></td>
                                        <td class="py-3 text-muted text-sm">01 Jul 2026, 10:15</td>
                                        <td class="py-3 text-center"><span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">Setor Tunai</span></td>
                                        <td class="py-3 text-end text-success fw-bold">+ Rp 150.000</td>
                                        <td class="py-3 text-end text-muted">-</td>
                                        <td class="pe-4 py-3 text-end fw-bold text-dark">Rp 525.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List View (< 768px) -->
                        <div class="d-block d-md-none">
                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>15 Jul 2026, 09:41</span>
                                    <span class="badge bg-light text-dark border">TRX-T040</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Jenis</span>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Setor (Sampah)</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Nominal Setor</span>
                                    <span class="fw-bold text-success text-sm">+ Rp 25.000</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Sisa Saldo</span>
                                    <span class="fw-bold text-dark text-sm">Rp 450.000</span>
                                </div>
                            </div>

                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>10 Jul 2026, 14:20</span>
                                    <span class="badge bg-light text-dark border">TRX-T035</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Jenis</span>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Tarik Tunai</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Nominal Tarik</span>
                                    <span class="fw-bold text-danger text-sm">- Rp 100.000</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Sisa Saldo</span>
                                    <span class="fw-bold text-dark text-sm">Rp 425.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- TAB 2: Riwayat Setor Sampah -->
                    <div class="tab-pane fade" id="sampah" role="tabpanel">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mb-md-4">
                            <h6 class="fw-bold mb-0 text-dark">Riwayat Penyetoran Sampah</h6>
                            <button class="btn btn-outline-success btn-sm rounded-pill align-self-start align-self-sm-center px-3">
                                <i class="bi bi-download me-1"></i> Cetak Laporan Sampah
                            </button>
                        </div>

                        <!-- Table View (Desktop & Tablet >= 768px) -->
                        <div class="table-responsive border rounded-3 d-none d-md-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Tanggal</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Kategori Sampah</th>
                                        <th class="py-3 text-end text-xs text-uppercase text-muted">Berat (kg)</th>
                                        <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S045</span></td>
                                        <td class="py-3 text-muted text-sm">15 Jul 2026</td>
                                        <td class="py-3 fw-semibold">Plastik PET (Botol Mineral)</td>
                                        <td class="py-3 text-end fw-semibold">5.0 kg</td>
                                        <td class="pe-4 py-3 text-end text-success fw-bold">+ Rp 15.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S045</span></td>
                                        <td class="py-3 text-muted text-sm">15 Jul 2026</td>
                                        <td class="py-3 fw-semibold">Kardus Bekas</td>
                                        <td class="py-3 text-end fw-semibold">10.0 kg</td>
                                        <td class="pe-4 py-3 text-end text-success fw-bold">+ Rp 10.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S012</span></td>
                                        <td class="py-3 text-muted text-sm">28 Jun 2026</td>
                                        <td class="py-3 fw-semibold">Besi/Logam Tebal</td>
                                        <td class="py-3 text-end fw-semibold">2.5 kg</td>
                                        <td class="pe-4 py-3 text-end text-success fw-bold">+ Rp 12.500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List View (< 768px) -->
                        <div class="d-block d-md-none">
                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>15 Jul 2026</span>
                                    <span class="badge bg-light text-dark border">TRX-S045</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Kategori</span>
                                    <span class="fw-semibold text-sm">Plastik PET</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Berat</span>
                                    <span class="fw-semibold text-sm">5.0 kg</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Pendapatan</span>
                                    <span class="fw-bold text-success text-sm">+ Rp 15.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- TAB 3: Riwayat Penjualan Koperasi -->
                    <div class="tab-pane fade" id="penjualan" role="tabpanel">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mb-md-4">
                            <h6 class="fw-bold mb-0 text-dark">Riwayat Pembelian Barang Koperasi</h6>
                            <button class="btn btn-outline-warning btn-sm rounded-pill text-dark px-3 align-self-start align-self-sm-center">
                                <i class="bi bi-receipt me-1"></i> Cetak Struk Belanja
                            </button>
                        </div>

                        <!-- Table View (Desktop & Tablet >= 768px) -->
                        <div class="table-responsive border rounded-3 d-none d-md-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Tanggal</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Item Barang Belanja</th>
                                        <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Total Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B080</span></td>
                                        <td class="py-3 text-muted text-sm">12 Jul 2026</td>
                                        <td class="py-3">
                                            <div class="text-sm">
                                                <div>• 2x Minyak Goreng 1L (Rp 28.000)</div>
                                                <div>• 1x Gula Pasir 1kg (Rp 20.000)</div>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-bold text-danger">- Rp 48.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B045</span></td>
                                        <td class="py-3 text-muted text-sm">05 Jul 2026</td>
                                        <td class="py-3">
                                            <div class="text-sm">
                                                <div>• 1x Beras Premium 5kg (Rp 68.000)</div>
                                                <div>• 3x Mie Instan (Rp 10.500)</div>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-bold text-danger">- Rp 78.500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List View (< 768px) -->
                        <div class="d-block d-md-none">
                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>12 Jul 2026</span>
                                    <span class="badge bg-light text-dark border">TRX-B080</span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-muted text-xs d-block mb-1">Item Barang Belanja</span>
                                    <div class="text-sm fw-medium">
                                        <div>• 2x Minyak Goreng 1L</div>
                                        <div>• 1x Gula Pasir 1kg</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Total Pembayaran</span>
                                    <span class="fw-bold text-danger text-sm">- Rp 48.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
.admin-tabs .nav-link {
    color: var(--secondary);
    border: none;
    border-bottom: 2px solid transparent;
    padding: 0.75rem 1.25rem;
    transition: all 0.2s ease;
}

.admin-tabs .nav-link:hover {
    color: var(--primary);
}

.admin-tabs .nav-link.active {
    color: var(--primary);
    border-bottom-color: var(--primary);
    background: transparent;
}
</style>
@endsection

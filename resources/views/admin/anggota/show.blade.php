@extends('layouts.admin')

@section('title', 'Detail Anggota')
@section('header_title', 'Detail Anggota')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div>
            <a href="{{ route('admin.anggota.edit', 1) }}" class="btn btn-primary btn-sm shadow-sm me-2">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
            <button class="btn btn-danger btn-sm shadow-sm">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
</div>

<!-- Profile Summary -->
<div class="row mb-4">
    <div class="col-12">
        <div class="admin-card shadow-sm border overflow-hidden">
            <div class="admin-card-body p-4">
                <div class="d-flex align-items-center mb-4 border-bottom pb-4">
                    <div class="bg-white p-1 rounded-circle shadow-sm me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <span class="fw-bold">B</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">Budi Santoso</h4>
                        <span class="badge text-dark rounded-pill" style="background-color: rgba(40, 167, 69, 0.2);">Anggota Aktif</span>
                        <span class="text-muted ms-2 text-sm">ID: AGT-001</span>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-telephone text-success fs-5 me-3"></i>
                            <div>
                                <h6 class="text-muted text-sm mb-1">Nomor Telepon</h6>
                                <p class="mb-0 fw-semibold">0812-3456-7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-geo-alt text-success fs-5 me-3"></i>
                            <div>
                                <h6 class="text-muted text-sm mb-1">Alamat</h6>
                                <p class="mb-0 fw-semibold">Jl. Merdeka No. 10, RT 001/RW 005, Jakarta</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-calendar-check text-success fs-5 me-3"></i>
                            <div>
                                <h6 class="text-muted text-sm mb-1">Bergabung Sejak</h6>
                                <p class="mb-0 fw-semibold">12 Januari 2026</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Section -->
<div class="row">
    <div class="col-12">
        <div class="admin-card shadow-sm border">
            <div class="admin-card-header bg-transparent border-bottom-0 pt-3 px-4 pb-0">
                <ul class="nav nav-tabs admin-tabs" id="anggotaTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="tabungan-tab" data-bs-toggle="tab" data-bs-target="#tabungan" type="button" role="tab">Riwayat Tabungan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="sampah-tab" data-bs-toggle="tab" data-bs-target="#sampah" type="button" role="tab">Riwayat Setor Sampah</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="penjualan-tab" data-bs-toggle="tab" data-bs-target="#penjualan" type="button" role="tab">Riwayat Penjualan</button>
                    </li>
                </ul>
            </div>
            
            <div class="admin-card-body p-4">
                <div class="tab-content" id="anggotaTabsContent">
                    <!-- Riwayat Tabungan -->
                    <div class="tab-pane fade show active" id="tabungan" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="text-muted mb-1 text-sm">Total Saldo Saat Ini</h6>
                                <h4 class="text-primary fw-bold mb-0">Rp 450.000</h4>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="bi bi-printer me-1"></i> Download Rekap</button>
                        </div>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3 border-bottom-0">No. TRX</th>
                                        <th class="py-3 border-bottom-0">Tanggal</th>
                                        <th class="py-3 border-bottom-0 text-center">Jenis</th>
                                        <th class="py-3 border-bottom-0 text-end">Setor</th>
                                        <th class="py-3 border-bottom-0 text-end">Tarik</th>
                                        <th class="pe-4 py-3 border-bottom-0 text-end">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-T040</span></td>
                                        <td class="py-3 text-muted text-sm">15 Jul 2026</td>
                                        <td class="py-3 text-center"><span class="badge text-dark rounded-pill px-3" style="background-color: rgba(40, 167, 69, 0.2);">Setor (Sampah)</span></td>
                                        <td class="py-3 text-end text-success fw-semibold">+ Rp 25.000</td>
                                        <td class="py-3 text-end">-</td>
                                        <td class="pe-4 py-3 text-end fw-bold">Rp 450.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-T035</span></td>
                                        <td class="py-3 text-muted text-sm">10 Jul 2026</td>
                                        <td class="py-3 text-center"><span class="badge text-dark rounded-pill px-3" style="background-color: rgba(220, 53, 69, 0.2);">Tarik Tunai</span></td>
                                        <td class="py-3 text-end">-</td>
                                        <td class="py-3 text-end text-danger fw-semibold">- Rp 100.000</td>
                                        <td class="pe-4 py-3 text-end fw-bold">Rp 425.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-T020</span></td>
                                        <td class="py-3 text-muted text-sm">01 Jul 2026</td>
                                        <td class="py-3 text-center"><span class="badge text-dark rounded-pill px-3" style="background-color: rgba(144, 238, 144, 0.4);">Setor Tunai</span></td>
                                        <td class="py-3 text-end text-success fw-semibold">+ Rp 150.000</td>
                                        <td class="py-3 text-end">-</td>
                                        <td class="pe-4 py-3 text-end fw-bold">Rp 525.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Riwayat Setor Sampah -->
                    <div class="tab-pane fade" id="sampah" role="tabpanel">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-outline-success btn-sm"><i class="bi bi-download me-1"></i> Download Rekap</button>
                        </div>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3 border-bottom-0">No. TRX</th>
                                        <th class="py-3 border-bottom-0">Tanggal</th>
                                        <th class="py-3 border-bottom-0">Kategori</th>
                                        <th class="py-3 border-bottom-0 text-end">Berat (kg)</th>
                                        <th class="pe-4 py-3 border-bottom-0 text-end">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-S045</span></td>
                                        <td class="py-3 text-muted text-sm">15 Jul 2026</td>
                                        <td class="py-3">Plastik PET</td>
                                        <td class="py-3 text-end fw-semibold">5.0</td>
                                        <td class="pe-4 py-3 text-end text-success fw-semibold">Rp 15.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-S045</span></td>
                                        <td class="py-3 text-muted text-sm">15 Jul 2026</td>
                                        <td class="py-3">Kardus</td>
                                        <td class="py-3 text-end fw-semibold">10.0</td>
                                        <td class="pe-4 py-3 text-end text-success fw-semibold">Rp 10.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-S012</span></td>
                                        <td class="py-3 text-muted text-sm">28 Jun 2026</td>
                                        <td class="py-3">Besi/Logam</td>
                                        <td class="py-3 text-end fw-semibold">2.5</td>
                                        <td class="pe-4 py-3 text-end text-success fw-semibold">Rp 12.500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Riwayat Penjualan -->
                    <div class="tab-pane fade" id="penjualan" role="tabpanel">
                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-outline-warning btn-sm text-dark"><i class="bi bi-receipt me-1"></i> Cetak Struk Terakhir</button>
                        </div>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3 border-bottom-0">No. TRX</th>
                                        <th class="py-3 border-bottom-0">Tanggal</th>
                                        <th class="py-3 border-bottom-0">Item Belanja</th>
                                        <th class="pe-4 py-3 border-bottom-0 text-end">Total Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-B080</span></td>
                                        <td class="py-3 text-muted text-sm">12 Jul 2026</td>
                                        <td class="py-3">
                                            <ul class="list-unstyled mb-0 text-sm">
                                                <li>- 2x Minyak Goreng 1L</li>
                                                <li>- 1x Gula Pasir 1kg</li>
                                            </ul>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-semibold text-danger">- Rp 48.000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border">TRX-B045</span></td>
                                        <td class="py-3 text-muted text-sm">05 Jul 2026</td>
                                        <td class="py-3">
                                            <ul class="list-unstyled mb-0 text-sm">
                                                <li>- 1x Beras Premium 5kg</li>
                                                <li>- 3x Mie Instan</li>
                                            </ul>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-semibold text-danger">- Rp 78.500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Tab Styles */
.admin-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 1rem 1.5rem;
    transition: all 0.2s ease;
}

.admin-tabs .nav-link:hover {
    color: #198754;
    border-color: transparent;
}

.admin-tabs .nav-link.active {
    color: #198754;
    border-color: transparent;
    border-bottom-color: #198754;
    background: transparent;
}
</style>
@endsection

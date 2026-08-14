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
            <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
            <button class="btn btn-outline-danger btn-sm px-3" title="Hapus Anggota" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-1"></i> Hapus
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Profile Hero Card -->
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm overflow-hidden">
            <div class="admin-card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start text-center text-sm-start mb-4 border-bottom pb-4 gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 72px; height: 72px; font-size: 1.8rem;">
                        <span class="fw-bold">{{ substr($anggota->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-grow-1 w-100">
                        <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start justify-content-between gap-2">
                            <div>
                                <h4 class="mb-1 fw-bold text-dark fs-4">{{ $anggota->name }}</h4>
                                <div class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center gap-2">
                                    @if($anggota->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Anggota Aktif</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Anggota Nonaktif</span>
                                    @endif
                                    <span class="badge bg-light text-dark border">ID: {{ $anggota->nomor_anggota }}</span>
                                </div>
                            </div>
                            <div class="bg-light p-2 px-3 rounded-3 border mt-2 mt-sm-0 text-center text-sm-end d-flex gap-3">
                                <div>
                                    <span class="text-muted text-xs d-block mb-1">Saldo Koperasi</span>
                                    <span class="fw-bold text-primary fs-5">Rp {{ number_format($anggota->saldo, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-muted text-xs d-block mb-1">Saldo Tabungan</span>
                                    <span class="fw-bold text-success fs-5">Rp {{ number_format($anggota->saldo_tabungan, 0, ',', '.') }}</span>
                                </div>
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
                                <p class="mb-0 fw-semibold text-sm text-dark">{{ $anggota->no_hp }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <div class="bg-light text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-envelope fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-xs mb-1 text-uppercase tracking-wider">Email</h6>
                                <p class="mb-0 fw-semibold text-sm text-dark">{{ $anggota->email ?? '-' }}</p>
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
                                <p class="mb-0 fw-semibold text-sm text-dark">{{ $anggota->alamat }}</p>
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
                                <p class="mb-0 fw-semibold text-sm text-dark">{{ $anggota->created_at->format('d F Y') }}</p>
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
                            <h6 class="fw-bold mb-0 text-dark">Transaksi Saldo Tabungan (Terbaru)</h6>
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
                                    @forelse($riwayatTabungan as $trx)
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-T{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td class="py-3 text-muted text-sm">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                        <td class="py-3 text-center">
                                            @if($trx->jenis == 'setor')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Setor Tunai</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Tarik Tunai</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-end {{ $trx->jenis == 'setor' ? 'text-success fw-bold' : 'text-muted' }}">
                                            {{ $trx->jenis == 'setor' ? '+ Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="py-3 text-end {{ $trx->jenis == 'tarik' ? 'text-danger fw-bold' : 'text-muted' }}">
                                            {{ $trx->jenis == 'tarik' ? '- Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-bold text-dark">Rp {{ number_format($trx->saldo_sesudah, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat tabungan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List View (< 768px) -->
                        <div class="d-block d-md-none">
                            @forelse($riwayatTabungan as $trx)
                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>{{ $trx->created_at->format('d M Y, H:i') }}</span>
                                    <span class="badge bg-light text-dark border">TRX-T{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Jenis</span>
                                    @if($trx->jenis == 'setor')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Setor Tunai</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Tarik Tunai</span>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Nominal</span>
                                    <span class="fw-bold {{ $trx->jenis == 'setor' ? 'text-success' : 'text-danger' }} text-sm">
                                        {{ $trx->jenis == 'setor' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Sisa Saldo</span>
                                    <span class="fw-bold text-dark text-sm">Rp {{ number_format($trx->saldo_sesudah, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted border rounded-3 bg-light">Belum ada riwayat tabungan.</div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- TAB 2: Riwayat Setor Sampah -->
                    <div class="tab-pane fade" id="sampah" role="tabpanel">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mb-md-4">
                            <h6 class="fw-bold mb-0 text-dark">Riwayat Penyetoran Sampah (Terbaru)</h6>
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
                                    @forelse($riwayatSampah as $trx)
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-S{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td class="py-3 text-muted text-sm">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                        <td class="py-3 fw-semibold">{{ $trx->kategoriSampah->nama ?? '-' }}</td>
                                        <td class="py-3 text-end fw-semibold">{{ $trx->berat }} kg</td>
                                        <td class="pe-4 py-3 text-end text-success fw-bold">+ Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat setor sampah.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List View (< 768px) -->
                        <div class="d-block d-md-none">
                            @forelse($riwayatSampah as $trx)
                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>{{ $trx->created_at->format('d M Y') }}</span>
                                    <span class="badge bg-light text-dark border">TRX-S{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Kategori</span>
                                    <span class="fw-semibold text-sm">{{ $trx->kategoriSampah->nama ?? '-' }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-xs">Berat</span>
                                    <span class="fw-semibold text-sm">{{ $trx->berat }} kg</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Pendapatan</span>
                                    <span class="fw-bold text-success text-sm">+ Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted border rounded-3 bg-light">Belum ada riwayat setor sampah.</div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- TAB 3: Riwayat Penjualan Koperasi -->
                    <div class="tab-pane fade" id="penjualan" role="tabpanel">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 mb-md-4">
                            <h6 class="fw-bold mb-0 text-dark">Riwayat Pembelian Barang Koperasi (Terbaru)</h6>
                        </div>

                        <!-- Table View (Desktop & Tablet >= 768px) -->
                        <div class="table-responsive border rounded-3 d-none d-md-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Tanggal</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Status</th>
                                        <th class="py-3 text-xs text-uppercase text-muted">Item Barang Belanja</th>
                                        <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Total Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayatBelanja as $trx)
                                    <tr>
                                        <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td class="py-3 text-muted text-sm">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                        <td class="py-3">
                                            @if($trx->status == 'selesai')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Selesai</span>
                                            @elseif($trx->status == 'batal')
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Batal</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <div class="text-sm">
                                                @foreach($trx->details as $detail)
                                                <div>• {{ $detail->jumlah }}x {{ $detail->kategoriProduk->nama ?? 'Produk' }} (Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }})</div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-bold text-danger">- Rp {{ number_format($trx->total_belanja, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat belanja.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List View (< 768px) -->
                        <div class="d-block d-md-none">
                            @forelse($riwayatBelanja as $trx)
                            <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                    <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>{{ $trx->created_at->format('d M Y') }}</span>
                                    <span class="badge bg-light text-dark border">TRX-B{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-muted text-xs d-block mb-1">Item Barang Belanja</span>
                                    <div class="text-sm fw-medium">
                                        @foreach($trx->details as $detail)
                                        <div>• {{ $detail->jumlah }}x {{ $detail->kategoriProduk->nama ?? 'Produk' }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="text-muted text-xs fw-semibold">Total Pembayaran</span>
                                    <span class="fw-bold text-danger text-sm">- Rp {{ number_format($trx->total_belanja, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted border rounded-3 bg-light">Belum ada riwayat belanja.</div>
                            @endforelse
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
                        <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" style="margin:0;">
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

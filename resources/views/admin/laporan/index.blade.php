@extends('layouts.admin')

@section('title', 'Laporan')
@section('header_title', 'Laporan')

@section('content')
{{-- Unified Header & Filter Bar --}}
<div class="admin-card border-0 shadow-sm mb-3 mb-md-4 d-print-none">
    <div class="admin-card-body p-3 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
        <div>
            <h5 class="fw-bold mb-1"><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan SIBAS</h5>
            <div class="text-sm text-muted">Periode: <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($dari)->translatedFormat('d M Y') }} — {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d M Y') }}</span></div>
        </div>
        
        <form action="{{ route('admin.laporan') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
            <input type="hidden" name="tab" value="{{ $tab }}">
            
            <div class="d-flex align-items-center gap-2">
                <span class="text-xs fw-semibold text-muted text-uppercase d-none d-md-inline">Filter:</span>
                <select name="periode" class="form-select text-sm form-select-sm" style="width: auto; min-width: 140px;" onchange="toggleCustomDate(this)">
                    <option value="bulan_ini" {{ $periode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="bulan_lalu" {{ $periode == 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                    <option value="3_bulan" {{ $periode == '3_bulan' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                </select>
            </div>
        
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm text-white px-3">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>
                <button type="button" class="btn btn-outline-dark btn-sm px-3" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Cetak
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tab Navigation --}}
<ul class="nav nav-pills laporan-tabs mb-3 mb-md-4 d-print-none flex-nowrap overflow-auto" style="gap: 8px; padding-bottom: 5px;">
    <li class="nav-item">
        <a class="nav-link text-sm px-3 py-2 {{ $tab == 'sampah' ? 'active' : '' }}" href="{{ route('admin.laporan', ['tab' => 'sampah', 'periode' => $periode, 'dari' => \Carbon\Carbon::parse($dari)->format('Y-m-d'), 'sampai' => \Carbon\Carbon::parse($sampai)->format('Y-m-d')]) }}">
            <i class="bi bi-trash3 me-1"></i> Setor Sampah
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-sm px-3 py-2 {{ $tab == 'belanja' ? 'active' : '' }}" href="{{ route('admin.laporan', ['tab' => 'belanja', 'periode' => $periode, 'dari' => \Carbon\Carbon::parse($dari)->format('Y-m-d'), 'sampai' => \Carbon\Carbon::parse($sampai)->format('Y-m-d')]) }}">
            <i class="bi bi-cart3 me-1"></i> Belanja Koperasi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-sm px-3 py-2 {{ $tab == 'tabungan' ? 'active' : '' }}" href="{{ route('admin.laporan', ['tab' => 'tabungan', 'periode' => $periode, 'dari' => \Carbon\Carbon::parse($dari)->format('Y-m-d'), 'sampai' => \Carbon\Carbon::parse($sampai)->format('Y-m-d')]) }}">
            <i class="bi bi-wallet2 me-1"></i> Tabungan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-sm px-3 py-2 {{ $tab == 'inventory' ? 'active' : '' }}" href="{{ route('admin.laporan', ['tab' => 'inventory', 'periode' => $periode, 'dari' => \Carbon\Carbon::parse($dari)->format('Y-m-d'), 'sampai' => \Carbon\Carbon::parse($sampai)->format('Y-m-d')]) }}">
            <i class="bi bi-box-seam me-1"></i> Inventory
        </a>
    </li>
</ul>

{{-- Print Header (Kop Surat) --}}
<div class="d-none d-print-block mb-4" style="color: black !important;">
    <div class="d-flex align-items-center justify-content-center border-bottom border-dark border-3 pb-3 mb-1" style="border-bottom-style: double !important;">
        <div class="text-center">
            <h3 class="fw-bold mb-1" style="text-transform: uppercase;">Sistem Informasi Bank Sampah & Koperasi</h3>
            <h2 class="fw-bold mb-1">SIBAS</h2>
            <p class="mb-0" style="font-size: 14px;">Jl. Raya Lingkungan No. 123, Kota Bersih, Kode Pos 12345</p>
            <p class="mb-0" style="font-size: 14px;">Telp: (021) 12345678 | Email: admin@sibas.com | Website: www.sibas.com</p>
        </div>
    </div>
    
    <div class="text-center mt-4 mb-4">
        <h5 class="fw-bold mb-1" style="text-decoration: underline;">
            @if($tab == 'sampah') LAPORAN TRANSAKSI SETOR SAMPAH
            @elseif($tab == 'belanja') LAPORAN TRANSAKSI BELANJA KOPERASI
            @elseif($tab == 'tabungan') LAPORAN KEUANGAN TABUNGAN ANGGOTA
            @elseif($tab == 'inventory') LAPORAN STOK INVENTORY BARANG
            @endif
        </h5>
        <p class="mb-0" style="font-size: 14px;">Periode: {{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}</p>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- TAB: SETOR SAMPAH --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
@if($tab == 'sampah')
    {{-- Widgets --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Transaksi</span>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($data['totalTransaksi']) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Berat</span>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($data['totalBerat'], 1) }} Kg</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Nilai</span>
                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($data['totalNilai'], 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Anggota Aktif</span>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($data['totalAnggotaAktif']) }} Orang</h4>
            </div>
        </div>
    </div>

    {{-- Sampah Per Kategori --}}
    @if($data['sampahPerKategori']->count() > 0)
    <div class="admin-card border-0 shadow-sm mb-3 mb-md-4">
        <div class="admin-card-header bg-transparent border-bottom p-3">
            <h6 class="admin-card-title mb-0 fw-bold">Rekap Per Jenis Sampah</h6>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-3 text-xs text-uppercase text-muted">Jenis Sampah</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Jumlah Transaksi</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Total Berat</th>
                            <th class="pe-3 py-3 text-end text-xs text-uppercase text-muted">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['sampahPerKategori'] as $item)
                        <tr>
                            <td class="ps-3 py-3 fw-semibold text-sm">{{ $item->kategoriSampah->nama ?? '-' }}</td>
                            <td class="py-3 text-end text-sm">{{ number_format($item->jumlah_transaksi) }}x</td>
                            <td class="py-3 text-end text-sm">{{ number_format(floatval($item->total_berat), 1) }} Kg</td>
                            <td class="pe-3 py-3 text-end fw-bold text-success text-sm">Rp {{ number_format(floatval($item->total_nilai), 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Detail Transaksi --}}
    <div class="admin-card border-0 shadow-sm">
        <div class="admin-card-header bg-transparent border-bottom p-3">
            <h6 class="admin-card-title mb-0 fw-bold">Detail Transaksi Setor Sampah</h6>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-3 text-xs text-uppercase text-muted">Tanggal</th>
                            <th class="py-3 text-xs text-uppercase text-muted">Anggota</th>
                            <th class="py-3 text-xs text-uppercase text-muted">Jenis Sampah</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Berat</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Harga/Kg</th>
                            <th class="pe-3 py-3 text-end text-xs text-uppercase text-muted">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['transaksiList'] as $trx)
                        <tr>
                            <td class="ps-3 py-3 text-sm text-muted">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 text-sm fw-semibold">{{ $trx->user->name ?? '-' }}</td>
                            <td class="py-3 text-sm">{{ $trx->kategoriSampah->nama ?? '-' }}</td>
                            <td class="py-3 text-end text-sm">{{ number_format(floatval($trx->berat), 1) }} Kg</td>
                            <td class="py-3 text-end text-sm text-muted">Rp {{ number_format(floatval($trx->harga_satuan), 0, ',', '.') }}</td>
                            <td class="pe-3 py-3 text-end fw-bold text-success text-sm">Rp {{ number_format(floatval($trx->total), 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data transaksi setor sampah pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($data['transaksiList']->hasPages())
        <div class="admin-card-footer p-3 border-top d-print-none">
            {{ $data['transaksiList']->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
@endif

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- TAB: BELANJA KOPERASI --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
@if($tab == 'belanja')
    {{-- Widgets --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Transaksi</span>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($data['totalTransaksi']) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Omzet / Penjualan</span>
                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($data['totalOmzet'], 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Bayar Saldo</span>
                <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($data['totalBayarSaldo'], 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Bayar Tunai</span>
                <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($data['totalBayarTunai'], 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    {{-- Produk Terlaris --}}
    @if($data['produkTerlaris']->count() > 0)
    <div class="admin-card border-0 shadow-sm mb-3 mb-md-4">
        <div class="admin-card-header bg-transparent border-bottom p-3">
            <h6 class="admin-card-title mb-0 fw-bold">Produk Terlaris</h6>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-3 text-xs text-uppercase text-muted">#</th>
                            <th class="py-3 text-xs text-uppercase text-muted">Nama Produk</th>
                            <th class="py-3 text-center text-xs text-uppercase text-muted">Qty Terjual</th>
                            <th class="pe-3 py-3 text-end text-xs text-uppercase text-muted">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['produkTerlaris'] as $i => $item)
                        <tr>
                            <td class="ps-3 py-3 text-sm fw-bold text-muted">{{ $i + 1 }}</td>
                            <td class="py-3 text-sm fw-semibold">{{ $item->kategoriProduk->nama ?? '-' }}</td>
                            <td class="py-3 text-center text-sm">{{ number_format(floatval($item->total_terjual)) }} {{ $item->kategoriProduk->satuan ?? 'pcs' }}</td>
                            <td class="pe-3 py-3 text-end fw-bold text-success text-sm">Rp {{ number_format(floatval($item->total_pendapatan), 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Detail Transaksi --}}
    <div class="admin-card border-0 shadow-sm">
        <div class="admin-card-header bg-transparent border-bottom p-3">
            <h6 class="admin-card-title mb-0 fw-bold">Detail Transaksi Belanja Koperasi</h6>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-3 text-xs text-uppercase text-muted">Tanggal</th>
                            <th class="py-3 text-xs text-uppercase text-muted">Pembeli</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Total</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Saldo</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Tunai</th>
                            <th class="pe-3 py-3 text-center text-xs text-uppercase text-muted">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['transaksiList'] as $trx)
                        <tr>
                            <td class="ps-3 py-3 text-sm text-muted">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 text-sm fw-semibold">{{ $trx->user->name ?? 'Umum / Non-Anggota' }}</td>
                            <td class="py-3 text-end fw-bold text-sm">Rp {{ number_format(floatval($trx->total_belanja), 0, ',', '.') }}</td>
                            <td class="py-3 text-end text-sm text-muted">Rp {{ number_format(floatval($trx->bayar_saldo), 0, ',', '.') }}</td>
                            <td class="py-3 text-end text-sm text-muted">Rp {{ number_format(floatval($trx->bayar_tunai), 0, ',', '.') }}</td>
                            <td class="pe-3 py-3 text-center">
                                @if($trx->status == 'selesai')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Selesai</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">{{ ucfirst($trx->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data transaksi belanja pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($data['transaksiList']->hasPages())
        <div class="admin-card-footer p-3 border-top d-print-none">
            {{ $data['transaksiList']->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
@endif

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- TAB: TABUNGAN --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
@if($tab == 'tabungan')
    {{-- Widgets --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Setoran</span>
                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($data['totalSetor'], 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Penarikan</span>
                <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($data['totalTarik'], 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Jumlah Transaksi</span>
                <h4 class="fw-bold text-dark mb-0">{{ number_format($data['jumlahTransaksi']) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Dana Kelola Saat Ini</span>
                <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($data['totalDanaKelola'], 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    {{-- Detail Transaksi --}}
    <div class="admin-card border-0 shadow-sm">
        <div class="admin-card-header bg-transparent border-bottom p-3">
            <h6 class="admin-card-title mb-0 fw-bold">Detail Riwayat Tabungan</h6>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-3 text-xs text-uppercase text-muted">Tanggal</th>
                            <th class="py-3 text-xs text-uppercase text-muted">Anggota</th>
                            <th class="py-3 text-center text-xs text-uppercase text-muted">Jenis</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Nominal</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Saldo Sesudah</th>
                            <th class="pe-3 py-3 text-xs text-uppercase text-muted">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['transaksiList'] as $trx)
                        <tr>
                            <td class="ps-3 py-3 text-sm text-muted">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 text-sm fw-semibold">{{ $trx->user->name ?? '-' }}</td>
                            <td class="py-3 text-center">
                                @if($trx->jenis == 'setor')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Setor</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Tarik</span>
                                @endif
                            </td>
                            <td class="py-3 text-end fw-bold text-sm {{ $trx->jenis == 'setor' ? 'text-success' : 'text-danger' }}">
                                {{ $trx->jenis == 'setor' ? '+' : '-' }}Rp {{ number_format(floatval($trx->nominal), 0, ',', '.') }}
                            </td>
                            <td class="py-3 text-end text-sm text-muted">Rp {{ number_format(floatval($trx->saldo_sesudah), 0, ',', '.') }}</td>
                            <td class="pe-3 py-3 text-sm text-muted">{{ $trx->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data riwayat tabungan pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($data['transaksiList']->hasPages())
        <div class="admin-card-footer p-3 border-top d-print-none">
            {{ $data['transaksiList']->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
@endif

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- TAB: INVENTORY --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
@if($tab == 'inventory')
    {{-- Widgets --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Total Produk</span>
                <h4 class="fw-bold text-dark mb-0">{{ $data['totalProduk'] }} <small class="text-muted text-sm fw-normal">({{ $data['produkAktif'] }} aktif)</small></h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Stok Menipis</span>
                <h4 class="fw-bold text-warning mb-0">{{ $data['stokMenipis'] }} Produk</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Stok Habis</span>
                <h4 class="fw-bold text-danger mb-0">{{ $data['stokHabis'] }} Produk</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-card border-0 shadow-sm p-3 h-100">
                <span class="text-muted text-xs text-uppercase tracking-wider fw-semibold d-block mb-1">Estimasi Nilai</span>
                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($data['nilaiInventaris'], 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="admin-card border-0 shadow-sm">
        <div class="admin-card-header bg-transparent border-bottom p-3">
            <h6 class="admin-card-title mb-0 fw-bold">Daftar Produk (diurutkan dari stok terendah)</h6>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-3 text-xs text-uppercase text-muted">Produk</th>
                            <th class="py-3 text-end text-xs text-uppercase text-muted">Harga Jual</th>
                            <th class="py-3 text-center text-xs text-uppercase text-muted">Sisa Stok</th>
                            <th class="pe-3 py-3 text-center text-xs text-uppercase text-muted">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['produkList'] as $produk)
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 border flex-shrink-0" style="width: 40px; height: 40px; overflow: hidden;">
                                        @if($produk->foto)
                                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <i class="bi bi-box-seam fs-5 text-secondary"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark text-sm">{{ $produk->nama }}</h6>
                                        <span class="text-xs text-muted">{{ $produk->satuan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-end fw-bold text-success text-sm">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                            <td class="py-3 text-center">
                                <span class="fw-bold {{ $produk->stok <= 0 ? 'text-danger' : ($produk->stok <= 5 ? 'text-warning' : 'text-dark') }} text-sm">{{ floatval($produk->stok) }}</span>
                            </td>
                            <td class="pe-3 py-3 text-center">
                                @if($produk->stok <= 0)
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 text-xs">Habis</span>
                                @elseif($produk->stok <= 5)
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 text-xs">Menipis</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">Aman</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($data['produkList']->hasPages())
        <div class="admin-card-footer p-3 border-top d-print-none">
            {{ $data['produkList']->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
@endif


{{-- Tanda Tangan Cetak --}}
<div class="d-none d-print-block mt-5 pt-4 page-break-inside-avoid">
    <div class="row">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p class="mb-1">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="mb-5">Mengetahui,<br><b>Admin SIBAS</b></p>
            <br><br>
            <p class="mb-0 fw-bold" style="text-decoration: underline;">{{ auth()->user()->name }}</p>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function toggleCustomDate(select) {
        const fields = document.querySelectorAll('.custom-date-field');
        fields.forEach(f => f.style.display = select.value === 'custom' ? '' : 'none');
    }
</script>
@endsection

{{-- Print Styles --}}
<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 2cm;
        }
        body {
            font-size: 11pt !important;
            font-family: "Times New Roman", Times, serif !important;
            color: #000 !important;
            background: #fff !important;
        }
        .admin-sidebar, .admin-header, .d-print-none, .pagination, .bi {
            display: none !important;
        }
        .admin-main {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }
        .admin-card, .admin-card-body, .table-responsive {
            box-shadow: none !important;
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin-bottom: 1.5rem !important;
            border-radius: 0 !important;
            overflow: visible !important;
        }
        .admin-card-header {
            border: none !important;
            padding: 0 !important;
            margin-bottom: 1rem !important;
            border-radius: 0 !important;
        }
        /* Tables */
        table, .table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 1rem !important;
            border-radius: 0 !important;
            border: 1px solid #000 !important;
        }
        table > :not(caption) > * > * {
            box-shadow: none !important;
        }
        table, th, td {
            border: 1px solid #000 !important;
            color: #000 !important;
        }
        th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
            color: #000 !important;
            font-weight: bold !important;
            text-align: left;
            padding: 8px !important;
        }
        td {
            padding: 6px 8px !important;
        }
        /* Ensure badges look like normal text or simple borders in print */
        .badge {
            border: 1px solid #000 !important;
            color: #000 !important;
            background: transparent !important;
            padding: 2px 6px !important;
            border-radius: 0 !important;
            font-weight: normal !important;
        }
        /* Widgets layout */
        .row.g-3.mb-3 {
            display: flex !important;
            flex-wrap: wrap !important;
            border: 1px solid #000 !important;
            margin-bottom: 2rem !important;
            border-radius: 0 !important;
        }
        .row.g-3.mb-3 > div {
            flex: 1 !important;
            border-right: 1px solid #000 !important;
            padding: 10px !important;
        }
        .row.g-3.mb-3 > div:last-child {
            border-right: none !important;
        }
        .admin-card h4 {
            font-size: 16pt !important;
            margin-top: 5px !important;
            color: #000 !important;
        }
        .page-break-inside-avoid {
            page-break-inside: avoid !important;
        }
    }
    
    /* Custom Green Tabs for Laporan */
    .laporan-tabs .nav-link {
        color: #495057;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .laporan-tabs .nav-link:hover:not(.active) {
        background-color: #e2e6ea;
        border-color: #dae0e5;
    }
    .laporan-tabs .nav-link.active {
        background-color: #198754 !important; /* Success Green */
        border-color: #198754 !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(25, 135, 84, 0.2);
    }
</style>
@endsection

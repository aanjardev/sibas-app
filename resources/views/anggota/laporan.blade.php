@extends('layouts.mobile')

@section('title', 'Laporan Aktivitas')
@section('header_title', 'Laporan & Rekap')

@section('content')
<!-- Filter & Export Action Bar -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2 mb-3">
    <!-- Period Selector Dropdown / Modal Trigger -->
    <div class="dropdown flex-grow-1">
        <button class="btn bg-white border text-dark w-100 d-flex justify-content-between align-items-center py-2 px-3 shadow-sm rounded-3 text-sm fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span><i class="bi bi-calendar3 me-2 text-primary"></i>{{ $periodeLabel }}</span>
            <i class="bi bi-chevron-down text-muted text-xs"></i>
        </button>
        <ul class="dropdown-menu w-100 shadow border-0 rounded-3 text-sm">
            <li><a class="dropdown-item py-2 {{ $periode === 'bulan_ini' ? 'active fw-bold' : '' }}" href="{{ route('laporan', ['periode' => 'bulan_ini', 'tab' => $tab]) }}">Bulan Ini</a></li>
            <li><a class="dropdown-item py-2 {{ $periode === 'bulan_lalu' ? 'active fw-bold' : '' }}" href="{{ route('laporan', ['periode' => 'bulan_lalu', 'tab' => $tab]) }}">Bulan Lalu</a></li>
            <li><a class="dropdown-item py-2 {{ $periode === '3_bulan' ? 'active fw-bold' : '' }}" href="{{ route('laporan', ['periode' => '3_bulan', 'tab' => $tab]) }}">3 Bulan Terakhir</a></li>
            <li><a class="dropdown-item py-2 {{ $periode === 'semua' ? 'active fw-bold' : '' }}" href="{{ route('laporan', ['periode' => 'semua', 'tab' => $tab]) }}">Semua Periode</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item py-2 text-primary fw-medium" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#customDateModal"><i class="bi bi-sliders me-2"></i>Pilih Rentang Tanggal...</a></li>
        </ul>
    </div>

    <!-- Export PDF Button -->
    <a href="{{ route('laporan.export_pdf', request()->query()) }}" class="btn btn-danger d-flex justify-content-center align-items-center gap-2 py-2 px-3 shadow-sm rounded-3 text-sm fw-bold text-white flex-shrink-0" target="_blank">
        <i class="bi bi-file-earmark-pdf-fill fs-6"></i>
        <span>Download PDF</span>
    </a>
</div>

<!-- Account Summary Card -->
<div class="mb-3">
    <div class="primary-card p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <p class="mb-0 text-white text-xs opacity-75 text-uppercase tracking-wider">Rekapitulasi Akun</p>
                <h5 class="fw-bold mb-0 text-white">{{ $user->name }}</h5>
                <small class="text-white opacity-75 text-xs">No. Anggota: {{ $user->nomor_anggota ?? '-' }}</small>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-dark rounded-pill px-3 py-1 text-xs fw-bold shadow-sm">
                    Saldo: Rp {{ number_format($user->saldo_tabungan, 0, ',', '.') }}
                </span>
            </div>
        </div>
        
        <div class="row g-2 mt-2 pt-2" style="border-top: 1px dashed rgba(255,255,255,0.3);">
            <div class="col-4 text-center border-end" style="border-color: rgba(255,255,255,0.2) !important;">
                <p class="text-white text-xs opacity-75 mb-0">Total Sampah</p>
                <h6 class="fw-bold text-white mb-0 text-sm">{{ number_format($totalBeratSampah, 1) }} kg</h6>
            </div>
            <div class="col-4 text-center border-end" style="border-color: rgba(255,255,255,0.2) !important;">
                <p class="text-white text-xs opacity-75 mb-0">Cashback</p>
                <h6 class="fw-bold text-white mb-0 text-sm">Rp {{ number_format($totalCashbackSampah, 0, ',', '.') }}</h6>
            </div>
            <div class="col-4 text-center">
                <p class="text-white text-xs opacity-75 mb-0">Total Belanja</p>
                <h6 class="fw-bold text-white mb-0 text-sm">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h6>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Stats Grid -->
<div class="row g-2 mb-3">
    <div class="col-6">
        <div class="surface-card p-3 h-100">
            <div class="d-flex align-items-center mb-1">
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-down-left fs-6"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block">Setor Tunai</span>
                    <strong class="text-success text-sm">Rp {{ number_format($totalSetorTabungan, 0, ',', '.') }}</strong>
                </div>
            </div>
            <span class="text-muted text-xs">{{ $riwayatTabungan->where('jenis', 'setor')->count() }} kali transaksi</span>
        </div>
    </div>
    <div class="col-6">
        <div class="surface-card p-3 h-100">
            <div class="d-flex align-items-center mb-1">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-arrow-up-right fs-6"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block">Tarik Tunai</span>
                    <strong class="text-danger text-sm">Rp {{ number_format($totalTarikTabungan, 0, ',', '.') }}</strong>
                </div>
            </div>
            <span class="text-muted text-xs">{{ $riwayatTabungan->where('jenis', 'tarik')->count() }} kali transaksi</span>
        </div>
    </div>
</div>

<!-- Category Tabs -->
<div class="d-flex gap-1 overflow-x-auto pb-2 mb-2" style="scrollbar-width: none;">
    <a href="{{ route('laporan', array_merge(request()->query(), ['tab' => 'semua'])) }}" class="btn btn-sm rounded-pill px-3 fw-bold text-nowrap {{ $tab === 'semua' ? 'btn-dark text-white' : 'btn-light text-muted border' }}">
        Semua ({{ $semuaTransaksi->count() }})
    </a>
    <a href="{{ route('laporan', array_merge(request()->query(), ['tab' => 'sampah'])) }}" class="btn btn-sm rounded-pill px-3 fw-bold text-nowrap {{ $tab === 'sampah' ? 'btn-success text-white' : 'btn-light text-muted border' }}">
        Setor Sampah ({{ $jumlahTransaksiSampah }})
    </a>
    <a href="{{ route('laporan', array_merge(request()->query(), ['tab' => 'belanja'])) }}" class="btn btn-sm rounded-pill px-3 fw-bold text-nowrap {{ $tab === 'belanja' ? 'btn-primary text-white' : 'btn-light text-muted border' }}">
        Belanja ({{ $jumlahTransaksiBelanja }})
    </a>
    <a href="{{ route('laporan', array_merge(request()->query(), ['tab' => 'tabungan'])) }}" class="btn btn-sm rounded-pill px-3 fw-bold text-nowrap {{ $tab === 'tabungan' ? 'btn-warning text-dark' : 'btn-light text-muted border' }}">
        Tabungan ({{ $jumlahTransaksiTabungan }})
    </a>
</div>

<!-- Transaction List -->
<div class="surface-card p-3 mb-4">
    @if ($tab === 'semua')
        @forelse ($semuaTransaksi as $trx)
            <div class="history-item {{ $trx->type === 'sampah' ? 'setor-sampah' : ($trx->type === 'belanja' ? 'belanja' : ($trx->is_plus ? 'setor-tunai' : 'tarik-tunai')) }}">
                <div class="overflow-hidden flex-grow-1 pe-2">
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <span class="badge {{ $trx->badge_class }} text-xs py-0.5 px-1.5 rounded-1">{{ $trx->badge }}</span>
                        <h6 class="mb-0 text-sm fw-bold text-truncate">{{ $trx->title }}</h6>
                    </div>
                    <div class="text-muted text-xs text-truncate">{{ $trx->detail }}</div>
                </div>
                <div class="text-end flex-shrink-0">
                    <h6 class="amount mb-1 text-sm fw-bold">{{ $trx->is_plus ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}</h6>
                    <div class="text-muted text-xs">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="bi bi-inbox text-muted fs-1"></i>
                <p class="text-muted text-sm mt-2 mb-0">Tidak ada riwayat aktivitas pada periode ini.</p>
            </div>
        @endforelse
    @elseif ($tab === 'sampah')
        @forelse ($transaksiSampah as $item)
            <div class="history-item setor-sampah">
                <div class="overflow-hidden flex-grow-1 pe-2">
                    <h6 class="mb-1 text-sm fw-bold text-truncate">{{ $item->kategoriSampah->nama_kategori ?? 'Sampah' }}</h6>
                    <div class="text-muted text-xs">{{ number_format($item->berat, 1) }} kg @ Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}/kg</div>
                </div>
                <div class="text-end flex-shrink-0">
                    <h6 class="amount mb-1 text-sm fw-bold text-success">+ Rp {{ number_format($item->total, 0, ',', '.') }}</h6>
                    <div class="text-muted text-xs">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="bi bi-recycle text-muted fs-1"></i>
                <p class="text-muted text-sm mt-2 mb-0">Tidak ada transaksi setor sampah pada periode ini.</p>
            </div>
        @endforelse
    @elseif ($tab === 'belanja')
        @forelse ($transaksiBelanja as $item)
            <div class="history-item belanja">
                <div class="overflow-hidden flex-grow-1 pe-2">
                    <h6 class="mb-1 text-sm fw-bold text-truncate">Belanja Koperasi</h6>
                    <div class="text-muted text-xs text-truncate">
                        {{ $item->details->map(fn($d) => ($d->kategoriProduk->nama_produk ?? 'Item') . ' (' . $d->jumlah . ')')->implode(', ') }}
                    </div>
                </div>
                <div class="text-end flex-shrink-0">
                    <h6 class="amount mb-1 text-sm fw-bold text-danger">- Rp {{ number_format($item->total_belanja, 0, ',', '.') }}</h6>
                    <div class="text-muted text-xs">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="bi bi-shop text-muted fs-1"></i>
                <p class="text-muted text-sm mt-2 mb-0">Tidak ada transaksi belanja pada periode ini.</p>
            </div>
        @endforelse
    @elseif ($tab === 'tabungan')
        @forelse ($riwayatTabungan as $item)
            <div class="history-item {{ $item->jenis === 'setor' ? 'setor-tunai' : 'tarik-tunai' }}">
                <div class="overflow-hidden flex-grow-1 pe-2">
                    <h6 class="mb-1 text-sm fw-bold text-truncate">{{ $item->jenis === 'setor' ? 'Setor Tunai' : 'Tarik Tunai' }}</h6>
                    <div class="text-muted text-xs text-truncate">{{ $item->keterangan ?: '-' }}</div>
                </div>
                <div class="text-end flex-shrink-0">
                    <h6 class="amount mb-1 text-sm fw-bold">{{ $item->jenis === 'setor' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}</h6>
                    <div class="text-muted text-xs">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="bi bi-wallet2 text-muted fs-1"></i>
                <p class="text-muted text-sm mt-2 mb-0">Tidak ada transaksi tabungan pada periode ini.</p>
            </div>
        @endforelse
    @endif
</div>

<!-- Custom Date Range Modal -->
<div class="modal fade" id="customDateModal" tabindex="-1" aria-labelledby="customDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 380px;">
        <div class="modal-content shadow" style="border-radius: 16px; border: none;">
            <div class="modal-header border-bottom p-3">
                <h6 class="modal-title fw-bold" id="customDateModalLabel"><i class="bi bi-calendar-range me-2 text-primary"></i>Pilih Rentang Tanggal</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('laporan') }}" method="GET">
                <input type="hidden" name="periode" value="custom">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label for="dari" class="form-label fw-semibold text-sm">Dari Tanggal</label>
                        <input type="date" class="form-control text-sm" id="dari" name="dari" value="{{ $dari->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="sampai" class="form-label fw-semibold text-sm">Sampai Tanggal</label>
                        <input type="date" class="form-control text-sm" id="sampai" name="sampai" value="{{ $sampai->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold text-sm border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary w-50 fw-bold text-sm text-white">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

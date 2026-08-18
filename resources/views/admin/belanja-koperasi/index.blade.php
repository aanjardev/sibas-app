@extends('layouts.admin')

@section('title', 'Belanja Koperasi')
@section('header_title', 'Belanja Koperasi')

@section('content')

{{-- Action Bar --}}
<div class="row g-3 mb-3 mb-md-4 align-items-center">
    <div class="col-12 col-md-auto">
        <a href="{{ route('admin.belanja-koperasi.pos') }}" class="btn btn-primary btn-sm text-white shadow-sm d-flex align-items-center justify-content-center py-2 px-3 fw-semibold" style="min-width: 180px;">
            <i class="bi bi-cart-plus me-2"></i> Buka Kasir
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="col-12 col-md">
        <form action="{{ route('admin.belanja-koperasi.index') }}" method="GET">
            <div class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-white border-start-0 text-sm" placeholder="Cari No TRX, nama pembeli...">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
                <select name="status" class="form-select bg-white text-sm" style="min-width: 160px; max-width: 200px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Summary Widgets --}}
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-receipt text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Transaksi Hari Ini</span>
            </div>
            <h4 class="fw-bold text-dark mb-0">{{ $transaksiHariIni ?? 0 }} Transaksi</h4>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-success bg-opacity-10 text-success rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-cash-stack text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Omzet Hari Ini</span>
            </div>
            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-warning bg-opacity-10 text-warning rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-wallet2 text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Bayar Saldo Hari Ini</span>
            </div>
            <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($bayarSaldoHariIni ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-3 d-none d-lg-block">
        <div class="admin-card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="bg-info bg-opacity-10 text-info rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;">
                    <i class="bi bi-cash text-sm"></i>
                </div>
                <span class="text-muted text-xs text-uppercase fw-semibold">Bayar Tunai Hari Ini</span>
            </div>
            <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($bayarTunaiHariIni ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

{{-- Riwayat Transaksi Table --}}
<div class="row g-3">
    <div class="col-12">
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-0">

                {{-- Desktop Table View (>= 768px) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">No. TRX</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Waktu</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Pembeli</th>
                                <th class="py-3 text-xs text-uppercase text-muted">Item Dibeli</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Metode</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Total</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Status</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiList as $trx)
                            <tr>
                                <td class="ps-4 py-3"><span class="badge bg-light text-dark border fw-medium">TRX-B{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="py-3 text-muted text-sm">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark text-sm">{{ $trx->user->name ?? 'Pelanggan Umum' }}</div>
                                    <div class="text-xs text-muted">{{ $trx->user->nomor_anggota ?? 'Non-Anggota' }}</div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($trx->details->take(2) as $detail)
                                            <span class="badge bg-light text-dark border text-xs">{{ $detail->kategoriProduk->nama ?? 'Produk' }} x{{ $detail->jumlah }}</span>
                                        @endforeach
                                        @if($trx->details->count() > 2)
                                            <span class="badge bg-light text-dark border text-xs">+{{ $trx->details->count() - 2 }} item</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    @if($trx->bayar_saldo > 0 && $trx->bayar_tunai == 0)
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2 py-1 text-xs">
                                            <i class="bi bi-wallet2 me-1"></i>Saldo
                                        </span>
                                    @elseif($trx->bayar_tunai > 0 && $trx->bayar_saldo == 0)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 text-xs">
                                            <i class="bi bi-cash me-1"></i>Tunai
                                        </span>
                                    @else
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 text-xs">
                                            Campuran
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-end fw-bold text-dark text-sm">Rp {{ number_format($trx->total_belanja - $trx->diskon, 0, ',', '.') }}</td>
                                <td class="py-3 text-center">
                                    @if($trx->status == 'selesai')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">Selesai</span>
                                    @elseif($trx->status == 'batal')
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 fw-medium">Batal</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-medium">Pending</span>
                                    @endif
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.belanja-koperasi.show', $trx->id) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.belanja-koperasi.edit', $trx->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            onclick="confirmDelete({{ $trx->id }}, 'TRX-B{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}', '{{ addslashes($trx->user->name ?? 'Pelanggan Umum') }}', 'Rp {{ number_format($trx->total_belanja - $trx->diskon, 0, ',', '.') }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi belanja koperasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card List View (< 768px) --}}
                <div class="d-block d-md-none p-3">
                    @forelse($transaksiList as $trx)
                    <div class="p-3 mb-2 rounded-3 border bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border">TRX-B{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                                @if($trx->status == 'selesai')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs">Selesai</span>
                                @elseif($trx->status == 'batal')
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill text-xs">Batal</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill text-xs">Pending</span>
                                @endif
                            </div>
                            <span class="text-muted text-xs"><i class="bi bi-clock me-1"></i>{{ $trx->created_at->format('H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-xs">Pembeli</span>
                            <span class="fw-bold text-sm text-dark">{{ $trx->user->name ?? 'Pelanggan Umum' }} <small class="text-muted fw-normal">({{ $trx->user->nomor_anggota ?? 'Non-Anggota' }})</small></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted text-xs">Metode</span>
                            @if($trx->bayar_saldo > 0 && $trx->bayar_tunai == 0)
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill text-xs"><i class="bi bi-wallet2 me-1"></i>Saldo</span>
                            @elseif($trx->bayar_tunai > 0 && $trx->bayar_saldo == 0)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs"><i class="bi bi-cash me-1"></i>Tunai</span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill text-xs">Campuran</span>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @foreach($trx->details->take(2) as $detail)
                                <span class="badge bg-light text-dark border text-xs">{{ $detail->kategoriProduk->nama ?? 'Produk' }} x{{ $detail->jumlah }}</span>
                            @endforeach
                            @if($trx->details->count() > 2)
                                <span class="badge bg-light text-dark border text-xs">+{{ $trx->details->count() - 2 }} item</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                            <span class="text-muted text-xs">Total Belanja</span>
                            <span class="text-dark fw-bold text-base">Rp {{ number_format($trx->total_belanja - $trx->diskon, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.belanja-koperasi.show', $trx->id) }}" class="btn btn-sm btn-outline-secondary flex-fill text-xs py-1"><i class="bi bi-eye me-1"></i>Detail</a>
                            <a href="{{ route('admin.belanja-koperasi.edit', $trx->id) }}" class="btn btn-sm btn-outline-primary text-xs py-1 px-2"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger text-xs py-1 px-2" onclick="confirmDelete({{ $trx->id }}, 'TRX-B{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}', '{{ addslashes($trx->user->name ?? 'Pelanggan Umum') }}', 'Rp {{ number_format($trx->total_belanja - $trx->diskon, 0, ',', '.') }}')"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted border rounded-3 bg-light">Belum ada transaksi belanja koperasi.</div>
                    @endforelse
                </div>
            </div>

            {{-- Footer Pagination --}}
            <div class="admin-card-footer p-3 p-md-4 border-top">
                {{ $transaksiList->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Transaksi --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-1 text-dark">Hapus Transaksi?</h5>
                <p class="text-muted text-xs mb-1">No. Transaksi: <strong id="del_trx_id" class="text-dark">-</strong></p>
                <p class="text-muted text-xs mb-1">Pembeli: <strong id="del_pembeli" class="text-dark">-</strong></p>
                <p class="text-muted text-xs mb-4">Total: <strong id="del_total" class="text-danger">-</strong></p>
                <p class="text-muted text-xs mb-4">Data transaksi dan rincian item akan dihapus permanen. Stok barang akan dikembalikan.</p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    </div>
                    <div class="col-6">
                        <form id="deleteForm" action="" method="POST" style="margin:0;">
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
.pagination .page-link { color: var(--primary); }
.pagination .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: white; }
.pagination .page-link:hover { color: var(--primary-dark); background-color: #e9ecef; }
</style>

@endsection

@section('scripts')
<script>
    function confirmDelete(id, trxId, pembeli, total) {
        document.getElementById('del_trx_id').innerText = trxId;
        document.getElementById('del_pembeli').innerText = pembeli;
        document.getElementById('del_total').innerText = total;
        
        var form = document.getElementById('deleteForm');
        form.action = '/admin/belanja-koperasi/' + id;
        
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection

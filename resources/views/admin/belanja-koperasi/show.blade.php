@extends('layouts.admin')

@section('title', 'Detail Transaksi — TRX-B' . str_pad($transaksi->id, 4, '0', STR_PAD_LEFT))
@section('header_title', 'Detail Transaksi Belanja')

@section('content')

{{-- Back & Action Bar --}}
<div class="row g-3 mb-3 mb-md-4">
    <div class="col-12 d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <a href="{{ route('admin.belanja-koperasi.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Riwayat Transaksi
        </a>
        <div class="d-flex gap-2 flex-wrap">
            <button onclick="window.print()" class="btn btn-success btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-printer me-1"></i> Cetak Nota
            </button>
            <a href="{{ route('admin.belanja-koperasi.edit', $transaksi->id) }}" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <button class="btn btn-outline-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash me-1"></i> Hapus
            </button>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Status Banner --}}
<div class="row g-3 mb-3">
    <div class="col-12">
        @if($transaksi->status == 'selesai')
        <div class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="background: #f0f7f3; border-color: #c3dece !important;">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                <i class="bi bi-check-lg fs-5"></i>
            </div>
            <div>
                <div class="fw-bold text-dark">Transaksi Selesai — Lunas</div>
                <div class="text-xs text-muted">Diselesaikan pada {{ $transaksi->updated_at->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</div>
            </div>
            <div class="ms-auto text-end d-none d-sm-block">
                <div class="text-xs text-muted mb-0">No. Transaksi</div>
                <span class="badge bg-dark px-3 py-2 fw-bold">TRX-B{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        @elseif($transaksi->status == 'batal')
        <div class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="background: #fdf0f0; border-color: #f5c2c7 !important;">
            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                <i class="bi bi-x-lg fs-5"></i>
            </div>
            <div>
                <div class="fw-bold text-dark">Transaksi Dibatalkan</div>
                <div class="text-xs text-muted">Dibatalkan pada {{ $transaksi->updated_at->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</div>
            </div>
            <div class="ms-auto text-end d-none d-sm-block">
                <div class="text-xs text-muted mb-0">No. Transaksi</div>
                <span class="badge bg-dark px-3 py-2 fw-bold">TRX-B{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        @else
        <div class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="background: #fff8eb; border-color: #f9d69c !important;">
            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                <i class="bi bi-hourglass-split fs-5"></i>
            </div>
            <div>
                <div class="fw-bold text-dark">Transaksi Pending</div>
                <div class="text-xs text-muted">Dibuat pada {{ $transaksi->created_at->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</div>
            </div>
            <div class="ms-auto text-end d-none d-sm-block">
                <div class="text-xs text-muted mb-0">No. Transaksi</div>
                <span class="badge bg-dark px-3 py-2 fw-bold">TRX-B{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="row g-3" id="printArea">
    {{-- ── Left: Nota Detail ── --}}
    <div class="col-12 col-lg-8">

        {{-- Header Nota --}}
        <div class="admin-card border-0 shadow-sm mb-3">
            <div class="admin-card-body p-3 p-md-4">
                {{-- Kop Nota --}}
                <div class="text-center border-bottom pb-3 mb-3 print-kop">
                    <div class="fw-bold fs-5" style="color: var(--primary);">KOPERASI SIBAS</div>
                    <div class="text-xs text-muted">Sistem Bank Sampah Terpadu</div>
                </div>

                {{-- Info Transaksi --}}
                <div class="row g-2 mb-2">
                    <div class="col-6 col-sm-3">
                        <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">No. TRX</div>
                        <div class="fw-bold text-sm">TRX-B{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">Tanggal</div>
                        <div class="fw-bold text-sm">{{ $transaksi->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">Jam</div>
                        <div class="fw-bold text-sm">{{ $transaksi->created_at->format('H:i') }} WIB</div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">Kasir</div>
                        <div class="fw-bold text-sm">Sistem</div>
                    </div>
                </div>

                <hr style="border-color: #e8f0ea;">

                <div class="row g-2">
                    <div class="col-6">
                        <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">Pembeli</div>
                        <div class="fw-bold text-sm">{{ $transaksi->user->name ?? 'Pelanggan Umum' }}</div>
                        <div class="text-xs text-muted">Anggota · ID: {{ $transaksi->user->nomor_anggota ?? 'Non-Anggota' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">Metode Bayar</div>
                        @if($transaksi->bayar_saldo > 0 && $transaksi->bayar_tunai == 0)
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1 fw-medium">
                                <i class="bi bi-wallet2 me-1"></i>Saldo Tabungan
                            </span>
                        @elseif($transaksi->bayar_tunai > 0 && $transaksi->bayar_saldo == 0)
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium">
                                <i class="bi bi-cash me-1"></i>Tunai
                            </span>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-medium">
                                <i class="bi bi-cash-coin me-1"></i>Campuran
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Rincian Item --}}
        <div class="admin-card border-0 shadow-sm mb-3">
            <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                <h6 class="fw-bold mb-0">Rincian Item Belanja</h6>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr>
                                <th class="ps-4 py-3 text-xs text-uppercase text-muted">Produk</th>
                                <th class="py-3 text-center text-xs text-uppercase text-muted">Qty</th>
                                <th class="py-3 text-end text-xs text-uppercase text-muted">Harga Satuan</th>
                                <th class="pe-4 py-3 text-end text-xs text-uppercase text-muted">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->details as $detail)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-semibold text-sm">{{ $detail->kategoriProduk->nama ?? 'Produk' }}</div>
                                    <div class="text-xs text-muted">{{ $detail->kategoriProduk->sku ?? '-' }}</div>
                                </td>
                                <td class="py-3 text-center fw-bold text-sm">{{ $detail->jumlah }}</td>
                                <td class="py-3 text-end text-muted text-sm">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="pe-4 py-3 text-end fw-bold text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-top">
                            <tr style="background: #f0f7f3;">
                                <td colspan="3" class="ps-4 py-3 text-end fw-bold">SUBTOTAL</td>
                                <td class="pe-4 py-3 text-end fw-bold fs-5">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</td>
                            </tr>
                            @if($transaksi->diskon > 0)
                            <tr>
                                <td colspan="3" class="ps-4 py-2 text-end text-sm text-muted fw-semibold">Diskon</td>
                                <td class="pe-4 py-2 text-end text-sm fw-bold text-danger">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                            </tr>
                            <tr style="background: #e8f5e9;">
                                <td colspan="3" class="ps-4 py-3 text-end fw-bold">GRAND TOTAL</td>
                                <td class="pe-4 py-3 text-end fw-bold fs-5" style="color: var(--primary);">Rp {{ number_format($transaksi->total_belanja - $transaksi->diskon, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if($transaksi->bayar_saldo > 0)
                            <tr>
                                <td colspan="3" class="ps-4 py-2 text-end text-sm text-muted fw-semibold">Bayar Saldo</td>
                                <td class="pe-4 py-2 text-end text-sm fw-bold">Rp {{ number_format($transaksi->bayar_saldo, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if($transaksi->bayar_tunai > 0)
                            <tr>
                                <td colspan="3" class="ps-4 py-2 text-end text-sm text-muted fw-semibold">Bayar Tunai</td>
                                <td class="pe-4 py-2 text-end text-sm fw-bold">Rp {{ number_format($transaksi->bayar_tunai, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="ps-4 py-2 text-end text-sm text-muted fw-semibold">Uang Diterima</td>
                                <td class="pe-4 py-2 text-end text-sm fw-bold text-success">Rp {{ number_format($transaksi->uang_diterima, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="ps-4 py-2 text-end text-sm text-muted fw-semibold">Kembalian</td>
                                <td class="pe-4 py-2 text-end text-sm fw-bold">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-3 p-md-4">
                <div class="text-xs text-muted text-uppercase fw-semibold tracking-wider mb-1">Catatan Transaksi</div>
                <div class="text-sm text-dark">{{ $transaksi->keterangan ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- ── Right: Summary & Quick Actions ── --}}
    <div class="col-12 col-lg-4 no-print">
        {{-- Quick Summary Card --}}
        <div class="admin-card border-0 shadow-sm mb-3">
            <div class="admin-card-header bg-transparent border-bottom p-3">
                <h6 class="fw-bold mb-0 text-sm">Ringkasan Transaksi</h6>
            </div>
            <div class="admin-card-body p-3">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="text-muted text-xs">Total Item</span>
                    <span class="fw-bold text-sm">{{ $transaksi->details->sum('jumlah') }} item ({{ $transaksi->details->count() }} jenis)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="text-muted text-xs">Total Belanja</span>
                    <span class="fw-bold text-sm">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</span>
                </div>
                @if($transaksi->diskon > 0)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="text-muted text-xs">Diskon</span>
                    <span class="fw-bold text-sm text-danger">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="text-muted text-xs">Grand Total</span>
                    <span class="fw-bold text-sm" style="color:var(--primary);">Rp {{ number_format($transaksi->total_belanja - $transaksi->diskon, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="text-muted text-xs">Metode</span>
                    @if($transaksi->bayar_saldo > 0 && $transaksi->bayar_tunai == 0)
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill text-xs">Saldo Tabungan</span>
                    @elseif($transaksi->bayar_tunai > 0 && $transaksi->bayar_saldo == 0)
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs">Tunai</span>
                    @else
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill text-xs">Campuran</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <span class="text-muted text-xs">Status</span>
                    @if($transaksi->status == 'selesai')
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill text-xs">Lunas</span>
                    @elseif($transaksi->status == 'batal')
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill text-xs">Batal</span>
                    @else
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill text-xs">Pending</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="admin-card border-0 shadow-sm">
            <div class="admin-card-body p-3 d-grid gap-2">
                <button onclick="window.print()" class="btn btn-success text-white fw-semibold py-2">
                    <i class="bi bi-printer me-2"></i>Cetak Nota Struk
                </button>
                <a href="{{ route('admin.belanja-koperasi.edit', $transaksi->id) }}" class="btn btn-primary text-white fw-semibold py-2">
                    <i class="bi bi-pencil me-2"></i>Edit Transaksi
                </a>
                <button class="btn btn-outline-danger fw-semibold py-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash me-2"></i>Hapus Transaksi
                </button>
                <a href="{{ route('admin.belanja-koperasi.pos') }}" class="btn btn-outline-primary fw-semibold py-2">
                    <i class="bi bi-cart-plus me-2"></i>Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                    <i class="bi bi-trash fs-3"></i>
                </div>
                <h5 class="fw-bold mb-2 text-dark">Hapus Transaksi Ini?</h5>
                <p class="text-muted text-xs mb-4">Transaksi <strong>TRX-B{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</strong> akan dihapus permanen. Stok barang dan saldo tabungan akan dikembalikan secara otomatis.</p>
                <div class="row g-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    </div>
                    <div class="col-6">
                        <form action="{{ route('admin.belanja-koperasi.destroy', $transaksi->id) }}" method="POST" style="margin:0;">
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
@media print {
    /* Hide non-printable elements */
    .admin-header, .admin-sidebar, .no-print,
    .btn, nav, .modal { display: none !important; }
    /* Reset layout for print */
    .admin-main { margin: 0 !important; padding: 0 !important; }
    .col-lg-8 { width: 100% !important; }
    .admin-card { border: 1px solid #ddd !important; box-shadow: none !important; page-break-inside: avoid; }
    body { background: white !important; font-size: 11pt; }
    .print-kop { border-bottom: 2px dashed #333 !important; }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@if(request('print'))
<script>
    window.onload = function() {
        window.print();
    }
</script>
@endif
@endsection

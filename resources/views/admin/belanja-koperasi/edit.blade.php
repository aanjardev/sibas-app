@extends('layouts.admin')

@section('title', 'Edit Transaksi — TRX-B' . str_pad($transaksi->id, 4, '0', STR_PAD_LEFT))
@section('header_title', 'Edit Transaksi Belanja')

@section('content')

<form action="{{ route('admin.belanja-koperasi.update', $transaksi->id) }}" method="POST" id="editForm">
    @csrf
    @method('PUT')

    {{-- Back & Save Bar --}}
    <div class="row g-3 mb-3 mb-md-4">
        <div class="col-12 d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <a href="{{ route('admin.belanja-koperasi.show', $transaksi->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
            </a>
            <div class="d-flex gap-2">
                <button type="reset" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary btn-sm text-white px-3 shadow-sm">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Info Alert --}}
    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="d-flex align-items-start gap-2 p-3 rounded-3 border" style="background:#fffbf0; border-color:#f0d070 !important;">
                <i class="bi bi-exclamation-triangle-fill text-warning mt-0.5 flex-shrink-0"></i>
                <div class="text-xs text-muted">
                    <strong class="text-dark">Catatan:</strong> Halaman ini untuk mengoreksi status atau catatan transaksi. 
                    Perubahan item belanja dan metode bayar tidak dapat dilakukan di sini untuk menjaga integritas data keuangan dan stok.
                    No. Transaksi: <strong class="text-dark">TRX-B{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">

            {{-- Data Pembeli (Readonly) --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2" style="color:var(--primary);"></i>Data Pembeli</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-sm">Pembeli</label>
                        <input type="text" class="form-control text-sm" value="{{ $transaksi->user->name ?? 'Pelanggan Umum' }} ({{ $transaksi->user->nomor_anggota ?? 'Non-Anggota' }})" readonly disabled>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-sm">Metode Pembayaran</label>
                        @if($transaksi->bayar_saldo > 0 && $transaksi->bayar_tunai == 0)
                            <input type="text" class="form-control text-sm" value="Saldo Tabungan (Rp {{ number_format($transaksi->bayar_saldo, 0, ',', '.') }})" readonly disabled>
                        @elseif($transaksi->bayar_tunai > 0 && $transaksi->bayar_saldo == 0)
                            <input type="text" class="form-control text-sm" value="Tunai (Rp {{ number_format($transaksi->bayar_tunai, 0, ',', '.') }})" readonly disabled>
                        @else
                            <input type="text" class="form-control text-sm" value="Campuran (Saldo: Rp {{ number_format($transaksi->bayar_saldo, 0, ',', '.') }} | Tunai: Rp {{ number_format($transaksi->bayar_tunai, 0, ',', '.') }})" readonly disabled>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Status Transaksi --}}
            <div class="admin-card border-0 shadow-sm mb-3">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-check-circle me-2" style="color:var(--primary);"></i>Status Transaksi</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <label for="status" class="form-label fw-semibold text-sm">Status <span class="text-danger">*</span></label>
                    <select class="form-select text-sm" id="status" name="status">
                        <option value="selesai" {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>Selesai / Lunas</option>
                        <option value="pending" {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="batal" {{ old('status', $transaksi->status) == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @if($transaksi->status == 'batal')
                    <small class="text-danger mt-1 d-block"><i class="bi bi-exclamation-circle me-1"></i>Transaksi yang sudah dibatalkan sebaiknya tidak diubah kembali ke selesai.</small>
                    @endif
                </div>
            </div>

            {{-- Catatan --}}
            <div class="admin-card border-0 shadow-sm">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-chat-left-text me-2" style="color:var(--primary);"></i>Catatan</h6>
                </div>
                <div class="admin-card-body p-3 p-md-4">
                    <label for="keterangan" class="form-label fw-semibold text-sm">Catatan Transaksi</label>
                    <textarea class="form-control text-sm" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── Right: Rincian Item (Read-only) ── --}}
        <div class="col-12 col-lg-5">
            <div class="admin-card border-0 shadow-sm" style="position: sticky; top: 1rem;">
                <div class="admin-card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0">Rincian Item Belanja</h6>
                    <span class="badge bg-light text-muted border text-xs">Read-only</span>
                </div>
                <div class="admin-card-body p-0">
                    <div class="p-3 border-bottom">
                        @foreach($transaksi->details as $detail)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <div class="text-sm fw-semibold">{{ $detail->kategoriProduk->nama ?? 'Produk' }}</div>
                                <div class="text-xs text-muted">{{ $detail->kategoriProduk->sku ?? '-' }} · Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }} × {{ $detail->jumlah }}</div>
                            </div>
                            <span class="fw-bold text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted text-sm">Total Belanja</span>
                            <span class="fw-semibold text-sm">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</span>
                        </div>
                        <hr class="my-2" style="border-color:#e8f0ea;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total Bayar</span>
                            <span class="fw-bold fs-5" style="color:var(--primary);">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" form="editForm" class="btn btn-primary text-white w-100 fw-bold py-2 shadow-sm" style="border-radius: 10px;">
                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.belanja-koperasi.show', $transaksi->id) }}" class="btn btn-outline-secondary w-100 mt-2 text-sm py-2">
                            Batalkan Perubahan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
</script>
@endsection

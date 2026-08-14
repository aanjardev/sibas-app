@extends('layouts.mobile')

@section('title', 'Riwayat Belanja')
@section('header_title', 'Riwayat Belanja')

@section('content')
<!-- Summary Card (Hero Style) -->
<div class="mb-4 mt-3">
    <div class="primary-card p-4">
        
        <!-- Top Row: Label and Period -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="mb-0 opacity-100 fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Total Belanja</p>
            
            <span class="badge text-white fw-medium d-flex align-items-center shadow-none" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 6px; padding: 5px 12px; font-size: 0.85rem;">
                {{ $bulanIni->translatedFormat('F Y') }}
            </span>
        </div>

        <!-- Nominal (Rata Kiri) -->
        <div class="pb-4">
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h2>
        </div>

        <div style="border-top: 1px dashed rgba(255,255,255,0.3);"></div>

        <!-- Total Transaksi -->
        <div class="pt-3">
            <p class="mb-1 opacity-100 fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Frekuensi Belanja</p>
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ $frekuensiBelanja }} <span class="fw-normal" style="font-size: 1.4rem;">kali</span></h2>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Daftar Belanja</h6>

<div class="surface-card p-3">
    @forelse ($transaksiBelanja as $trx)
    <div class="history-item belanja {{ !$loop->last ? 'mb-2' : 'mb-0' }}">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">{{ $trx->keterangan ?: 'Pembelian Koperasi' }}</h6>
            <div class="text-muted text-xs text-truncate">
                @if($trx->details->isNotEmpty())
                    {{ $trx->details->map(fn($d) => $d->kategoriProduk->nama ?? 'Produk')->take(2)->implode(', ') }}{{ $trx->details->count() > 2 ? '...' : '' }}
                @else
                    TRX-B{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}
                @endif
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">- Rp {{ number_format($trx->total_belanja, 0, ',', '.') }}</h6>
            <div class="text-muted text-xs">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</div>
        </div>
    </div>
    @empty
    <div class="text-center py-4">
        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
        <p class="text-muted text-sm mt-2 mb-0">Belum ada riwayat belanja bulan ini</p>
    </div>
    @endforelse
</div>
@endsection

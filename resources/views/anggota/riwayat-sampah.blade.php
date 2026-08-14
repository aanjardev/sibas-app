@extends('layouts.mobile')

@section('title', 'Riwayat Sampah')
@section('header_title', 'Riwayat Setor Sampah')

@section('content')
<!-- Summary Card (Hero Style) -->
<div class="mb-4 mt-3">
    <div class="primary-card p-4">
        
        <!-- Top Row: Label and Period -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="mb-0 opacity-75 text-sm fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Total Cashback Sampah</p>
            
            <span class="badge text-white fw-medium d-flex align-items-center shadow-none" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 6px; padding: 5px 12px; font-size: 0.85rem;">
                {{ $bulanIni->translatedFormat('F Y') }}
            </span>
        </div>

        <!-- Nominal (Rata Kiri) -->
        <div class="pb-4">
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">Rp {{ number_format($totalCashback, 0, ',', '.') }}</h2>
        </div>

        <div style="border-top: 1px dashed rgba(255,255,255,0.3);"></div>

        <!-- Berat Total -->
        <div class="pt-3">
            <p class="mb-1 opacity-75 text-sm fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Berat Total Disetor</p>
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">{{ number_format($totalBerat, 1) }} <span class="fw-normal" style="font-size: 1.4rem;">kg</span></h2>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Daftar Transaksi</h6>

<div class="surface-card p-3">
    @forelse ($transaksiSampah as $trx)
    <div class="history-item setor-sampah {{ !$loop->last ? 'mb-2' : 'mb-0' }}">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">{{ $trx->kategoriSampah->nama ?? 'Sampah' }}</h6>
            <div class="text-muted text-xs text-truncate">
                {{ number_format($trx->berat, 1) }} {{ $trx->kategoriSampah->satuan ?? 'kg' }} • TRX-S{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">+ Rp {{ number_format($trx->total, 0, ',', '.') }}</h6>
            <div class="text-muted text-xs">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</div>
        </div>
    </div>
    @empty
    <div class="text-center py-4">
        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
        <p class="text-muted text-sm mt-2 mb-0">Belum ada riwayat setor sampah bulan ini</p>
    </div>
    @endforelse
</div>
@endsection

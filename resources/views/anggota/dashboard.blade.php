@extends('layouts.mobile')

@section('title', 'Beranda')
@section('header_title', 'Sistem Bank Sampah')

@section('content')
<div class="mb-3">
    <div class="primary-card p-4">
        
        <!-- Balance Section (Top) -->
        <div class="text-center pb-3">
            <p class="mb-1 text-sm opacity-75">Saldo Tabungan</p>
            <h2 class="fw-bold mb-2" style="font-size: 2.4rem; letter-spacing: -1px;">Rp {{ number_format($user->saldo_tabungan, 0, ',', '.') }}</h2>
            <div class="d-inline-flex align-items-center bg-white bg-opacity-25 px-3 py-1 rounded-pill">
                <i class="bi bi-wallet2 me-2 text-white opacity-75" style="font-size: 0.8rem;"></i>
                <span class="text-white text-xs">Cashback Sampah: <strong class="fw-bold">Rp {{ number_format($totalCashbackSampah, 0, ',', '.') }}</strong></span>
            </div>
        </div>

        <!-- Divider -->
        <div style="border-top: 1px dashed rgba(255,255,255,0.3);"></div>

        <!-- User Profile Section (Bottom) -->
        <div class="pt-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-0 text-white" style="font-size: 1.1rem;">{{ $user->name }}</h6>
                <small class="text-white opacity-75 text-xs"><i class="bi bi-telephone-fill me-1"></i> {{ $user->no_hp ?? '-' }}</small>
            </div>
            <div class="text-end">
                <small class="opacity-75 d-block text-xs text-uppercase tracking-wide mb-1" style="font-size: 0.65rem;">ID Anggota</small>
                <span class="fw-semibold font-monospace text-white bg-white bg-opacity-10 px-2 py-1 rounded-1" style="font-size: 0.95rem; border: 1px solid rgba(255,255,255,0.2);">{{ $user->nomor_anggota ?? '-' }}</span>
            </div>
        </div>

    </div>
</div>

<div class="d-flex justify-content-between align-items-end mb-2 px-1 mt-2">
    <h6 class="fw-bold mb-0 text-sm text-uppercase text-muted tracking-wide">Ringkasan Aktivitas</h6>
    <span class="badge bg-white text-muted border border-secondary border-opacity-25 rounded-1 px-2 py-1"><i class="bi bi-calendar3 me-1"></i> {{ $bulanIni->translatedFormat('F Y') }}</span>
</div>

<div class="row g-2 mb-3">
    <div class="col-6">
        <div class="surface-card p-3 h-100 d-flex flex-column justify-content-center" style="border: 1.3px solid var(--primary-color);">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-recycle me-2 fs-4" style="color: var(--primary-dark);"></i>
                <h5 class="fw-bold mb-0 text-main">{{ number_format($totalBeratSampah, 1) }} <small class="text-xs text-muted">kg</small></h5>
            </div>
            <p class="text-muted mb-0 text-uppercase fw-semibold" style="font-size: 0.65rem;">Sampah Disetor</p>
        </div>
    </div>
    <div class="col-6">
        <div class="surface-card p-3 h-100 d-flex flex-column justify-content-center" style="border: 1.3px solid var(--primary-color);">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-shop me-2 fs-4" style="color: var(--primary-dark);"></i>
                <h5 class="fw-bold mb-0 text-main">{{ $totalBelanjaBulanIni }} <small class="text-xs text-muted">x</small></h5>
            </div>
            <p class="text-muted mb-0 text-uppercase fw-semibold" style="font-size: 0.65rem;">Belanja Koperasi</p>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-2 text-sm text-uppercase text-muted tracking-wide px-1">Aktivitas Terakhir</h6>

<div class="surface-card p-3">
    @forelse ($aktivitasTerakhir as $aktivitas)
    <div class="history-item {{ $aktivitas->css_class }} {{ !$loop->last ? '' : '' }}">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">{{ $aktivitas->label }}</h6>
            <div class="text-muted text-xs text-truncate">
                {{ $aktivitas->keterangan ?: '-' }}
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="amount mb-1 text-sm fw-bold">{{ $aktivitas->is_income ? '+' : '-' }} Rp {{ number_format($aktivitas->nominal, 0, ',', '.') }}</h6>
            <div class="text-muted text-xs">{{ $aktivitas->created_at->translatedFormat('d M Y, H:i') }}</div>
        </div>
    </div>
    @empty
    <div class="text-center py-4">
        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
        <p class="text-muted text-sm mt-2 mb-0">Belum ada aktivitas</p>
    </div>
    @endforelse
</div>
@endsection

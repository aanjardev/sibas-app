@extends('layouts.mobile')

@section('title', 'Notifikasi')
@section('header_title', 'Notifikasi')

@section('content')
<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1 mt-2">Hari Ini</h6>

<div class="surface-card mb-4 p-0">
    <div class="d-flex p-3 border-bottom" style="border-color: var(--border-color) !important;">
        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-recycle text-success fs-5"></i>
        </div>
        <div>
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">Setoran Berhasil</h6>
                <small class="text-muted text-xs ms-2">09:41</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">Saldo Anda bertambah <span class="fw-bold text-success">+ Rp 15.000</span> dari setoran Botol Plastik (5 kg).</p>
        </div>
    </div>

    <div class="d-flex p-3">
        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-shop" style="color: #ea580c; font-size: 1.15rem;"></i>
        </div>
        <div>
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">Transaksi Koperasi</h6>
                <small class="text-muted text-xs ms-2">16:30</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">Saldo Anda terpotong <span class="fw-bold" style="color: #ea580c;">- Rp 45.000</span> untuk Pembelian Sembako.</p>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Minggu Ini</h6>

<div class="surface-card mb-4 p-0">
    <div class="d-flex p-3 border-bottom" style="border-color: var(--border-color) !important;">
        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px;">
            <i class="bi bi-megaphone-fill text-primary fs-5"></i>
        </div>
        <div>
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">Jadwal Buka Bank Sampah</h6>
                <small class="text-muted text-xs ms-2">12 Jul</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">Halo! Mengingatkan bahwa Bank Sampah pusat hari ini buka sampai jam 15:00 WIB.</p>
        </div>
    </div>

    <div class="d-flex p-3">
        <div class="bg-white rounded-circle border d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 42px; height: 42px; border-color: var(--border-color) !important;">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
        </div>
        <div>
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-main" style="font-size: 0.95rem;">Selamat Datang di SIBAS!</h6>
                <small class="text-muted text-xs ms-2">10 Jul</small>
            </div>
            <p class="text-muted text-sm mb-0" style="line-height: 1.4;">Akun Anda berhasil diaktifkan. Anda kini bisa mulai menyetor sampah dan berbelanja di koperasi.</p>
        </div>
    </div>
</div>
@endsection

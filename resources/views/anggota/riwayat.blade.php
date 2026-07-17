@extends('layouts.mobile')

@section('title', 'Riwayat Transaksi')
@section('header_title', 'Riwayat Transaksi')

@section('content')
<div class="d-flex gap-2 mb-4">
    <button class="btn btn-primary rounded-pill px-4 flex-fill fw-medium">Semua</button>
    <button class="btn btn-outline-secondary border-0 bg-white shadow-sm rounded-pill px-4 flex-fill fw-medium">Masuk</button>
    <button class="btn btn-outline-secondary border-0 bg-white shadow-sm rounded-pill px-4 flex-fill fw-medium">Keluar</button>
</div>

<div class="glass-card p-3 mb-4">
    <h6 class="text-muted text-xs fw-bold mb-3 px-2">JULI 2026</h6>
    
    <!-- Item Masuk -->
    <div class="history-item border-0 p-2 mb-3 bg-transparent">
        <div class="d-flex align-items-center">
            <div class="history-icon icon-plus me-3">
                <i class="bi bi-arrow-down-left"></i>
            </div>
            <div>
                <h6 class="mb-0 text-sm fw-bold">Setor Botol Plastik</h6>
                <small class="text-muted text-xs">16 Jul, 09:41</small>
            </div>
        </div>
        <div class="text-end">
            <h6 class="text-success mb-0 text-sm fw-bold">+ Rp 15.000</h6>
            <small class="text-muted text-xs">Saldo Tabungan</small>
        </div>
    </div>
    
    <!-- Item Keluar -->
    <div class="history-item border-0 p-2 mb-3 bg-transparent">
        <div class="d-flex align-items-center">
            <div class="history-icon icon-minus me-3">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <h6 class="mb-0 text-sm fw-bold">Belanja Koperasi</h6>
                <small class="text-muted text-xs">15 Jul, 16:30</small>
            </div>
        </div>
        <div class="text-end">
            <h6 class="text-danger mb-0 text-sm fw-bold">- Rp 45.000</h6>
            <small class="text-muted text-xs">Potong Saldo</small>
        </div>
    </div>
    
    <!-- Item Masuk -->
    <div class="history-item border-0 p-2 mb-0 bg-transparent">
        <div class="d-flex align-items-center">
            <div class="history-icon icon-plus me-3">
                <i class="bi bi-arrow-down-left"></i>
            </div>
            <div>
                <h6 class="mb-0 text-sm fw-bold">Setor Kardus Bekas</h6>
                <small class="text-muted text-xs">12 Jul, 10:15</small>
            </div>
        </div>
        <div class="text-end">
            <h6 class="text-success mb-0 text-sm fw-bold">+ Rp 30.000</h6>
            <small class="text-muted text-xs">Saldo Tabungan</small>
        </div>
    </div>
</div>

<div class="glass-card p-3 mb-4">
    <h6 class="text-muted text-xs fw-bold mb-3 px-2">JUNI 2026</h6>
    
    <!-- Item Masuk -->
    <div class="history-item border-0 p-2 mb-3 bg-transparent">
        <div class="d-flex align-items-center">
            <div class="history-icon icon-plus me-3">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div>
                <h6 class="mb-0 text-sm fw-bold">Deposit Tunai</h6>
                <small class="text-muted text-xs">28 Jun, 14:00</small>
            </div>
        </div>
        <div class="text-end">
            <h6 class="text-success mb-0 text-sm fw-bold">+ Rp 50.000</h6>
            <small class="text-muted text-xs">Saldo Tabungan</small>
        </div>
    </div>
    
    <!-- Item Keluar -->
    <div class="history-item border-0 p-2 mb-0 bg-transparent">
        <div class="d-flex align-items-center">
            <div class="history-icon icon-minus me-3">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <h6 class="mb-0 text-sm fw-bold">Belanja Koperasi</h6>
                <small class="text-muted text-xs">25 Jun, 08:30</small>
            </div>
        </div>
        <div class="text-end">
            <h6 class="text-danger mb-0 text-sm fw-bold">- Rp 12.500</h6>
            <small class="text-muted text-xs">Potong Saldo</small>
        </div>
    </div>
</div>
@endsection

@extends('layouts.mobile')

@section('title', 'Riwayat Sampah')
@section('header_title', 'Riwayat Setor Sampah')

@section('content')
<!-- Summary Card (Hero Style) -->
<div class="mb-4 mt-3">
    <div class="primary-card p-4">
        
        <!-- Top Row: Label and Dropdown -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="mb-0 opacity-75 text-sm fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Total Pendapatan</p>
            
            <div class="dropdown">
                <button class="btn btn-sm text-white fw-medium d-flex align-items-center shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 6px; padding: 5px 12px; font-size: 0.85rem;">
                    Juli 2026 <i class="bi bi-chevron-down ms-2" style="font-size: 0.7rem;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-1" style="border-radius: 12px; overflow: hidden; padding: 0; min-width: 140px;">
                    <li><a class="dropdown-item py-2 px-3 bg-light text-success fw-bold border-bottom" href="#">Juli 2026 <i class="bi bi-check-circle-fill ms-2 float-end"></i></a></li>
                    <li><a class="dropdown-item py-2 px-3 border-bottom" href="#">Juni 2026</a></li>
                    <li><a class="dropdown-item py-2 px-3" href="#">Mei 2026</a></li>
                </ul>
            </div>
        </div>

        <!-- Nominal (Rata Kiri) -->
        <div class="pb-4">
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">Rp 45.000</h2>
        </div>

        <div style="border-top: 1px dashed rgba(255,255,255,0.3);"></div>

        <!-- Berat Total -->
        <div class="pt-3">
            <p class="mb-1 opacity-75 text-sm fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Berat Total Disetor</p>
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">15 <span class="fw-normal" style="font-size: 1.4rem;">kg</span></h2>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Daftar Transaksi</h6>

<div class="surface-card p-3">
    <!-- Transaction Item 1 -->
    <div class="history-item masuk mb-2">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Botol Plastik</h6>
            <div class="text-muted text-xs text-truncate">
                5 kg • TRX-S001
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="text-success mb-1 text-sm fw-bold">+ Rp 15.000</h6>
            <div class="text-muted text-xs">16 Jul 2026, 09:41</div>
        </div>
    </div>
    
    <!-- Transaction Item 2 -->
    <div class="history-item masuk mb-0">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Kardus Bekas</h6>
            <div class="text-muted text-xs text-truncate">
                10 kg • TRX-S002
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="text-success mb-1 text-sm fw-bold">+ Rp 30.000</h6>
            <div class="text-muted text-xs">12 Jul 2026, 10:15</div>
        </div>
    </div>
</div>
@endsection

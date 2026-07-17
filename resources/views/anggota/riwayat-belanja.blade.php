@extends('layouts.mobile')

@section('title', 'Riwayat Belanja')
@section('header_title', 'Riwayat Belanja')

@section('content')
<!-- Summary Card (Hero Style) -->
<div class="mb-4 mt-3">
    <div class="primary-card p-4">
        
        <!-- Top Row: Label and Dropdown -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="mb-0 opacity-100 fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Total Belanja</p>
            
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

        <!-- Total Transaksi -->
        <div class="pt-3">
            <p class="mb-1 opacity-100 fw-medium" style="font-size: 0.95rem; color: rgba(255,255,255,0.9);">Frekuensi Belanja</p>
            <h2 class="fw-bold mb-0" style="font-size: 2.2rem;">24 <span class="fw-normal" style="font-size: 1.4rem;">kali</span></h2>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3 text-sm text-uppercase text-muted tracking-wide px-1">Daftar Belanja</h6>

<div class="surface-card p-3">
    <!-- Transaction Item 1 -->
    <div class="history-item keluar mb-2">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Pembelian Sembako</h6>
            <div class="text-muted text-xs text-truncate">
                Beras Premium 5kg, Gula Pasir 1kg...
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="mb-1 text-sm fw-bold" style="color: #ea580c;">- Rp 45.000</h6>
            <div class="text-muted text-xs">15 Jul 2026, 16:30</div>
        </div>
    </div>
    
    <!-- Transaction Item 2 -->
    <div class="history-item keluar mb-0">
        <div class="overflow-hidden flex-grow-1 pe-2">
            <h6 class="mb-1 text-sm fw-bold text-truncate">Pembelian Snack</h6>
            <div class="text-muted text-xs text-truncate">
                Biskuit Malkist (1x)...
            </div>
        </div>
        <div class="text-end flex-shrink-0">
            <h6 class="mb-1 text-sm fw-bold" style="color: #ea580c;">- Rp 12.500</h6>
            <div class="text-muted text-xs">25 Jun 2026, 11:20</div>
        </div>
    </div>
</div>
@endsection

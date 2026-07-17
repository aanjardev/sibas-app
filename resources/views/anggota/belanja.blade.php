@extends('layouts.mobile')

@section('title', 'Belanja Koperasi')
@section('header_title', 'Koperasi SIBAS')
@section('header_actions')
<button class="btn btn-sm btn-light position-relative rounded-circle p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
    <i class="bi bi-cart3"></i>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        2
        <span class="visually-hidden">items in cart</span>
    </span>
</button>
@endsection

@section('content')
<!-- Search & Filter -->
<div class="mb-4">
    <div class="input-group">
        <span class="input-group-text bg-white border-end-0 rounded-start-4 ps-3">
            <i class="bi bi-search text-muted"></i>
        </span>
        <input type="text" class="form-control form-control-custom border-start-0 rounded-end-4 ps-1" placeholder="Cari beras, gula, minyak...">
    </div>
</div>

<div class="d-flex gap-2 overflow-auto mb-4 pb-2" style="white-space: nowrap; -ms-overflow-style: none; scrollbar-width: none;">
    <button class="btn btn-primary rounded-pill px-4">Semua</button>
    <button class="btn btn-outline-secondary border-0 bg-white shadow-sm rounded-pill px-4">Sembako</button>
    <button class="btn btn-outline-secondary border-0 bg-white shadow-sm rounded-pill px-4">Minuman</button>
    <button class="btn btn-outline-secondary border-0 bg-white shadow-sm rounded-pill px-4">Snack</button>
</div>

<!-- Products Grid -->
<div class="row g-3">
    <!-- Product 1 -->
    <div class="col-6">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=300&q=80" alt="Beras" class="product-img">
            <div class="p-3">
                <h6 class="fw-bold mb-1 text-truncate">Beras Premium 5kg</h6>
                <p class="text-success fw-bold text-sm mb-2">Rp 65.000</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted text-xs">Stok: 12</small>
                    <button class="btn btn-sm btn-primary-custom py-1 px-2 rounded-circle">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Product 2 -->
    <div class="col-6">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1620706857370-e1b9770e8bb1?auto=format&fit=crop&w=300&q=80" alt="Minyak" class="product-img">
            <div class="p-3">
                <h6 class="fw-bold mb-1 text-truncate">Minyak Goreng 2L</h6>
                <p class="text-success fw-bold text-sm mb-2">Rp 32.000</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted text-xs">Stok: 5</small>
                    <button class="btn btn-sm btn-outline-custom py-1 px-2 rounded-circle" style="background: var(--primary-color); color: white;">
                        <i class="bi bi-check"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Product 3 -->
    <div class="col-6">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1581458925439-65fb531238d2?auto=format&fit=crop&w=300&q=80" alt="Gula" class="product-img">
            <div class="p-3">
                <h6 class="fw-bold mb-1 text-truncate">Gula Pasir 1kg</h6>
                <p class="text-success fw-bold text-sm mb-2">Rp 16.500</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted text-xs">Stok: 20</small>
                    <button class="btn btn-sm btn-primary-custom py-1 px-2 rounded-circle">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product 4 -->
    <div class="col-6">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&w=300&q=80" alt="Kopi" class="product-img">
            <div class="p-3">
                <h6 class="fw-bold mb-1 text-truncate">Kopi Bubuk 165g</h6>
                <p class="text-success fw-bold text-sm mb-2">Rp 14.000</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted text-xs">Stok: 8</small>
                    <button class="btn btn-sm btn-primary-custom py-1 px-2 rounded-circle">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart Offcanvas -->
<div class="offcanvas offcanvas-bottom offcanvas-bottom" tabindex="-1" id="cartOffcanvas" style="height: 75vh;">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title fw-bold">Keranjang Belanja</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column pb-0">
    <!-- Cart Items -->
    <div class="flex-grow-1 overflow-auto">
        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
            <img src="https://images.unsplash.com/photo-1620706857370-e1b9770e8bb1?auto=format&fit=crop&w=100&q=80" alt="Item" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
            <div class="ms-3 flex-grow-1">
                <h6 class="fw-bold mb-1 text-sm">Minyak Goreng 2L</h6>
                <p class="text-success fw-bold text-xs mb-0">Rp 32.000</p>
            </div>
            <div class="d-flex align-items-center bg-light rounded-pill p-1">
                <button class="btn btn-sm btn-link text-dark px-2 py-0"><i class="bi bi-dash"></i></button>
                <span class="fw-bold mx-2">1</span>
                <button class="btn btn-sm btn-link text-dark px-2 py-0"><i class="bi bi-plus"></i></button>
            </div>
        </div>
        
        <div class="d-flex align-items-center mb-3">
            <img src="https://images.unsplash.com/photo-1581458925439-65fb531238d2?auto=format&fit=crop&w=100&q=80" alt="Item" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
            <div class="ms-3 flex-grow-1">
                <h6 class="fw-bold mb-1 text-sm">Gula Pasir 1kg</h6>
                <p class="text-success fw-bold text-xs mb-0">Rp 16.500</p>
            </div>
            <div class="d-flex align-items-center bg-light rounded-pill p-1">
                <button class="btn btn-sm btn-link text-dark px-2 py-0"><i class="bi bi-dash"></i></button>
                <span class="fw-bold mx-2">1</span>
                <button class="btn btn-sm btn-link text-dark px-2 py-0"><i class="bi bi-plus"></i></button>
            </div>
        </div>
    </div>
    
    <!-- Checkout Area -->
    <div class="pt-3 border-top bg-white pb-4" style="margin-bottom: env(safe-area-inset-bottom);">
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Total Belanja</span>
            <span class="fw-bold">Rp 48.500</span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span class="text-muted">Saldo Tersedia</span>
            <span class="text-success fw-bold">Rp 1.250.000</span>
        </div>
        
        <div class="mb-3">
            <label class="form-label text-xs fw-bold text-muted">METODE PEMBAYARAN</label>
            <select class="form-select-custom w-100">
                <option value="saldo" selected>Potong Saldo (Tabungan)</option>
                <option value="tunai">Bayar Tunai di Kasir</option>
            </select>
        </div>
        
        <button class="btn btn-primary-custom w-100 py-3 d-flex justify-content-between align-items-center">
            <span>Bayar Sekarang</span>
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
  </div>
</div>
@endsection

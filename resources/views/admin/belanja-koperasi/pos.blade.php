<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS — SIBAS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin-app.css') }}">
    <style>
        :root {
            --primary: #084627;
            --primary-light: #e6f0eb;
            --primary-dark: #052e1a;
        }

        html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; }

        /* ── POS Layout ── */
        .pos-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #f1f5f2;
        }

        /* ── Top Bar ── */
        .pos-topbar {
            height: 58px;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .pos-topbar .brand { font-weight: 700; font-size: 1.05rem; letter-spacing: -0.3px; }
        .pos-topbar .trx-num { font-size: 0.8rem; background: rgba(255,255,255,0.15); padding: 3px 10px; border-radius: 20px; }

        /* ── Main Body ── */
        .pos-body {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* ── Left: Product Catalog ── */
        .pos-catalog {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 1rem;
            gap: 0.75rem;
        }

        .pos-search-bar { display: flex; gap: 0.5rem; }
        .pos-search-bar input { border-radius: 8px; border: 1px solid #dde3e0; background: #fff; font-size: 0.875rem; padding: 0.5rem 0.85rem; flex: 1; outline: none; }
        .pos-search-bar input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(8,70,39,0.08); }
        .pos-search-bar select { border-radius: 8px; border: 1px solid #dde3e0; background: #fff; font-size: 0.8rem; padding: 0.5rem 0.75rem; max-width: 150px; outline: none; }

        /* Category Pills */
        .cat-pills { display: flex; gap: 0.4rem; flex-wrap: nowrap; overflow-x: auto; padding-bottom: 2px; }
        .cat-pills::-webkit-scrollbar { height: 3px; }
        .cat-pills::-webkit-scrollbar-track { background: transparent; }
        .cat-pills::-webkit-scrollbar-thumb { background: #ccc; border-radius: 2px; }
        .cat-pill {
            flex-shrink: 0;
            padding: 4px 14px;
            border-radius: 20px;
            border: 1px solid #dde3e0;
            background: #fff;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            color: #555;
            white-space: nowrap;
        }
        .cat-pill.active, .cat-pill:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
            gap: 0.65rem;
            overflow-y: auto;
            padding-bottom: 0.5rem;
        }
        .product-grid::-webkit-scrollbar { width: 5px; }
        .product-grid::-webkit-scrollbar-track { background: transparent; }
        .product-grid::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }

        .product-card {
            background: #fff;
            border-radius: 12px;
            border: 1.5px solid #e4ece6;
            padding: 0;
            cursor: pointer;
            transition: all 0.18s ease;
            user-select: none;
            position: relative;
            overflow: hidden;
        }
        .product-card:hover { border-color: var(--primary); }
        .product-card.in-cart { border-color: var(--primary); background: #f0f7f3; }
        .product-card.out-of-stock { opacity: 0.55; cursor: not-allowed; }
        .product-card.out-of-stock:hover { outline: none; border-color: #e4ece6; }

        /* Product image — full width, fixed height */
        .product-img-wrap {
            width: 100%;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            background: var(--primary-light);
            border-radius: 10px 10px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }
        .product-img-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: var(--primary);
            opacity: 0.5;
            font-size: 2.2rem;
        }

        .product-card-body { padding: 0.6rem 0.7rem 0.65rem; }
        .product-name { font-size: 0.82rem; font-weight: 600; color: #1a2a1e; line-height: 1.3; margin-bottom: 0.2rem; }
        .product-sku { font-size: 0.7rem; color: #888; margin-bottom: 0.35rem; }
        .product-price { font-size: 0.88rem; font-weight: 700; color: var(--primary); }
        .product-stock { font-size: 0.68rem; font-weight: 600; }
        .product-stock.ok { color: #16a34a; }
        .product-stock.low { color: #d97706; }
        .product-stock.empty { color: #dc2626; }

        .in-cart-badge {
            position: absolute; top: 8px; right: 8px;
            background: var(--primary); color: #fff;
            border-radius: 12px; padding: 1px 8px; font-size: 0.7rem; font-weight: 700;
        }

        /* ── Right: Cart Panel ── */
        .pos-cart {
            width: 320px;
            flex-shrink: 0;
            background: #fff;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #e0ebe3;
            box-shadow: -4px 0 20px rgba(0,0,0,0.05);
        }

        .cart-header {
            padding: 0.9rem 1.1rem 0.75rem;
            border-bottom: 1px solid #e8f0ea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }
        .cart-header h6 { font-weight: 700; font-size: 0.95rem; color: #1a2a1e; margin: 0; }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 0.75rem;
        }
        .cart-items::-webkit-scrollbar { width: 4px; }
        .cart-items::-webkit-scrollbar-thumb { background: #ccc; border-radius: 2px; }

        .cart-empty {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 0.85rem;
        }
        .cart-empty i { font-size: 2.5rem; margin-bottom: 0.5rem; opacity: 0.4; }

        .cart-item {
            background: #f8faf9;
            border: 1px solid #e4ece6;
            border-radius: 10px;
            padding: 0.6rem 0.75rem;
            margin-bottom: 0.5rem;
        }
        .cart-item-name { font-size: 0.82rem; font-weight: 600; color: #1a2a1e; line-height: 1.25; }
        .cart-item-price { font-size: 0.78rem; color: #666; }
        .cart-item-subtotal { font-size: 0.88rem; font-weight: 700; color: var(--primary); }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .qty-btn {
            width: 26px; height: 26px;
            border-radius: 6px;
            border: 1px solid #cdd8d0;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            transition: all 0.15s;
        }
        .qty-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
        .qty-display {
            width: 32px;
            text-align: center;
            font-weight: 700;
            font-size: 0.88rem;
            border: 1px solid #cdd8d0;
            border-radius: 6px;
            padding: 1px 2px;
            background: #fff;
        }
        .qty-display::-webkit-inner-spin-button,
        .qty-display::-webkit-outer-spin-button { -webkit-appearance: none; }

        /* Modern Payment Method Selector */
        .payment-method-card {
            border: 1.5px solid #e4ece6;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
        }
        .payment-method-card:hover {
            border-color: var(--primary);
            background: #f0f7f3;
        }
        .payment-method-input:checked + .payment-method-card {
            border-color: var(--primary);
            background: #f0f7f3;
            box-shadow: 0 0 0 1px var(--primary);
        }
        .payment-method-input:disabled + .payment-method-card {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f8f9fa;
        }
        .payment-method-input:disabled + .payment-method-card:hover {
            border-color: #e4ece6;
            background: #f8f9fa;
        }
        .payment-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .icon-saldo { background: #e0f2e9; color: var(--primary); }
        .icon-tunai { background: #fff3e0; color: #f57c00; }
        .icon-campuran { background: #e3f2fd; color: #1976d2; }

        /* Cart Footer */
        .cart-footer {
            padding: 0.9rem 1.1rem;
            border-top: 1px solid #e8f0ea;
            flex-shrink: 0;
        }
        .cart-summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.3rem; font-size: 0.83rem; }
        .cart-total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem; }
        .cart-total-row span:first-child { font-size: 0.95rem; font-weight: 700; color: #1a2a1e; }
        .cart-total-row span:last-child { font-size: 1.2rem; font-weight: 800; color: var(--primary); }

        .btn-checkout {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-checkout:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(8,70,39,0.3); }
        .btn-checkout:disabled { background: #9cb5a5; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-clear-cart {
            width: 100%;
            background: transparent;
            color: #dc3545;
            border: 1px solid #dc3545;
            border-radius: 10px;
            padding: 0.45rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            margin-top: 0.4rem;
        }
        .btn-clear-cart:hover { background: #dc3545; color: #fff; }

        /* ═══════════════════════════════════════════════
           Floating Cart Components (hidden on desktop)
           ═══════════════════════════════════════════════ */
        .floating-cart-bar { display: none; }
        .cart-overlay { display: none; }
        .cart-mobile-handle { display: none; }

        /* ═══════════════════════════════════════════════
           RESPONSIVE: Tablet & Mobile (< 1024px)
           Cart menjadi floating panel, expand/collapse
           ═══════════════════════════════════════════════ */
        @media (max-width: 1023px) {
            html, body { overflow: auto; }
            .pos-wrapper { height: auto; min-height: 100vh; }

            .pos-body {
                flex-direction: column;
                overflow: visible;
            }

            .pos-catalog {
                overflow: visible;
                flex: none;
                padding-bottom: 80px; /* space for floating bar */
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 0.5rem;
                overflow: visible;
                max-height: none;
            }

            /* ── Cart → Floating Bottom Panel ── */
            .pos-cart {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                z-index: 1060;
                border-left: none;
                border-top: none;
                border-radius: 20px 20px 0 0;
                box-shadow: 0 -8px 30px rgba(0,0,0,0.18);
                transform: translateY(100%);
                transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1);
                max-height: 80vh;
                overflow: hidden;
            }
            .pos-cart.expanded {
                transform: translateY(0);
            }

            /* ── Mobile Drag Handle ── */
            .cart-mobile-handle {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 12px 1rem 6px;
                cursor: pointer;
                flex-shrink: 0;
            }
            .handle-pill {
                width: 42px;
                height: 5px;
                border-radius: 5px;
                background: #d0d5d2;
                transition: background 0.2s;
            }
            .cart-mobile-handle:hover .handle-pill,
            .cart-mobile-handle:active .handle-pill { background: #aaa; }

            /* ── Floating Cart Bar ── */
            .floating-cart-bar {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1050;
                background: var(--primary);
                color: #fff;
                padding: 0.7rem 1rem;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 -4px 24px rgba(0,0,0,0.2);
                cursor: pointer;
                transition: all 0.35s cubic-bezier(0.32, 0.72, 0, 1);
                gap: 0.75rem;
                border-radius: 16px 16px 0 0;
            }
            .floating-cart-bar:active { background: var(--primary-dark); }
            .floating-cart-bar.cart-empty-bar {
                background: #6b7c72;
            }

            .floating-cart-icon {
                position: relative;
                font-size: 1.35rem;
                line-height: 1;
                flex-shrink: 0;
            }
            .floating-cart-badge {
                position: absolute;
                top: -7px; right: -10px;
                background: #f43f5e;
                color: #fff;
                font-size: 0.6rem;
                font-weight: 700;
                border-radius: 10px;
                padding: 1px 5px;
                min-width: 16px;
                text-align: center;
                line-height: 1.4;
                box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            }
            .floating-cart-info {
                flex: 1;
                min-width: 0;
            }
            .floating-cart-label {
                font-size: 0.72rem;
                opacity: 0.75;
                line-height: 1;
                margin-bottom: 2px;
            }
            .floating-cart-total {
                font-size: 1.05rem;
                font-weight: 700;
                line-height: 1.3;
            }
            .floating-cart-action {
                display: flex;
                align-items: center;
                gap: 0.35rem;
                background: rgba(255,255,255,0.18);
                padding: 0.5rem 0.9rem;
                border-radius: 10px;
                font-size: 0.82rem;
                font-weight: 600;
                white-space: nowrap;
                transition: background 0.15s;
                flex-shrink: 0;
            }
            .floating-cart-bar:hover .floating-cart-action { background: rgba(255,255,255,0.28); }

            /* ── Cart Overlay ── */
            .cart-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.45);
                z-index: 1055;
                backdrop-filter: blur(2px);
                -webkit-backdrop-filter: blur(2px);
                animation: overlayFadeIn 0.3s ease;
            }
            @keyframes overlayFadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            /* Badge pulse animation */
            @keyframes badgePulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.35); }
                100% { transform: scale(1); }
            }
            .floating-cart-badge.pulse {
                animation: badgePulse 0.35s ease;
            }
        }

        /* ═══════════════════════════════════════════════
           RESPONSIVE: Mobile (< 768px)
           Font & spacing lebih kecil
           ═══════════════════════════════════════════════ */
        @media (max-width: 767px) {
            .pos-topbar {
                height: 50px;
                padding: 0 0.75rem;
                min-width: 0;
            }
            .pos-topbar .brand {
                font-size: 0.92rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .pos-topbar .trx-num {
                font-size: 0.7rem;
                padding: 2px 8px;
                white-space: nowrap;
            }

            .pos-catalog { padding: 0.6rem; gap: 0.5rem; }
            .pos-search-bar { flex-wrap: wrap; gap: 0.4rem; position: relative; }
            .pos-search-bar input { min-width: 0; }
            .pos-search-bar select { max-width: none; flex: 1; font-size: 0.78rem; }

            .cat-pills { flex-shrink: 0; padding-bottom: 4px; }
            .cat-pill { padding: 4px 11px; font-size: 0.74rem; }

            .product-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.4rem;
            }

            .product-img-wrap { aspect-ratio: 3 / 2; }
            .product-img-placeholder { font-size: 1.6rem; }
            .product-card-body { padding: 0.45rem 0.55rem 0.5rem; }
            .product-name { font-size: 0.76rem; margin-bottom: 0.15rem; }
            .product-sku { font-size: 0.65rem; margin-bottom: 0.25rem; }
            .product-price { font-size: 0.8rem; }
            .product-stock { font-size: 0.63rem; }
            .in-cart-badge { top: 6px; right: 6px; font-size: 0.65rem; padding: 1px 6px; }

            /* Cart floating panel tweaks */
            .pos-cart { max-height: 75vh; }
            .cart-header { padding: 0.65rem 0.85rem; }
            .cart-header h6 { font-size: 0.88rem; }
            .cart-item { padding: 0.5rem 0.6rem; margin-bottom: 0.35rem; }
            .cart-item-name { font-size: 0.78rem; }
            .cart-item-subtotal { font-size: 0.82rem; }
            .cart-footer { padding: 0.65rem 0.85rem; }
            .cart-summary-row { font-size: 0.78rem; }
            .cart-total-row span:last-child { font-size: 1.05rem; }
            .btn-checkout { padding: 0.65rem; font-size: 0.92rem; border-radius: 8px; }
            .btn-clear-cart { padding: 0.35rem; font-size: 0.75rem; }
        }

        /* ═══════════════════════════════════════════════
           RESPONSIVE: Small mobile (< 400px)
           ═══════════════════════════════════════════════ */
        @media (max-width: 400px) {
            .pos-topbar { height: 46px; }
            .pos-topbar .brand { font-size: 0.85rem; }
            .pos-catalog { padding: 0.45rem; gap: 0.4rem; }
            .product-grid { gap: 0.35rem; }
            .product-img-wrap { aspect-ratio: 1 / 1; }
            .product-card-body { padding: 0.35rem 0.45rem 0.4rem; }
            .product-name { font-size: 0.72rem; }
            .product-sku { font-size: 0.6rem; }
            .product-price { font-size: 0.75rem; }

            .floating-cart-bar { padding: 0.55rem 0.75rem; }
            .floating-cart-total { font-size: 0.95rem; }
            .floating-cart-action { padding: 0.4rem 0.7rem; font-size: 0.78rem; }
        }
    </style>
</head>
<body>
<div class="pos-wrapper">

    {{-- ── Top Bar ── --}}
    <div class="pos-topbar">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.belanja-koperasi.index') }}" class="text-white text-decoration-none d-flex align-items-center gap-1" style="opacity:0.85; font-size:0.85rem;">
                <i class="bi bi-arrow-left"></i> Riwayat
            </a>
            <div class="brand"><i class="bi bi-cart3 me-1"></i>Kasir Koperasi</div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span style="font-size:0.82rem; opacity:0.75;" id="pos-time">--:--</span>
        </div>
    </div>

    {{-- ── Main Body ── --}}
    <div class="pos-body">

        {{-- ── Left: Product Catalog ── --}}
        <div class="pos-catalog">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Search Bar --}}
            <div class="pos-search-bar">
                <i class="bi bi-search" style="position:absolute; margin:9px 11px; color:#aaa; font-size:0.9rem; pointer-events:none;"></i>
                <input type="text" id="productSearch" placeholder="Cari produk, SKU..." style="padding-left: 2.1rem;"
                    oninput="filterProducts(this.value)">
                <select id="catFilter" onchange="filterProducts(document.getElementById('productSearch').value)">
                    <option value="">Semua Kategori</option>
                    @foreach($produkList->pluck('kategoriProduk.nama')->unique()->filter() as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Category Pills --}}
            <div class="cat-pills">
                <div class="cat-pill active" onclick="setCat(this, '')">Semua</div>
                @foreach($produkList->pluck('kategoriProduk.nama')->unique()->filter() as $kat)
                    <div class="cat-pill" onclick="setCat(this, '{{ addslashes($kat) }}')">{{ $kat }}</div>
                @endforeach
            </div>

            {{-- Product Grid --}}
            <div class="product-grid" id="productGrid">
                {{-- Products rendered by JS --}}
            </div>
        </div>

        {{-- ── Right: Cart Panel ── --}}
        <div class="pos-cart">
            {{-- Mobile drag handle for swipe-to-close --}}
            <div class="cart-mobile-handle" onclick="toggleCart()">
                <div class="handle-pill"></div>
            </div>
            <div class="cart-header">
                <h6><i class="bi bi-bag-check me-1 text-success"></i>Keranjang</h6>
                <span class="badge bg-primary rounded-pill" id="cartCount">0 item</span>
            </div>

            <div class="cart-items" id="cartItems">
                <div class="cart-empty" id="cartEmpty">
                    <i class="bi bi-cart"></i>
                    <span>Keranjang kosong</span>
                    <small style="font-size:0.75rem; margin-top:0.25rem; color:#bbb;">Klik produk untuk menambahkan</small>
                </div>
            </div>

            <div class="cart-footer">
                <div class="cart-summary-row">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold" id="subtotalDisplay">Rp 0</span>
                </div>
                <div class="cart-summary-row">
                    <span class="text-muted">Item</span>
                    <span class="fw-semibold" id="itemCountDisplay">0 item</span>
                </div>
                <hr class="my-2" style="border-color: #e8f0ea;">
                <div class="cart-total-row">
                    <span>Total</span>
                    <span id="totalDisplay">Rp 0</span>
                </div>
                <button type="button" id="checkoutBtn" class="btn-checkout text-decoration-none" style="pointer-events:none; opacity:0.55;" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                    <i class="bi bi-bag-check-fill"></i> Lanjut Checkout
                </button>
                <button class="btn-clear-cart" onclick="clearCart()" id="clearCartBtn" style="display:none;">
                    <i class="bi bi-x-circle me-1"></i>Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>

    {{-- ── Floating Cart Bar (Mobile/Tablet) ── --}}
    <div class="floating-cart-bar" id="floatingCartBar" onclick="toggleCart()">
        <div class="d-flex align-items-center gap-2">
            <div class="floating-cart-icon">
                <i class="bi bi-bag-check-fill"></i>
                <span class="floating-cart-badge" id="floatingCartBadge">0</span>
            </div>
            <div class="floating-cart-info" style="margin-left: 10px;">
                <div class="floating-cart-label">Keranjang</div>
                <div class="floating-cart-total" id="floatingCartTotal">Rp 0</div>
            </div>
        </div>
        <div class="floating-cart-action">
            <span>Lihat</span>
            <i class="bi bi-chevron-up"></i>
        </div>
    </div>

    {{-- Cart Overlay --}}
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
</div>

<!-- Modal Checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin: 1rem auto; width: calc(100% - 2rem);">
        <div class="modal-content shadow border-0" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 pt-4 pb-2">
                <h5 class="fw-bold mb-0 text-dark fs-5"><i class="bi bi-bag-check-fill text-success me-1"></i> Proses Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.belanja-koperasi.checkout') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div id="hiddenCartInputs"></div>

                    <div class="row g-4">
                        <!-- Kolom Kiri: Detail Utama -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-sm d-block mb-2">Tipe Pelanggan</label>
                                <div class="btn-group w-100" role="group" aria-label="Tipe Pelanggan">
                                    <input type="radio" class="btn-check" name="tipe_pelanggan" id="tipe_anggota" value="anggota" autocomplete="off" checked onchange="toggleTipePelanggan()">
                                    <label class="btn btn-outline-success" for="tipe_anggota">Anggota Koperasi</label>
                                  
                                    <input type="radio" class="btn-check" name="tipe_pelanggan" id="tipe_umum" value="umum" autocomplete="off" onchange="toggleTipePelanggan()">
                                    <label class="btn btn-outline-success" for="tipe_umum">Pelanggan Umum</label>
                                </div>
                            </div>

                            <div class="mb-4" id="member_search_container">
                                <label class="form-label fw-semibold text-sm">Pencarian Anggota <span class="text-danger">*</span></label>
                                <div class="input-group position-relative">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control bg-white border-start-0 text-sm" id="searchAnggota" placeholder="Ketik nama / ID anggota..." autocomplete="off">
                                    <div id="search-results" class="list-group position-absolute w-100 shadow d-none" style="top: 100%; left: 0; max-height: 200px; overflow-y: auto; z-index: 1050;"></div>
                                </div>
                                <input type="hidden" name="user_id" id="user_id">

                                <!-- Selected Member Card Display -->
                                <div class="mt-2 p-2 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 d-flex justify-content-between align-items-center d-none" id="selected-member-card">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 36px; height: 36px;">
                                            <span class="fw-bold" id="selected-member-initial"></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-success text-sm" id="selected-member-name"></h6>
                                            <span class="text-muted text-xs">Saldo: <b class="text-dark" id="saldo_awal_text">Rp 0</b></span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light text-danger border" onclick="clearMemberSelection()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-sm mb-3">Metode Pembayaran <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2">
                                    <label class="position-relative m-0">
                                        <input type="radio" name="metode_bayar" value="saldo" class="payment-method-input position-absolute opacity-0" onchange="toggleBayarTunai()" required>
                                        <div class="payment-method-card">
                                            <div class="payment-icon icon-saldo">
                                                <i class="bi bi-wallet2"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-dark text-sm mb-1" style="line-height: 1.2;">Potong Saldo Penuh</div>
                                                <div class="text-muted text-xs" id="saldo-text-info" style="line-height: 1.2;">Bayar menggunakan saldo utama</div>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <label class="position-relative m-0">
                                        <input type="radio" name="metode_bayar" value="tunai" class="payment-method-input position-absolute opacity-0" onchange="toggleBayarTunai()">
                                        <div class="payment-method-card">
                                            <div class="payment-icon icon-tunai">
                                                <i class="bi bi-cash-stack"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-dark text-sm mb-1" style="line-height: 1.2;">Tunai Penuh</div>
                                                <div class="text-muted text-xs" style="line-height: 1.2;">Bayar secara tunai (cash)</div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="position-relative m-0">
                                        <input type="radio" name="metode_bayar" value="campuran" class="payment-method-input position-absolute opacity-0" onchange="toggleBayarTunai()">
                                        <div class="payment-method-card">
                                            <div class="payment-icon icon-campuran">
                                                <i class="bi bi-pie-chart"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-dark text-sm mb-1" style="line-height: 1.2;">Campuran (Saldo + Tunai)</div>
                                                <div class="text-muted text-xs" style="line-height: 1.2;">Sebagian saldo, sebagian tunai</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4 d-none" id="bayar_tunai_container">
                                <label class="form-label fw-semibold text-sm">Nominal Bayar Tunai (Campuran) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                    <input type="number" step="100" min="0" class="form-control text-sm fw-bold text-primary" name="bayar_tunai" id="bayar_tunai" placeholder="0">
                                </div>
                                <small class="text-muted text-xs">Sisanya akan otomatis dipotong dari saldo tabungan.</small>
                            </div>

                            <div class="mb-0 d-none" id="uang_diterima_container">
                                <label class="form-label fw-semibold text-sm">Uang Tunai Diterima (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                    <input type="number" step="100" min="0" class="form-control text-sm fw-bold text-success" name="uang_diterima" id="uang_diterima" placeholder="0">
                                    <button type="button" class="btn btn-outline-success fw-bold text-sm" onclick="setUangPas()"><i class="bi bi-cash me-1"></i>Uang Pas</button>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Summary & Opsional -->
                        <div class="col-md-6 d-flex flex-column">
                            <div class="p-3 bg-light rounded-3 mb-4 border flex-grow-0">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted text-sm">Subtotal</span>
                                    <span class="fw-semibold text-dark text-sm" id="checkout_subtotal">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted text-sm">Diskon</span>
                                    <span class="fw-semibold text-danger text-sm" id="checkout_diskon_display">- Rp 0</span>
                                </div>
                                <hr class="my-2 border-secondary opacity-25">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark text-base">Grand Total</span>
                                    <span class="fw-bold text-primary text-base" id="checkout_total">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 d-none" id="checkout_kembalian_container">
                                    <span class="fw-bold text-dark text-base">Kembalian</span>
                                    <span class="fw-bold text-success text-base" id="checkout_kembalian">Rp 0</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 border-dashed" onclick="toggleOpsional(this)" id="btnToggleOpsional">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Diskon / Catatan
                                </button>
                                
                                <div id="opsional_container" class="d-none mt-3 p-3 border rounded-3 bg-white">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-sm">Diskon (Opsional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted text-sm">Rp</span>
                                            <input type="number" step="100" min="0" class="form-control text-sm text-dark" name="diskon" id="diskon" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-semibold text-sm">Catatan (Opsional)</label>
                                        <textarea class="form-control text-sm" name="keterangan_checkout" id="keterangan_checkout" rows="2" placeholder="Catatan transaksi..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-light w-100 fw-bold py-2 text-muted border text-sm" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 text-sm text-white shadow-sm" style="border-radius: 8px;" id="submitCheckoutBtn" disabled>Proses Pembayaran</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const products = [
    @foreach($produkList as $p)
    { 
        id: {{ $p->id }}, 
        sku: '{{ $p->sku }}', 
        name: '{!! addslashes($p->nama) !!}', 
        category: '{!! addslashes($p->kategoriProduk->nama ?? 'Umum') !!}', 
        price: {{ $p->harga_jual }}, 
        stock: {{ $p->stok }}, 
        image: {!! $p->foto ? "'" . asset('storage/' . $p->foto) . "'" : 'null' !!} 
    },
    @endforeach
];

const categoryIcon = {
    'Sembako':      'bi-basket2',
    'Minuman':      'bi-cup-straw',
    'Makanan':      'bi-egg-fried',
    'Rumah Tangga': 'bi-house-heart',
};

let cart = {}; // { productId: { product, qty } }
let currentCat = '';
let memberSaldo = 0;

// Checkout Elements
function formatRupiah(number) {
    if (isNaN(number)) return 'Rp 0';
    return 'Rp ' + Math.floor(number).toLocaleString('id-ID');
}

const searchInput = document.getElementById('searchAnggota');
const searchResults = document.getElementById('search-results');
const userIdInput = document.getElementById('user_id');
const submitBtn = document.getElementById('submitCheckoutBtn');
let debounceTimer;

function productImageHTML(p) {
    if (p.image) {
        return `<img src="${p.image}" alt="${p.name}"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="product-img-placeholder" style="display:none;position:absolute;inset:0;">
                    <i class="bi ${categoryIcon[p.category] || 'bi-box-seam'}"></i>
                </div>`;
    }
    return `<div class="product-img-placeholder">
                <i class="bi ${categoryIcon[p.category] || 'bi-box-seam'}"></i>
            </div>`;
}

function renderProducts(list) {
    const grid = document.getElementById('productGrid');
    grid.innerHTML = '';
    if (list.length === 0) {
        grid.innerHTML = `<div style="grid-column:1/-1; text-align:center; padding:2rem; color:#aaa; font-size:0.85rem;"><i class="bi bi-search" style="font-size:1.5rem; display:block; margin-bottom:0.5rem; opacity:0.4;"></i>Produk tidak ditemukan</div>`;
        return;
    }
    list.forEach(p => {
        const inCart = cart[p.id] ? cart[p.id].qty : 0;
        const stockClass = p.stock === 0 ? 'empty' : p.stock <= 5 ? 'low' : 'ok';
        const stockLabel = p.stock === 0 ? 'Stok Habis' : p.stock <= 5 ? `Menipis (${p.stock})` : `Stok: ${p.stock}`;
        const card = document.createElement('div');
        card.className = `product-card ${p.stock === 0 ? 'out-of-stock' : ''} ${inCart > 0 ? 'in-cart' : ''}`;
        card.dataset.id = p.id;
        card.onclick = () => p.stock > 0 && addToCart(p);
        card.innerHTML = `
            ${inCart > 0 ? `<div class="in-cart-badge">${inCart}</div>` : ''}
            <div class="product-img-wrap">${productImageHTML(p)}</div>
            <div class="product-card-body">
                <div class="product-name">${p.name}</div>
                <div class="product-sku">${p.sku} · ${p.category}</div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="product-price">Rp ${p.price.toLocaleString('id-ID')}</div>
                    <div class="product-stock ${stockClass}">${stockLabel}</div>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
}

function filterProducts(query) {
    const cat = document.getElementById('catFilter').value || currentCat;
    let filtered = products.filter(p => {
        const matchQ = query === '' || p.name.toLowerCase().includes(query.toLowerCase()) || p.sku.toLowerCase().includes(query.toLowerCase());
        const matchCat = cat === '' || p.category === cat;
        return matchQ && matchCat;
    });
    renderProducts(filtered);
}

function setCat(el, cat) {
    currentCat = cat;
    document.getElementById('catFilter').value = cat;
    document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    filterProducts(document.getElementById('productSearch').value);
}

function addToCart(product) {
    if (cart[product.id]) {
        if (cart[product.id].qty >= product.stock) return;
        cart[product.id].qty++;
    } else {
        cart[product.id] = { product, qty: 1 };
    }
    renderCart();
    filterProducts(document.getElementById('productSearch').value);
}

function removeFromCart(productId) {
    delete cart[productId];
    renderCart();
    filterProducts(document.getElementById('productSearch').value);
}

function changeQty(productId, delta) {
    if (!cart[productId]) return;
    const newQty = cart[productId].qty + delta;
    if (newQty <= 0) { removeFromCart(productId); return; }
    if (newQty > cart[productId].product.stock) return;
    cart[productId].qty = newQty;
    renderCart();
    filterProducts(document.getElementById('productSearch').value);
}

function setQty(productId, val) {
    if (!cart[productId]) return;
    const qty = parseInt(val) || 1;
    const capped = Math.max(1, Math.min(qty, cart[productId].product.stock));
    cart[productId].qty = capped;
    renderCart();
    filterProducts(document.getElementById('productSearch').value);
}

function clearCart() {
    cart = {};
    renderCart();
    filterProducts(document.getElementById('productSearch').value);
}

function renderCart() {
    const container = document.getElementById('cartItems');
    const emptyEl = document.getElementById('cartEmpty');
    const entries = Object.values(cart);

    const totalItems = entries.reduce((s, e) => s + e.qty, 0);
    const subtotal = entries.reduce((s, e) => s + e.product.price * e.qty, 0);

    document.getElementById('cartCount').innerText = `${totalItems} item`;
    document.getElementById('itemCountDisplay').innerText = `${totalItems} item`;
    document.getElementById('subtotalDisplay').innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
    document.getElementById('totalDisplay').innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
    document.getElementById('checkout_total').innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;

    // Update hidden inputs for form submission
    const hiddenInputsContainer = document.getElementById('hiddenCartInputs');
    hiddenInputsContainer.innerHTML = '';
    entries.forEach((e, idx) => {
        hiddenInputsContainer.innerHTML += `
            <input type="hidden" name="items[${idx}][produk_id]" value="${e.product.id}">
            <input type="hidden" name="items[${idx}][jumlah]" value="${e.qty}">
        `;
    });

    const floatingBadge = document.getElementById('floatingCartBadge');
    const floatingTotal = document.getElementById('floatingCartTotal');
    const floatingBar = document.getElementById('floatingCartBar');
    if (floatingBadge) {
        const oldCount = floatingBadge.innerText;
        floatingBadge.innerText = totalItems;
        if (oldCount !== String(totalItems)) {
            floatingBadge.classList.remove('pulse');
            void floatingBadge.offsetWidth;
            floatingBadge.classList.add('pulse');
        }
    }
    if (floatingTotal) floatingTotal.innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
    if (floatingBar) floatingBar.classList.toggle('cart-empty-bar', entries.length === 0);

    const checkoutBtn = document.getElementById('checkoutBtn');
    const clearBtn = document.getElementById('clearCartBtn');

    if (entries.length === 0) {
        container.innerHTML = `<div class="cart-empty" id="cartEmpty"><i class="bi bi-cart"></i><span>Keranjang kosong</span><small style="font-size:0.75rem;margin-top:0.25rem;color:#bbb;">Klik produk untuk menambahkan</small></div>`;
        checkoutBtn.style.pointerEvents = 'none';
        checkoutBtn.style.opacity = '0.55';
        clearBtn.style.display = 'none';
        checkCheckoutValidity();
        return;
    }

    checkoutBtn.style.pointerEvents = '';
    checkoutBtn.style.opacity = '';
    clearBtn.style.display = '';
    checkCheckoutValidity();

    container.innerHTML = entries.map(({ product: p, qty }) => `
        <div class="cart-item">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <div class="cart-item-name">${p.name}</div>
                <button onclick="removeFromCart(${p.id})" style="background:none;border:none;color:#dc3545;cursor:pointer;padding:0;font-size:0.9rem;line-height:1;"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="qty-control">
                    <button class="qty-btn" onclick="changeQty(${p.id}, -1)">−</button>
                    <input class="qty-display" type="number" value="${qty}" min="1" max="${p.stock}" onchange="setQty(${p.id}, this.value)">
                    <button class="qty-btn" onclick="changeQty(${p.id}, +1)">+</button>
                </div>
                <div class="cart-item-subtotal">Rp ${(p.price * qty).toLocaleString('id-ID')}</div>
            </div>
            <div class="cart-item-price mt-1">@ Rp ${p.price.toLocaleString('id-ID')}</div>
        </div>
    `).join('');
}

function updateTime() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    document.getElementById('pos-time').innerText = `${h}:${m}`;
}
setInterval(updateTime, 10000);
updateTime();

renderProducts(products);
renderCart();

let cartExpanded = false;

function toggleCart() {
    cartExpanded = !cartExpanded;
    const cartEl = document.querySelector('.pos-cart');
    const overlay = document.getElementById('cartOverlay');
    const floatingBar = document.getElementById('floatingCartBar');

    if (cartExpanded) {
        cartEl.classList.add('expanded');
        overlay.classList.add('show');
        if (floatingBar) floatingBar.style.transform = 'translateY(100%)';
        document.body.style.overflow = 'hidden';
    } else {
        cartEl.classList.remove('expanded');
        overlay.classList.remove('show');
        if (floatingBar) floatingBar.style.transform = '';
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && cartExpanded) toggleCart();
});

(function() {
    let startY = 0;
    let isDragging = false;
    const cartEl = document.querySelector('.pos-cart');

    cartEl.addEventListener('touchstart', (e) => {
        const handle = cartEl.querySelector('.cart-mobile-handle');
        if (handle && handle.contains(e.target)) {
            startY = e.touches[0].clientY;
            isDragging = true;
        }
    }, { passive: true });

    cartEl.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        const diff = e.touches[0].clientY - startY;
        if (diff > 60 && cartExpanded) {
            toggleCart();
            isDragging = false;
        }
    }, { passive: true });

    cartEl.addEventListener('touchend', () => {
        isDragging = false;
    }, { passive: true });
})();

// Checkout Logic

searchInput.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    const query = this.value;

    if (query.length < 2) {
        searchResults.classList.add('d-none');
        return;
    }

    debounceTimer = setTimeout(() => {
        fetch(`{{ route('admin.api.search-anggota') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(user => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'list-group-item list-group-item-action py-2 text-sm';
                        btn.innerHTML = `<div class="fw-bold">${user.name}</div><div class="text-muted text-xs">ID: ${user.nomor_anggota} | Saldo: Rp ${new Intl.NumberFormat('id-ID').format(user.saldo)}</div>`;
                        btn.onclick = () => selectMember(user);
                        searchResults.appendChild(btn);
                    });
                    searchResults.classList.remove('d-none');
                } else {
                    searchResults.innerHTML = '<div class="list-group-item text-muted text-sm py-2">Tidak ditemukan anggota.</div>';
                    searchResults.classList.remove('d-none');
                }
            });
    }, 300);
});

document.addEventListener('click', function(e) {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
        searchResults.classList.add('d-none');
    }
});

function selectMember(user) {
    userIdInput.value = user.id;
    memberSaldo = parseFloat(user.saldo) || 0;

    document.getElementById('selected-member-initial').innerText = user.name.charAt(0).toUpperCase();
    document.getElementById('selected-member-name').innerText = user.name;
    document.getElementById('saldo_awal_text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(memberSaldo);
    
    searchInput.value = '';
    searchInput.parentElement.classList.add('d-none');
    searchResults.classList.add('d-none');
    document.getElementById('selected-member-card').classList.remove('d-none');
    
    checkCheckoutValidity();
}

function clearMemberSelection() {
    userIdInput.value = '';
    memberSaldo = 0;
    
    searchInput.parentElement.classList.remove('d-none');
    document.getElementById('selected-member-card').classList.add('d-none');
    checkCheckoutValidity();
}

function toggleBayarTunai() {
    const metodeEl = document.querySelector('input[name="metode_bayar"]:checked');
    const metode = metodeEl ? metodeEl.value : '';
    const container = document.getElementById('bayar_tunai_container');
    const uangContainer = document.getElementById('uang_diterima_container');
    const bayarTunaiInput = document.getElementById('bayar_tunai');
    const uangDiterimaInput = document.getElementById('uang_diterima');

    if (metode === 'campuran') {
        container.classList.remove('d-none');
        bayarTunaiInput.required = true;
    } else {
        container.classList.add('d-none');
        bayarTunaiInput.required = false;
        bayarTunaiInput.value = '';
    }

    if (metode === 'tunai' || metode === 'campuran') {
        uangContainer.classList.remove('d-none');
        uangDiterimaInput.required = true;
    } else {
        uangContainer.classList.add('d-none');
        uangDiterimaInput.required = false;
        uangDiterimaInput.value = '';
    }

    checkCheckoutValidity();
}

function toggleTipePelanggan() {
    const tipe = document.querySelector('input[name="tipe_pelanggan"]:checked').value;
    const memberContainer = document.getElementById('member_search_container');
    const tunaiInput = document.querySelector('input[value="tunai"]');
    
    if (tipe === 'umum') {
        memberContainer.classList.add('d-none');
        userIdInput.value = '';
        memberSaldo = 0;
        
        // Force tunai payment
        if (tunaiInput) {
            tunaiInput.checked = true;
        }
        toggleBayarTunai();
    } else {
        memberContainer.classList.remove('d-none');
        // Clear selection to force them to select a member
        clearMemberSelection();
    }
    checkCheckoutValidity();
}

function checkCheckoutValidity() {
    try {
        const tipe = document.querySelector('input[name="tipe_pelanggan"]:checked').value;
        const hasUser = userIdInput.value !== '';
        const metodeEl = document.querySelector('input[name="metode_bayar"]:checked');
        const metode = metodeEl ? metodeEl.value : '';
        const hasItems = Object.keys(cart).length > 0;
        const entries = Object.values(cart);
        
        // Calculations
        const subtotal = entries.reduce((s, e) => s + e.product.price * e.qty, 0);
        const diskon = parseFloat(document.getElementById('diskon').value) || 0;
        const grandTotal = Math.max(0, subtotal - diskon);

        document.getElementById('checkout_subtotal').innerText = formatRupiah(subtotal);
        document.getElementById('checkout_diskon_display').innerText = '- ' + formatRupiah(diskon);
        document.getElementById('checkout_total').innerText = formatRupiah(grandTotal);

        const saldoInput = document.querySelector('input[value="saldo"]');
        const campuranInput = document.querySelector('input[value="campuran"]');
        
        if (saldoInput) {
            if (tipe === 'umum' || grandTotal > memberSaldo || memberSaldo <= 0) {
                saldoInput.disabled = true;
                if (saldoInput.checked) {
                    saldoInput.checked = false;
                    toggleBayarTunai();
                }
                if (tipe === 'umum') {
                    document.getElementById('saldo-text-info').innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>Tidak berlaku untuk Umum</span>';
                } else {
                    document.getElementById('saldo-text-info').innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Saldo tidak cukup</span>';
                }
            } else {
                saldoInput.disabled = false;
                document.getElementById('saldo-text-info').innerText = 'Bayar menggunakan saldo utama';
            }
        }

        if (campuranInput) {
            if (tipe === 'umum' || memberSaldo <= 0) {
                campuranInput.disabled = true;
                if (campuranInput.checked) {
                    campuranInput.checked = false;
                    toggleBayarTunai();
                }
            } else {
                campuranInput.disabled = false;
            }
        }

        let isValid = false;
        if (tipe === 'anggota') {
            isValid = hasUser && hasItems && metode;
        } else {
            isValid = hasItems && metode === 'tunai';
        }

        if (isValid && metode === 'saldo' && grandTotal > memberSaldo) {
            isValid = false; // Saldo tidak cukup
        }
        
        let requiredTunai = 0;
        if (metode === 'tunai') {
            requiredTunai = grandTotal;
        } else if (metode === 'campuran') {
            requiredTunai = parseFloat(document.getElementById('bayar_tunai').value) || 0;
            if (requiredTunai <= 0 || (grandTotal - requiredTunai) > memberSaldo) {
                isValid = false;
            }
        }

        // Kembalian Logic
        const uangDiterima = parseFloat(document.getElementById('uang_diterima').value) || 0;
        const kembalianContainer = document.getElementById('checkout_kembalian_container');
        const kembalianDisplay = document.getElementById('checkout_kembalian');

        if (metode === 'tunai' || metode === 'campuran') {
            kembalianContainer.classList.remove('d-none');
            const kembalian = uangDiterima - requiredTunai;
            
            if (kembalian < 0) {
                kembalianDisplay.innerText = '- ' + formatRupiah(Math.abs(kembalian));
                kembalianDisplay.classList.replace('text-success', 'text-danger');
                isValid = false; // Uang diterima kurang
            } else {
                kembalianDisplay.innerText = formatRupiah(kembalian);
                kembalianDisplay.classList.replace('text-danger', 'text-success');
            }
        } else {
            kembalianContainer.classList.add('d-none');
        }

        submitBtn.disabled = !isValid;
    } catch (e) {
        console.error("checkCheckoutValidity error:", e);
    }
}

function toggleOpsional(btn) {
    const container = document.getElementById('opsional_container');
    if (container.classList.contains('d-none')) {
        container.classList.remove('d-none');
        btn.innerHTML = '<i class="bi bi-dash-circle me-1"></i> Sembunyikan Diskon / Catatan';
    } else {
        container.classList.add('d-none');
        btn.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Tambah Diskon / Catatan';
        // reset values if hidden
        document.getElementById('diskon').value = '';
        document.getElementById('keterangan_checkout').value = '';
        checkCheckoutValidity(); // recalculate total
    }
}

document.getElementById('bayar_tunai').addEventListener('input', checkCheckoutValidity);
document.getElementById('uang_diterima').addEventListener('input', checkCheckoutValidity);
document.getElementById('diskon').addEventListener('input', checkCheckoutValidity);

function setUangPas() {
    const metodeEl = document.querySelector('input[name="metode_bayar"]:checked');
    const metode = metodeEl ? metodeEl.value : '';
    const entries = Object.values(cart);
    
    // Calculate total required
    const subtotal = entries.reduce((s, e) => s + e.product.price * e.qty, 0);
    const diskon = parseFloat(document.getElementById('diskon').value) || 0;
    const grandTotal = Math.max(0, subtotal - diskon);
    
    let requiredTunai = 0;
    if (metode === 'tunai') {
        requiredTunai = grandTotal;
    } else if (metode === 'campuran') {
        requiredTunai = parseFloat(document.getElementById('bayar_tunai').value) || 0;
    }
    
    document.getElementById('uang_diterima').value = requiredTunai;
    checkCheckoutValidity();
}
</script>
</body>
</html>

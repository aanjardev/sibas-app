<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIBAS - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/mobile-app.css') }}">
</head>
<body>

    <!-- Header -->
    <header class="app-header">
        <h1 class="app-title">@yield('header_title', 'SIBAS')</h1>
        <div class="header-actions" style="display:flex;align-items:center;gap:14px;">
            @php
                $user = auth()->user();
                $hasUnread = false;
                if ($user) {
                    $hasUnreadDb = $user->unreadNotifications->count() > 0;
                    $lastRead = $user->last_notif_read_at;
                    $hasUnreadSaldo = false;
                    if ($lastRead) {
                        $hasUnreadSaldo = $user->riwayatSaldo()->where('created_at', '>', $lastRead)->exists();
                    } else {
                        $hasUnreadSaldo = $user->riwayatSaldo()->exists();
                    }
                    $hasUnread = $hasUnreadDb || $hasUnreadSaldo;
                }
            @endphp
            <a href="{{ route('notifikasi') }}" class="text-dark position-relative text-decoration-none">
                <i class="bi bi-bell fs-5"></i>
                @if ($hasUnread)
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">Pesan baru</span>
                </span>
                @endif
            </a>
            <button type="button" title="Keluar"
                style="background:none;border:none;padding:2px 0;cursor:pointer;color:#64748b;font-size:1.2rem;line-height:1;display:flex;align-items:center;"
                data-bs-toggle="modal" data-bs-target="#headerLogoutModal">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </div>

    </header>

    <main class="container-fluid px-3 py-4">
        @yield('content')
    </main>

    <!-- Institutional Watermark Footer -->
    <div style="text-align:center; padding: 16px 20px 90px; opacity: 0.6;">
        <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:8px;">
            <img src="{{ asset('images/kemendiksaintek.png') }}" alt="Kemdiktisaintek" style="height:28px; width:auto; object-fit:contain;">
            <img src="{{ asset('images/unmer_malang.png') }}" alt="Unmer Malang" style="height:28px; width:auto; object-fit:contain;">
            <img src="{{ asset('images/um.png') }}" alt="UM" style="height:28px; width:auto; object-fit:contain;">
        </div>
        <div style="font-size:0.6rem; font-weight:600; color:#64748b; letter-spacing:0.2px; line-height:1.4;">
            Program Hibah Pengabdian kepada Masyarakat DPPM 2026
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid{{ request()->routeIs('dashboard') ? '-fill' : '' }}"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('riwayat_sampah') }}" class="nav-item {{ request()->routeIs('riwayat_sampah') ? 'active' : '' }}">
            <i class="bi bi-recycle"></i>
            <span>Sampah</span>
        </a>
        <a href="{{ route('riwayat_belanja') }}" class="nav-item {{ request()->routeIs('riwayat_belanja') ? 'active' : '' }}">
            <i class="bi bi-shop"></i>
            <span>Belanja</span>
        </a>
        <a href="{{ route('tabungan') }}" class="nav-item {{ request()->routeIs('tabungan') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Tabungan</span>
        </a>
        <a href="{{ route('profil') }}" class="nav-item {{ request()->routeIs('profil') ? 'active' : '' }}">
            <i class="bi bi-person{{ request()->routeIs('profil') ? '-fill' : '' }}"></i>
            <span>Profil</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <!-- Header Logout Confirmation Modal -->
    <div class="modal fade" id="headerLogoutModal" tabindex="-1" aria-labelledby="headerLogoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="margin: 1rem auto; width: calc(100% - 2rem); max-width: 360px;">
            <div class="modal-content shadow" style="border-radius: 16px; border: none;">
                <div class="modal-body text-center p-4">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-box-arrow-right fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Konfirmasi Keluar</h5>
                    <p class="text-muted text-sm mb-4">Apakah Anda yakin ingin keluar dari akun Anda?</p>
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-light w-100 fw-bold py-2 border" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 fw-bold py-2" style="border-radius: 8px;">Ya, Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

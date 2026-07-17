<!DOCTYPE html>
<html lang="id">
<head>
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
        <div class="header-actions">
            <a href="{{ route('anggota.notifikasi') }}" class="text-dark position-relative text-decoration-none">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">Pesan baru</span>
                </span>
            </a>
        </div>
    </header>

    <main class="container-fluid px-3 py-4">
        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('anggota.dashboard') }}" class="nav-item {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid{{ request()->routeIs('anggota.dashboard') ? '-fill' : '' }}"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('anggota.riwayat_sampah') }}" class="nav-item {{ request()->routeIs('anggota.riwayat_sampah') ? 'active' : '' }}">
            <i class="bi bi-recycle"></i>
            <span>Sampah</span>
        </a>
        <a href="{{ route('anggota.riwayat_belanja') }}" class="nav-item {{ request()->routeIs('anggota.riwayat_belanja') ? 'active' : '' }}">
            <i class="bi bi-shop"></i>
            <span>Belanja</span>
        </a>
        <a href="{{ route('anggota.tabungan') }}" class="nav-item {{ request()->routeIs('anggota.tabungan') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Tabungan</span>
        </a>
        <a href="{{ route('anggota.profil') }}" class="nav-item {{ request()->routeIs('anggota.profil') ? 'active' : '' }}">
            <i class="bi bi-person{{ request()->routeIs('anggota.profil') ? '-fill' : '' }}"></i>
            <span>Profil</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

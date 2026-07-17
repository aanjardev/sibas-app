<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SIBAS - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Admin Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-app.css') }}">
</head>
<body>

    <!-- Sidebar Overlay for Mobile -->
    <div class="offcanvas-lg offcanvas-start admin-sidebar" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="bi bi-recycle me-2"></i>SIBAS Admin
            </a>
            <!-- Close button for mobile -->
            <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        
        <div class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            
            <div class="nav-category mt-4">Master Data</div>
            <a href="#" class="sidebar-link">
                <i class="bi bi-people"></i> Data Anggota
            </a>
            
            <div class="nav-category mt-4">Transaksi Utama</div>
            <a href="#" class="sidebar-link">
                <i class="bi bi-trash3"></i> Setor Sampah
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-cart3"></i> Belanja Koperasi
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-wallet2"></i> Kelola Tabungan
            </a>
            
            <div class="nav-category mt-4">Koperasi</div>
            <a href="#" class="sidebar-link">
                <i class="bi bi-box-seam"></i> Inventory Barang
            </a>
            
            <div class="nav-category mt-4">Sistem</div>
            <a href="#" class="sidebar-link">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
            <a href="#" class="sidebar-link text-danger mt-3">
                <i class="bi bi-box-arrow-right text-danger"></i> Keluar
            </a>
        </div>
    </div>

    <!-- Header Navbar -->
    <header class="admin-header">
        <div class="d-flex align-items-center">
            <button class="mobile-toggle d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="mb-0 fw-bold" style="font-size: 1.25rem;">@yield('header_title', 'Dashboard')</h4>
        </div>
        
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name=Admin+Bank&background=084627&color=fff" alt="Admin" width="36" height="36" class="rounded-circle me-2">
                    <div class="d-none d-md-block text-start">
                        <div class="fw-bold" style="font-size: 0.85rem; line-height: 1;">Admin Utama</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Administrator</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="admin-main">
        @yield('content')
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

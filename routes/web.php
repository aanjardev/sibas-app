<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAnggotaController;
use App\Http\Controllers\Admin\AdminKategoriSampahController;
use App\Http\Controllers\Admin\AdminSetorSampahController;
use App\Http\Controllers\Admin\AdminTabunganController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminBelanjaController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Admin\AdminUserController;

// ─── Root redirect ────────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ─── Health Check (BetterStack) ───────────────────────────────────────────────
Route::get('/health', function () {
    try {
        \Illuminate\Support\Facades\DB::select('SELECT 1');
        return response()->json(['status' => 'ok', 'database' => 'connected'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'database' => 'disconnected'], 500);
    }
});

// ─── Anggota Auth routes (hanya bisa diakses jika belum login) ───────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/validate-step1', [AuthController::class, 'validateStep1'])->name('register.validate_step1');
    Route::post('/register',[AuthController::class, 'register']);
});

// ─── Anggota Logout ───────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Anggota routes (harus login) ────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',      [AnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat-sampah', [AnggotaController::class, 'riwayatSampah'])->name('riwayat_sampah');
    Route::get('/riwayat-belanja',[AnggotaController::class, 'riwayatBelanja'])->name('riwayat_belanja');
    Route::get('/tabungan',       [AnggotaController::class, 'tabungan'])->name('tabungan');
    Route::get('/profil',         [AnggotaController::class, 'profil'])->name('profil');
    Route::get('/notifikasi',     [AnggotaController::class, 'notifikasi'])->name('notifikasi');
    Route::get('/laporan',        [AnggotaController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export-pdf', [AnggotaController::class, 'exportPdf'])->name('laporan.export_pdf');
});

// ─── Admin Auth Guest routes ──────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::middleware('guest')->group(function () {
        Route::get('/login',            [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',           [AdminAuthController::class, 'login']);
        Route::get('/register',         [AdminAuthController::class, 'showRegister'])->name('register');
        Route::post('/check-invitation',[AdminAuthController::class, 'checkInvitation'])->name('check_invitation');
        Route::post('/register',        [AdminAuthController::class, 'register']);
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Admin Protected routes (harus login & role admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [AdminDashboardController::class, 'profil'])->name('profil');
        Route::post('/profil/update', [AdminDashboardController::class, 'updateProfil'])->name('profil.update');

        Route::get('/api/search-anggota', [AdminSetorSampahController::class, 'searchAnggota'])->name('api.search-anggota');

        Route::resource('anggota', AdminAnggotaController::class);
        
        Route::resource('setor-sampah', AdminSetorSampahController::class)->except(['show']);
        
        Route::resource('kategori-sampah', AdminKategoriSampahController::class)->except(['show']);
        
        Route::resource('tabungan', AdminTabunganController::class)->except(['show']);
        
        Route::post('inventory/{inventory}/restock', [AdminInventoryController::class, 'restock'])->name('inventory.restock');
        Route::resource('inventory', AdminInventoryController::class)->except(['show']);
        
        Route::get('/belanja-koperasi/pos', [AdminBelanjaController::class, 'pos'])->name('belanja-koperasi.pos');
        Route::post('/belanja-koperasi/checkout', [AdminBelanjaController::class, 'checkout'])->name('belanja-koperasi.checkout');
        Route::resource('belanja-koperasi', AdminBelanjaController::class)->except(['create', 'store']);

        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan');

        Route::post('kelola-admin/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('kelola-admin.reset-password');
        Route::resource('kelola-admin', AdminUserController::class)->only(['index', 'create', 'store', 'destroy']);
    });
});

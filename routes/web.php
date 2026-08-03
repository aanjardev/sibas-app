<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;

// ─── Root redirect ────────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ─── Anggota Auth routes (hanya bisa diakses jika belum login) ───────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// ─── Anggota Logout ───────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Anggota routes (harus login) ────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',     function () { return view('anggota.dashboard'); })->name('dashboard');
    Route::get('/riwayat-sampah',function () { return view('anggota.riwayat-sampah'); })->name('riwayat_sampah');
    Route::get('/riwayat-belanja',function () { return view('anggota.riwayat-belanja'); })->name('riwayat_belanja');
    Route::get('/tabungan',      function () { return view('anggota.tabungan'); })->name('tabungan');
    Route::get('/profil',        function () { return view('anggota.profil'); })->name('profil');
    Route::get('/notifikasi',    function () { return view('anggota.notifikasi'); })->name('notifikasi');
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
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

        Route::get('/anggota',          function () { return view('admin.anggota.index'); })->name('anggota.index');
        Route::get('/anggota/create',   function () { return view('admin.anggota.create'); })->name('anggota.create');
        Route::get('/anggota/{id}',     function () { return view('admin.anggota.show'); })->name('anggota.show');
        Route::get('/anggota/{id}/edit',function () { return view('admin.anggota.edit'); })->name('anggota.edit');

        Route::get('/setor-sampah',           function () { return view('admin.setor-sampah.index'); })->name('setor-sampah.index');
        Route::get('/setor-sampah/create',    function () { return view('admin.setor-sampah.create'); })->name('setor-sampah.create');
        Route::get('/setor-sampah/{id}/edit', function () { return view('admin.setor-sampah.edit'); })->name('setor-sampah.edit');

        Route::get('/kategori-sampah',           function () { return view('admin.kategori-sampah.index'); })->name('kategori-sampah.index');
        Route::get('/kategori-sampah/create',    function () { return view('admin.kategori-sampah.create'); })->name('kategori-sampah.create');
        Route::get('/kategori-sampah/{id}/edit', function () { return view('admin.kategori-sampah.edit'); })->name('kategori-sampah.edit');
    });
});

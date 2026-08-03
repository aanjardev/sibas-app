<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ─── Root redirect ────────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ─── Auth routes (hanya bisa diakses jika belum login) ───────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// ─── Logout ──────────────────────────────────────────────────────────────────
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

// ─── Admin routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

    Route::get('/anggota',          function () { return view('admin.anggota.index'); })->name('anggota.index');
    Route::get('/anggota/create',   function () { return view('admin.anggota.create'); })->name('anggota.create');
    Route::get('/anggota/{id}',     function () { return view('admin.anggota.show'); })->name('anggota.show');
    Route::get('/anggota/{id}/edit',function () { return view('admin.anggota.edit'); })->name('anggota.edit');

    Route::get('/setor-sampah',           function () { return view('admin.setor-sampah.index'); })->name('setor-sampah.index');
    Route::get('/setor-sampah/create',    function () { return view('admin.setor-sampah.create'); })->name('setor-sampah.create');
    Route::get('/setor-sampah/{id}/edit', function () { return view('admin.setor-sampah.edit'); })->name('setor-sampah.edit');
});

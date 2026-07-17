<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('anggota.dashboard');
});

Route::prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', function () { return view('anggota.dashboard'); })->name('dashboard');
    Route::get('/riwayat-sampah', function () { return view('anggota.riwayat-sampah'); })->name('riwayat_sampah');
    Route::get('/riwayat-belanja', function () { return view('anggota.riwayat-belanja'); })->name('riwayat_belanja');
    Route::get('/tabungan', function () { return view('anggota.tabungan'); })->name('tabungan');
    Route::get('/profil', function () { return view('anggota.profil'); })->name('profil');
    Route::get('/notifikasi', function () { return view('anggota.notifikasi'); })->name('notifikasi');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
});

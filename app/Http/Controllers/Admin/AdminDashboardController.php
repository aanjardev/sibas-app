<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\RiwayatSaldo;
use App\Models\TransaksiSampah;
use App\Models\TransaksiBelanja;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->startOfMonth();

        $totalAnggota = User::where('role', 'anggota')->count();

        $sampahMasukBulanIni = TransaksiSampah::where('created_at', '>=', $bulanIni)->sum('berat');

        $penjualanKoperasiBulanIni = TransaksiBelanja::where('created_at', '>=', $bulanIni)
            ->where('status', 'selesai')
            ->sum('total_belanja');

        $totalSaldoTabungan = User::where('role', 'anggota')->sum('saldo_tabungan');

        $aktivitasTerbaru = RiwayatSaldo::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalAnggota',
            'sampahMasukBulanIni',
            'penjualanKoperasiBulanIni',
            'totalSaldoTabungan',
            'aktivitasTerbaru'
        ));
    }
}

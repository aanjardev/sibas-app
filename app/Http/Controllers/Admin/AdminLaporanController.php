<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksiBelanja;
use App\Models\KategoriProduk;
use App\Models\KategoriSampah;
use App\Models\RiwayatTabungan;
use App\Models\TransaksiBelanja;
use App\Models\TransaksiSampah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'sampah');

        // ── Resolve date range ────────────────────────────────────────────
        $periode = $request->input('periode', 'bulan_ini');
        $now = Carbon::now();

        switch ($periode) {
            case 'bulan_lalu':
                $dari = $now->copy()->subMonth()->startOfMonth();
                $sampai = $now->copy()->subMonth()->endOfMonth();
                break;
            case '3_bulan':
                $dari = $now->copy()->subMonths(2)->startOfMonth();
                $sampai = $now->copy()->endOfDay();
                break;
            case 'custom':
                $dari = $request->input('dari') ? Carbon::parse($request->input('dari'))->startOfDay() : $now->copy()->startOfMonth();
                $sampai = $request->input('sampai') ? Carbon::parse($request->input('sampai'))->endOfDay() : $now->copy()->endOfDay();
                break;
            default: // bulan_ini
                $dari = $now->copy()->startOfMonth();
                $sampai = $now->copy()->endOfDay();
                break;
        }

        $data = [];

        // ── TAB: SETOR SAMPAH ─────────────────────────────────────────────
        if ($tab === 'sampah') {
            $query = TransaksiSampah::with(['user', 'kategoriSampah'])
                ->whereBetween('created_at', [$dari, $sampai]);

            $data['totalTransaksi'] = (clone $query)->count();
            $data['totalBerat'] = floatval((clone $query)->sum('berat'));
            $data['totalNilai'] = floatval((clone $query)->sum('total'));
            $data['totalAnggotaAktif'] = (clone $query)->distinct('user_id')->count('user_id');

            // Jenis sampah terbanyak
            $data['sampahPerKategori'] = TransaksiSampah::with('kategoriSampah')
                ->whereBetween('created_at', [$dari, $sampai])
                ->selectRaw('kategori_sampah_id, SUM(berat) as total_berat, SUM(total) as total_nilai, COUNT(*) as jumlah_transaksi')
                ->groupBy('kategori_sampah_id')
                ->orderByDesc('total_berat')
                ->get();

            // Tabel detail transaksi
            $data['transaksiList'] = (clone $query)->latest()->paginate(20)->withQueryString();
        }

        // ── TAB: BELANJA KOPERASI ─────────────────────────────────────────
        if ($tab === 'belanja') {
            $query = TransaksiBelanja::with('user')
                ->whereBetween('created_at', [$dari, $sampai]);

            $data['totalTransaksi'] = (clone $query)->count();
            $data['totalOmzet'] = floatval((clone $query)->where('status', 'selesai')->sum('total_belanja'));
            $data['totalBayarSaldo'] = floatval((clone $query)->where('status', 'selesai')->sum('bayar_saldo'));
            $data['totalBayarTunai'] = floatval((clone $query)->where('status', 'selesai')->sum('bayar_tunai'));

            // Produk terlaris
            $data['produkTerlaris'] = DetailTransaksiBelanja::with('kategoriProduk')
                ->whereHas('transaksiBelanja', function ($q) use ($dari, $sampai) {
                    $q->whereBetween('created_at', [$dari, $sampai])->where('status', 'selesai');
                })
                ->selectRaw('kategori_produk_id, SUM(jumlah) as total_terjual, SUM(subtotal) as total_pendapatan')
                ->groupBy('kategori_produk_id')
                ->orderByDesc('total_terjual')
                ->limit(10)
                ->get();

            $data['transaksiList'] = (clone $query)->latest()->paginate(20)->withQueryString();
        }

        // ── TAB: TABUNGAN ─────────────────────────────────────────────────
        if ($tab === 'tabungan') {
            $query = RiwayatTabungan::with(['user', 'admin'])
                ->whereBetween('created_at', [$dari, $sampai]);

            $data['totalSetor'] = floatval((clone $query)->where('jenis', 'setor')->sum('nominal'));
            $data['totalTarik'] = floatval((clone $query)->where('jenis', 'tarik')->sum('nominal'));
            $data['jumlahTransaksi'] = (clone $query)->count();
            $data['totalDanaKelola'] = floatval(User::where('role', 'anggota')->sum('saldo_tabungan'));

            $data['transaksiList'] = (clone $query)->latest()->paginate(20)->withQueryString();
        }

        // ── TAB: INVENTORY ────────────────────────────────────────────────
        if ($tab === 'inventory') {
            $data['totalProduk'] = KategoriProduk::count();
            $data['produkAktif'] = KategoriProduk::where('is_active', true)->count();
            $data['stokMenipis'] = KategoriProduk::where('stok', '>', 0)->where('stok', '<=', 5)->count();
            $data['stokHabis'] = KategoriProduk::where('stok', '<=', 0)->count();
            $data['nilaiInventaris'] = floatval(KategoriProduk::selectRaw('SUM(harga_jual * stok) as total')->value('total') ?? 0);

            $data['produkList'] = KategoriProduk::orderByRaw('CASE WHEN stok <= 0 THEN 0 WHEN stok <= 5 THEN 1 ELSE 2 END ASC')
                ->orderBy('stok', 'asc')
                ->paginate(20)
                ->withQueryString();
        }

        return view('admin.laporan.index', compact('tab', 'periode', 'dari', 'sampai', 'data'));
    }
}

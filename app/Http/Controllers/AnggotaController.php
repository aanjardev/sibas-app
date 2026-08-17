<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    /**
     * Dashboard — saldo, ringkasan bulan ini, aktivitas terakhir.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $bulanIni = Carbon::now();

        // ── Ringkasan bulan ini ──────────────────────────────────────
        $transaksiSampahBulanIni = $user->transaksiSampah()
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->get();

        $totalBeratSampah     = $transaksiSampahBulanIni->sum('berat');
        $totalCashbackSampah  = $transaksiSampahBulanIni->sum('total');

        $totalBelanjaBulanIni = $user->transaksiBelanja()
            ->where('status', 'selesai')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->count();

        // ── Aktivitas terakhir (gabungan riwayat_saldo + riwayat_tabungan + transaksi_belanja) ──
        $riwayatSaldo = $user->riwayatSaldo()
            ->where('jenis', '!=', 'belanja')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $isIncome = in_array($item->jenis, ['penukaran_sampah', 'deposit']);
                return (object) [
                    'type'       => $item->jenis,
                    'label'      => match ($item->jenis) {
                        'penukaran_sampah' => 'Setor Sampah',
                        'belanja'          => 'Belanja Koperasi',
                        'deposit'          => 'Setor Tunai Tabungan',
                        'penarikan'        => 'Tarik Tunai Tabungan',
                        default            => ucfirst($item->jenis),
                    },
                    'css_class'  => match ($item->jenis) {
                        'penukaran_sampah' => 'setor-sampah',
                        'belanja'          => 'belanja',
                        'deposit'          => 'setor-tunai',
                        'penarikan'        => 'tarik-tunai',
                        default            => '',
                    },
                    'keterangan' => $item->keterangan,
                    'nominal'    => $item->nominal,
                    'is_income'  => $isIncome,
                    'created_at' => $item->created_at,
                ];
            });

        $riwayatTabungan = $user->riwayatTabungan()
            ->with('admin')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'type'       => $item->jenis === 'setor' ? 'deposit' : 'penarikan',
                    'label'      => $item->jenis === 'setor' ? 'Setor Tunai Tabungan' : 'Tarik Tunai Tabungan',
                    'css_class'  => $item->jenis === 'setor' ? 'setor-tunai' : 'tarik-tunai',
                    'keterangan' => $item->keterangan ?? ($item->admin ? 'Melalui Admin (' . $item->admin->name . ')' : ''),
                    'nominal'    => $item->nominal,
                    'is_income'  => $item->jenis === 'setor',
                    'created_at' => $item->created_at,
                ];
            });

        $transaksiBelanja = $user->transaksiBelanja()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'type'       => 'belanja',
                    'label'      => 'Belanja Koperasi',
                    'css_class'  => 'belanja',
                    'keterangan' => 'Pembelanjaan di Koperasi',
                    'nominal'    => $item->total_belanja,
                    'is_income'  => false,
                    'created_at' => $item->created_at,
                ];
            });

        $aktivitasTerakhir = $riwayatSaldo->concat($riwayatTabungan)->concat($transaksiBelanja)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('anggota.dashboard', compact(
            'user',
            'totalBeratSampah',
            'totalCashbackSampah',
            'totalBelanjaBulanIni',
            'aktivitasTerakhir',
            'bulanIni',
        ));
    }

    /**
     * Riwayat Setor Sampah — list transaksi sampah user.
     */
    public function riwayatSampah(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $bulanIni = Carbon::createFromDate($year, $month, 1);

        $transaksiSampah = $user->transaksiSampah()
            ->with('kategoriSampah')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->latest()
            ->get();

        $totalCashback = $transaksiSampah->sum('total');
        $totalBerat    = $transaksiSampah->sum('berat');

        return view('anggota.riwayat-sampah', compact(
            'user',
            'transaksiSampah',
            'totalCashback',
            'totalBerat',
            'bulanIni',
        ));
    }

    /**
     * Riwayat Belanja Koperasi — list transaksi belanja user.
     */
    public function riwayatBelanja(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $bulanIni = Carbon::createFromDate($year, $month, 1);

        $transaksiBelanja = $user->transaksiBelanja()
            ->with('details.kategoriProduk')
            ->where('status', 'selesai')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->latest()
            ->get();

        $totalBelanja    = $transaksiBelanja->sum('total_belanja');
        $frekuensiBelanja = $transaksiBelanja->count();

        return view('anggota.riwayat-belanja', compact(
            'user',
            'transaksiBelanja',
            'totalBelanja',
            'frekuensiBelanja',
            'bulanIni',
        ));
    }

    /**
     * Tabungan — saldo tabungan & riwayat setor/tarik.
     */
    public function tabungan(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $bulanIni = Carbon::createFromDate($year, $month, 1);

        $riwayatTabungan = $user->riwayatTabungan()
            ->with('admin')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->latest()
            ->get();

        return view('anggota.tabungan', compact(
            'user',
            'riwayatTabungan',
            'bulanIni',
        ));
    }

    /**
     * Profil — data profil user yang login.
     */
    public function profil()
    {
        $user = Auth::user();

        return view('anggota.profil', compact('user'));
    }

    /**
     * Notifikasi — riwayat saldo dikelompokkan per waktu.
     */
    public function notifikasi()
    {
        $user = Auth::user();
        $now  = Carbon::now();

        // Tandai semua notifikasi telah dibaca
        $user->update(['last_notif_read_at' => $now]);
        $user->unreadNotifications->markAsRead();

        // Ambil semua riwayat saldo 30 hari terakhir
        $riwayatSaldo = $user->riwayatSaldo()
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->latest()
            ->get();

        // Ambil notifikasi dari tabel notifications
        $dbNotif = $user->notifications()
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->get()
            ->map(function ($notif) {
                return (object) [
                    'jenis'      => $notif->data['tipe_transaksi'] ?? $notif->data['jenis'] ?? 'info',
                    'nominal'    => 0,
                    'keterangan' => $notif->data['pesan'] ?? $notif->data['message'] ?? '',
                    'title'      => $notif->data['judul'] ?? $notif->data['title'] ?? 'Notifikasi',
                    'created_at' => $notif->created_at,
                    'is_db_notif'=> true,
                ];
            });

        // Merge dan urutkan
        $allNotifikasi = $riwayatSaldo->concat($dbNotif)->sortByDesc('created_at')->values();

        // Group by waktu
        $hariIni   = $allNotifikasi->filter(fn ($item) => $item->created_at->isToday());
        $mingguIni = $allNotifikasi->filter(fn ($item) => !$item->created_at->isToday() && $item->created_at->isCurrentWeek());
        $lebihLama = $allNotifikasi->filter(fn ($item) => !$item->created_at->isToday() && !$item->created_at->isCurrentWeek());

        return view('anggota.notifikasi', compact(
            'user',
            'hariIni',
            'mingguIni',
            'lebihLama',
        ));
    }
}

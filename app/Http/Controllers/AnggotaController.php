<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    /**
     * Dashboard — saldo, ringkasan bulan ini, aktivitas terakhir.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $bulanIni = Carbon::now();
        $totalSaldo = (float) $user->saldo + (float) $user->saldo_tabungan;

        // ── Ringkasan bulan ini ──────────────────────────────────────
        $transaksiSampahBulanIni = $user->transaksiSampah()
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->get();

        $totalBeratSampah     = $transaksiSampahBulanIni->sum('berat');
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
            'totalSaldo',
            'totalBeratSampah',
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

    /**
     * Halaman Laporan & Rekapitulasi Anggota
     */
    public function laporan(Request $request)
    {
        $user = Auth::user();
        $laporanData = $this->getLaporanData($user, $request);

        return view('anggota.laporan', array_merge(['user' => $user], $laporanData));
    }

    /**
     * Export Laporan Anggota ke PDF
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $laporanData = $this->getLaporanData($user, $request);

        $pdf = Pdf::loadView('anggota.laporan-pdf', array_merge([
            'user' => $user,
            'printedAt' => Carbon::now(),
        ], $laporanData));

        $pdf->setPaper('a4', 'portrait');

        $cleanUserName = Str::slug($user->name, '_');
        $periodeSlug = Str::slug($laporanData['periodeLabel'], '_');
        $filename = "Laporan_Aktivitas_{$cleanUserName}_{$periodeSlug}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Helper untuk mengambil data laporan terpadu anggota
     */
    private function getLaporanData($user, Request $request): array
    {
        $periode = $request->input('periode', 'bulan_ini');
        $tab = $request->input('tab', 'semua');
        $now = Carbon::now();

        switch ($periode) {
            case 'bulan_lalu':
                $dari = $now->copy()->subMonth()->startOfMonth();
                $sampai = $now->copy()->subMonth()->endOfMonth();
                $periodeLabel = $now->copy()->subMonth()->translatedFormat('F Y');
                break;
            case '3_bulan':
                $dari = $now->copy()->subMonths(2)->startOfMonth();
                $sampai = $now->copy()->endOfDay();
                $periodeLabel = '3 Bulan Terakhir (' . $dari->translatedFormat('M') . ' - ' . $sampai->translatedFormat('M Y') . ')';
                break;
            case 'semua':
                $dari = Carbon::createFromTimestamp(0);
                $sampai = $now->copy()->endOfDay();
                $periodeLabel = 'Semua Riwayat Transaksi';
                break;
            case 'custom':
                $dari = $request->input('dari') ? Carbon::parse($request->input('dari'))->startOfDay() : $now->copy()->startOfMonth();
                $sampai = $request->input('sampai') ? Carbon::parse($request->input('sampai'))->endOfDay() : $now->copy()->endOfDay();
                $periodeLabel = $dari->translatedFormat('d M Y') . ' s/d ' . $sampai->translatedFormat('d M Y');
                break;
            default: // bulan_ini
                $dari = $now->copy()->startOfMonth();
                $sampai = $now->copy()->endOfDay();
                $periodeLabel = $now->translatedFormat('F Y');
                break;
        }

        // 1. Transaksi Setor Sampah
        $transaksiSampah = $user->transaksiSampah()
            ->with('kategoriSampah')
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $totalBeratSampah = (float) $transaksiSampah->sum('berat');
        $totalCashbackSampah = (float) $transaksiSampah->sum('total');
        $jumlahTransaksiSampah = $transaksiSampah->count();

        // 2. Transaksi Belanja Koperasi
        $transaksiBelanja = $user->transaksiBelanja()
            ->with('details.kategoriProduk')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $totalBelanja = (float) $transaksiBelanja->sum('total_belanja');
        $jumlahTransaksiBelanja = $transaksiBelanja->count();

        // 3. Riwayat Transaksi Tabungan
        $riwayatTabungan = $user->riwayatTabungan()
            ->with('admin')
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $totalSetorTabungan = (float) $riwayatTabungan->where('jenis', 'setor')->sum('nominal');
        $totalTarikTabungan = (float) $riwayatTabungan->where('jenis', 'tarik')->sum('nominal');
        $jumlahTransaksiTabungan = $riwayatTabungan->count();

        // 4. Riwayat Terpadu (Gabungan semua aktivitas)
        $timelineSampah = $transaksiSampah->map(function ($item) {
            return (object) [
                'type'        => 'sampah',
                'badge'       => 'Setor Sampah',
                'badge_class' => 'bg-success',
                'title'       => 'Setor Sampah: ' . ($item->kategoriSampah->nama_kategori ?? 'Sampah'),
                'detail'      => number_format($item->berat, 1) . ' kg @ Rp ' . number_format($item->harga_per_kg, 0, ',', '.'),
                'nominal'     => $item->total,
                'is_plus'     => true,
                'created_at'  => $item->created_at,
            ];
        });

        $timelineBelanja = $transaksiBelanja->map(function ($item) {
            $itemsSummary = $item->details->map(fn($d) => ($d->kategoriProduk->nama_produk ?? 'Produk') . ' (x' . $d->jumlah . ')')->implode(', ');
            return (object) [
                'type'        => 'belanja',
                'badge'       => 'Belanja',
                'badge_class' => 'bg-primary',
                'title'       => 'Belanja Koperasi',
                'detail'      => $itemsSummary ?: 'Pembelian produk koperasi',
                'nominal'     => $item->total_belanja,
                'is_plus'     => false,
                'created_at'  => $item->created_at,
            ];
        });

        $timelineTabungan = $riwayatTabungan->map(function ($item) {
            $isSetor = $item->jenis === 'setor';
            return (object) [
                'type'        => 'tabungan',
                'badge'       => $isSetor ? 'Setor Tabungan' : 'Tarik Tabungan',
                'badge_class' => $isSetor ? 'bg-info text-dark' : 'bg-warning text-dark',
                'title'       => $isSetor ? 'Setor Tunai Tabungan' : 'Penarikan Tunai Tabungan',
                'detail'      => $item->keterangan ?: ($item->admin ? 'Diproses oleh ' . $item->admin->name : '-'),
                'nominal'     => $item->nominal,
                'is_plus'     => $isSetor,
                'created_at'  => $item->created_at,
            ];
        });

        $semuaTransaksi = $timelineSampah
            ->concat($timelineBelanja)
            ->concat($timelineTabungan)
            ->sortByDesc('created_at')
            ->values();

        return [
            'periode'                 => $periode,
            'periodeLabel'            => $periodeLabel,
            'dari'                    => $dari,
            'sampai'                  => $sampai,
            'tab'                     => $tab,
            'transaksiSampah'         => $transaksiSampah,
            'totalBeratSampah'        => $totalBeratSampah,
            'totalCashbackSampah'     => $totalCashbackSampah,
            'jumlahTransaksiSampah'   => $jumlahTransaksiSampah,
            'transaksiBelanja'        => $transaksiBelanja,
            'totalBelanja'            => $totalBelanja,
            'jumlahTransaksiBelanja'  => $jumlahTransaksiBelanja,
            'riwayatTabungan'         => $riwayatTabungan,
            'totalSetorTabungan'      => $totalSetorTabungan,
            'totalTarikTabungan'      => $totalTarikTabungan,
            'jumlahTransaksiTabungan' => $jumlahTransaksiTabungan,
            'semuaTransaksi'          => $semuaTransaksi,
        ];
    }
}

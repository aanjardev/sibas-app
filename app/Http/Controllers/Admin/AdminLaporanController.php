<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksiBelanja;
use App\Models\KategoriProduk;
use App\Models\RiwayatTabungan;
use App\Models\TransaksiBelanja;
use App\Models\TransaksiSampah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    /**
     * Export laporan aktif ke workbook yang tabel-tabelnya dipisahkan per sheet.
     */
    public function exportExcel(Request $request)
    {
        $tab = $request->string('tab', 'sampah')->toString();
        $scope = $request->string('scope', 'current')->toString();
        abort_unless(in_array($tab, ['sampah', 'belanja', 'tabungan', 'inventory'], true), 404);
        abort_unless(in_array($scope, ['current', 'all'], true), 404);

        [$dari, $sampai] = $this->resolveDateRange($request);
        $spreadsheet = new Spreadsheet;
        $spreadsheet->removeSheetByIndex(0);

        if ($scope === 'all') {
            $this->addSampahSheets($spreadsheet, $dari, $sampai, 'Sampah - ');
            $this->addBelanjaSheets($spreadsheet, $dari, $sampai, 'Belanja - ');
            $this->addTabunganSheets($spreadsheet, $dari, $sampai, 'Tabungan - ');
            $this->addInventorySheets($spreadsheet, $dari, $sampai, 'Inventory - ');
        } else {
            match ($tab) {
                'sampah' => $this->addSampahSheets($spreadsheet, $dari, $sampai),
                'belanja' => $this->addBelanjaSheets($spreadsheet, $dari, $sampai),
                'tabungan' => $this->addTabunganSheets($spreadsheet, $dari, $sampai),
                'inventory' => $this->addInventorySheets($spreadsheet, $dari, $sampai),
            };
        }

        $spreadsheet->setActiveSheetIndex(0);
        $filename = sprintf(
            'Laporan_%s_%s_%s.xlsx',
            $scope === 'all' ? 'Semua' : ucfirst($tab),
            $dari->format('Ymd'),
            $sampai->format('Ymd')
        );

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate',
        ]);
    }

    private function resolveDateRange(Request $request): array
    {
        $now = Carbon::now();

        return match ($request->input('periode', 'bulan_ini')) {
            'bulan_lalu' => [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()],
            '3_bulan' => [$now->copy()->subMonths(2)->startOfMonth(), $now->copy()->endOfDay()],
            'custom' => [
                $request->filled('dari') ? Carbon::parse($request->input('dari'))->startOfDay() : $now->copy()->startOfMonth(),
                $request->filled('sampai') ? Carbon::parse($request->input('sampai'))->endOfDay() : $now->copy()->endOfDay(),
            ],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfDay()],
        };
    }

    private function addSampahSheets(Spreadsheet $book, Carbon $dari, Carbon $sampai, string $prefix = ''): void
    {
        $query = TransaksiSampah::with(['user', 'kategoriSampah'])->whereBetween('created_at', [$dari, $sampai]);
        $rekap = TransaksiSampah::with('kategoriSampah')
            ->whereBetween('created_at', [$dari, $sampai])
            ->selectRaw('kategori_sampah_id, SUM(berat) total_berat, SUM(total) total_nilai, COUNT(*) jumlah_transaksi')
            ->groupBy('kategori_sampah_id')->orderByDesc('total_berat')->get();

        $this->addSummarySheet($book, 'Setor Sampah', $dari, $sampai, [
            ['Total Transaksi', (clone $query)->count(), 'transaksi'],
            ['Total Berat', (float) (clone $query)->sum('berat'), 'kg'],
            ['Total Nilai', (float) (clone $query)->sum('total'), 'rupiah'],
            ['Anggota Aktif', (clone $query)->distinct()->count('user_id'), 'orang'],
        ], $prefix);

        $this->addTableSheet($book, $prefix.'Rekap Kategori',
            ['Jenis Sampah', 'Jumlah Transaksi', 'Total Berat (kg)', 'Total Nilai (Rp)'],
            $rekap->map(fn ($row) => [$this->safeText($row->kategoriSampah?->nama), (int) $row->jumlah_transaksi, (float) $row->total_berat, (float) $row->total_nilai])->all(),
            ['C' => '#,##0.00', 'D' => '#,##0']
        );

        $rows = (clone $query)->oldest()->get()->map(fn ($trx) => [
            $trx->created_at->format('Y-m-d H:i:s'), $this->safeText($trx->user?->nomor_anggota),
            $this->safeText($trx->user?->name), $this->safeText($trx->kategoriSampah?->nama),
            (float) $trx->berat, (float) $trx->harga_satuan, (float) $trx->total, $this->safeText($trx->keterangan),
        ])->all();
        $this->addTableSheet($book, $prefix.'Detail Setoran',
            ['Tanggal', 'No. Anggota', 'Nama Anggota', 'Jenis Sampah', 'Berat (kg)', 'Harga per Kg (Rp)', 'Total (Rp)', 'Keterangan'],
            $rows, ['E' => '#,##0.00', 'F' => '#,##0', 'G' => '#,##0']
        );
    }

    private function addBelanjaSheets(Spreadsheet $book, Carbon $dari, Carbon $sampai, string $prefix = ''): void
    {
        $query = TransaksiBelanja::with('user')->whereBetween('created_at', [$dari, $sampai]);
        $selesai = (clone $query)->where('status', 'selesai');
        $this->addSummarySheet($book, 'Belanja Koperasi', $dari, $sampai, [
            ['Total Transaksi', (clone $query)->count(), 'transaksi'],
            ['Omzet Penjualan', (float) (clone $selesai)->sum('total_belanja'), 'rupiah'],
            ['Pembayaran Saldo', (float) (clone $selesai)->sum('bayar_saldo'), 'rupiah'],
            ['Pembayaran Tunai', (float) (clone $selesai)->sum('bayar_tunai'), 'rupiah'],
        ], $prefix);

        $produk = DetailTransaksiBelanja::with('kategoriProduk')
            ->whereHas('transaksiBelanja', fn ($q) => $q->whereBetween('created_at', [$dari, $sampai])->where('status', 'selesai'))
            ->selectRaw('kategori_produk_id, SUM(jumlah) total_terjual, SUM(subtotal) total_pendapatan')
            ->groupBy('kategori_produk_id')->orderByDesc('total_terjual')->get();
        $this->addTableSheet($book, $prefix.'Rekap Produk', ['Produk', 'Jumlah Terjual', 'Pendapatan (Rp)'],
            $produk->map(fn ($row) => [$this->safeText($row->kategoriProduk?->nama), (float) $row->total_terjual, (float) $row->total_pendapatan])->all(),
            ['B' => '#,##0.00', 'C' => '#,##0']
        );

        $transactions = (clone $query)->oldest()->get();
        $this->addTableSheet($book, $prefix.'Transaksi',
            ['ID Transaksi', 'Tanggal', 'No. Anggota', 'Nama Anggota', 'Total Belanja (Rp)', 'Bayar Saldo (Rp)', 'Bayar Tunai (Rp)', 'Status', 'Keterangan'],
            $transactions->map(fn ($trx) => [$trx->id, $trx->created_at->format('Y-m-d H:i:s'), $this->safeText($trx->user?->nomor_anggota), $this->safeText($trx->user?->name), (float) $trx->total_belanja, (float) $trx->bayar_saldo, (float) $trx->bayar_tunai, $trx->status, $this->safeText($trx->keterangan)])->all(),
            ['E' => '#,##0', 'F' => '#,##0', 'G' => '#,##0']
        );

        $details = DetailTransaksiBelanja::with(['transaksiBelanja.user', 'kategoriProduk'])
            ->whereHas('transaksiBelanja', fn ($q) => $q->whereBetween('created_at', [$dari, $sampai]))
            ->orderBy('transaksi_belanja_id')->get();
        $this->addTableSheet($book, $prefix.'Detail Item',
            ['ID Transaksi', 'Tanggal', 'Nama Anggota', 'Produk', 'Jumlah', 'Satuan', 'Harga Satuan (Rp)', 'Subtotal (Rp)'],
            $details->map(fn ($row) => [$row->transaksi_belanja_id, $row->transaksiBelanja->created_at->format('Y-m-d H:i:s'), $this->safeText($row->transaksiBelanja->user?->name), $this->safeText($row->kategoriProduk?->nama), (float) $row->jumlah, $this->safeText($row->kategoriProduk?->satuan), (float) $row->harga_satuan, (float) $row->subtotal])->all(),
            ['E' => '#,##0.00', 'G' => '#,##0', 'H' => '#,##0']
        );
    }

    private function addTabunganSheets(Spreadsheet $book, Carbon $dari, Carbon $sampai, string $prefix = ''): void
    {
        $query = RiwayatTabungan::with(['user', 'admin'])->whereBetween('created_at', [$dari, $sampai]);
        $this->addSummarySheet($book, 'Tabungan', $dari, $sampai, [
            ['Total Setor', (float) (clone $query)->where('jenis', 'setor')->sum('nominal'), 'rupiah'],
            ['Total Tarik', (float) (clone $query)->where('jenis', 'tarik')->sum('nominal'), 'rupiah'],
            ['Jumlah Transaksi', (clone $query)->count(), 'transaksi'],
            ['Total Dana Dikelola Saat Ini', (float) User::where('role', 'anggota')->sum('saldo_tabungan'), 'rupiah'],
        ], $prefix);
        $this->addTableSheet($book, $prefix === '' ? 'Transaksi Tabungan' : $prefix.'Transaksi',
            ['Tanggal', 'No. Anggota', 'Nama Anggota', 'Jenis', 'Nominal (Rp)', 'Saldo Sebelum (Rp)', 'Saldo Sesudah (Rp)', 'Admin', 'Keterangan'],
            (clone $query)->oldest()->get()->map(fn ($trx) => [$trx->created_at->format('Y-m-d H:i:s'), $this->safeText($trx->user?->nomor_anggota), $this->safeText($trx->user?->name), ucfirst($trx->jenis), (float) $trx->nominal, (float) $trx->saldo_sebelum, (float) $trx->saldo_sesudah, $this->safeText($trx->admin?->name), $this->safeText($trx->keterangan)])->all(),
            ['E' => '#,##0', 'F' => '#,##0', 'G' => '#,##0']
        );
    }

    private function addInventorySheets(Spreadsheet $book, Carbon $dari, Carbon $sampai, string $prefix = ''): void
    {
        $this->addSummarySheet($book, 'Inventory', $dari, $sampai, [
            ['Total Produk', KategoriProduk::count(), 'produk'],
            ['Produk Aktif', KategoriProduk::where('is_active', true)->count(), 'produk'],
            ['Stok Menipis (1-5)', KategoriProduk::where('stok', '>', 0)->where('stok', '<=', 5)->count(), 'produk'],
            ['Stok Habis', KategoriProduk::where('stok', '<=', 0)->count(), 'produk'],
            ['Nilai Inventaris', (float) (KategoriProduk::selectRaw('SUM(harga_jual * stok) total')->value('total') ?? 0), 'rupiah'],
        ], $prefix);
        $this->addTableSheet($book, $prefix.'Daftar Produk',
            ['ID Produk', 'Nama Produk', 'Satuan', 'Harga Jual (Rp)', 'Stok', 'Nilai Stok (Rp)', 'Status Aktif', 'Kondisi Stok'],
            KategoriProduk::orderBy('nama')->get()->map(fn ($p) => [$p->id, $this->safeText($p->nama), $this->safeText($p->satuan), (float) $p->harga_jual, (float) $p->stok, (float) $p->harga_jual * (float) $p->stok, $p->is_active ? 'Aktif' : 'Nonaktif', (float) $p->stok <= 0 ? 'Habis' : ((float) $p->stok <= 5 ? 'Menipis' : 'Tersedia')])->all(),
            ['D' => '#,##0', 'E' => '#,##0.00', 'F' => '#,##0']
        );
    }

    private function addSummarySheet(Spreadsheet $book, string $report, Carbon $dari, Carbon $sampai, array $metrics, string $prefix = ''): void
    {
        $this->addTableSheet($book, $prefix.'Ringkasan', ['Indikator', 'Nilai', 'Satuan'], [
            ['Jenis Laporan', $report, ''],
            ['Periode Mulai', $dari->format('Y-m-d'), ''],
            ['Periode Selesai', $sampai->format('Y-m-d'), ''],
            ...$metrics,
        ], ['B' => '#,##0.00']);
    }

    private function addTableSheet(Spreadsheet $book, string $title, array $headers, array $rows, array $formats = []): void
    {
        $sheet = $book->createSheet();
        $sheet->setTitle($title);
        $sheet->fromArray($headers, null, 'A1');
        if ($rows !== []) {
            $sheet->fromArray($rows, null, 'A2');
        }

        $lastColumn = Coordinate::stringFromColumnIndex(count($headers));
        $lastRow = max(1, count($rows) + 1);
        $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle("A1:{$lastColumn}1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF198754');
        $sheet->freezePane('A2');
        $sheet->setAutoFilter("A1:{$lastColumn}{$lastRow}");
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->getAlignment()->setVertical('top');
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->getAlignment()->setWrapText(true);
        foreach (range(1, count($headers)) as $index) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($index))->setAutoSize(true);
        }
        foreach ($formats as $column => $format) {
            if ($lastRow > 1) {
                $sheet->getStyle("{$column}2:{$column}{$lastRow}")->getNumberFormat()->setFormatCode($format);
            }
        }
    }

    private function safeText(mixed $value): string
    {
        $text = (string) ($value ?? '-');

        return preg_match('/^[=+\-@]/', $text) ? "'{$text}" : $text;
    }
}

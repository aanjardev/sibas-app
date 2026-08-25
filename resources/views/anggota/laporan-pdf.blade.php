<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas - {{ $user->name }}</title>
    <style>
        @page {
            margin: 12mm 15mm 15mm 15mm;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .kop-title {
            font-size: 16px;
            font-weight: bold;
            color: #1b4d3e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .kop-sub {
            font-size: 10px;
            color: #555555;
            line-height: 1.3;
        }
        .divider-double {
            border-top: 2px solid #1b4d3e;
            border-bottom: 1px solid #1b4d3e;
            height: 2px;
            margin-bottom: 12px;
        }

        /* Report Title */
        .report-title-box {
            text-align: center;
            margin-bottom: 14px;
        }
        .report-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            color: #111827;
            margin: 0 0 2px 0;
        }
        .report-periode {
            font-size: 10px;
            color: #4b5563;
            font-weight: 500;
        }

        /* Info Anggota */
        .info-card {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }
        .info-card td {
            padding: 5px 8px;
            font-size: 10.5px;
        }
        .info-label {
            color: #6b7280;
            width: 18%;
        }
        .info-sep {
            width: 2%;
            color: #6b7280;
        }
        .info-val {
            font-weight: bold;
            color: #1f2937;
            width: 30%;
        }

        /* Summary Stats Cards */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .summary-table td {
            width: 33.33%;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: center;
            vertical-align: top;
            background-color: #ffffff;
        }
        .summary-title {
            font-size: 9px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 4px;
            font-weight: 600;
        }
        .summary-value {
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }
        .highlight-green {
            color: #059669;
        }
        .highlight-blue {
            color: #2563eb;
        }

        /* Section Title */
        .section-heading {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1b4d3e;
            border-bottom: 1.5px solid #1b4d3e;
            padding-bottom: 3px;
            margin-top: 14px;
            margin-bottom: 6px;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .data-table th {
            background-color: #f3f4f6;
            color: #374151;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #d1d5db;
            padding: 5px 6px;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #e5e7eb;
            padding: 4.5px 6px;
            font-size: 9.5px;
            color: #374151;
        }
        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .text-bold { font-weight: bold !important; }

        /* Signatures */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .sign-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }

        /* Footer */
        .footer-note {
            margin-top: 20px;
            font-size: 8.5px;
            color: #9ca3af;
            text-align: center;
            border-top: 1px dashed #e5e7eb;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="header-table">
        <tr>
            <td style="width: 100%;">
                <div class="kop-title">SIBAS — SISTEM INFORMASI BANK SAMPAH</div>
                <div class="kop-sub">
                    Unit Pengelolaan Sampah Mandiri & Koperasi Anggota<br>
                    Layanan Tabungan Sampah dan Belanja Koperasi
                </div>
            </td>
        </tr>
    </table>
    <div class="divider-double"></div>

    <!-- Judul Laporan -->
    <div class="report-title-box">
        <h1 class="report-title">Laporan Aktivitas & Rekapitulasi Anggota</h1>
        <div class="report-periode">Periode: {{ $periodeLabel }}</div>
    </div>

    <!-- Informasi Anggota -->
    <table class="info-card">
        <tr>
            <td class="info-label">Nama Anggota</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $user->name }}</td>
            <td class="info-label">Nomor Anggota</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $user->nomor_anggota ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Nomor Telepon</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $user->no_hp ?? '-' }}</td>
            <td class="info-label">Saldo Saat Ini</td>
            <td class="info-sep">:</td>
            <td class="info-val highlight-green">Rp {{ number_format($user->saldo_tabungan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="info-label">Alamat</td>
            <td class="info-sep">:</td>
            <td class="info-val" colspan="4">{{ $user->alamat ?? '-' }}</td>
        </tr>
    </table>

    <!-- Ringkasan Statistik -->
    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-title">Total Sampah Disetor</div>
                <div class="summary-value highlight-green">{{ number_format($totalBeratSampah, 1) }} kg</div>
                <div style="font-size: 8.5px; color: #6b7280; margin-top: 2px;">Cashback: Rp {{ number_format($totalCashbackSampah, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="summary-title">Total Belanja Koperasi</div>
                <div class="summary-value highlight-blue">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</div>
                <div style="font-size: 8.5px; color: #6b7280; margin-top: 2px;">{{ $jumlahTransaksiBelanja }} Transaksi</div>
            </td>
            <td>
                <div class="summary-title">Mutasi Tabungan</div>
                <div class="summary-value">
                    <span style="color: #059669;">+{{ number_format($totalSetorTabungan, 0, ',', '.') }}</span> / 
                    <span style="color: #dc2626;">-{{ number_format($totalTarikTabungan, 0, ',', '.') }}</span>
                </div>
                <div style="font-size: 8.5px; color: #6b7280; margin-top: 2px;">{{ $jumlahTransaksiTabungan }} Transaksi</div>
            </td>
        </tr>
    </table>

    <!-- 1. Riwayat Setor Sampah -->
    <div class="section-heading">1. Riwayat Setor Sampah ({{ $transaksiSampah->count() }} Transaksi)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal</th>
                <th style="width: 35%;">Kategori Sampah</th>
                <th class="text-right" style="width: 15%;">Berat (kg)</th>
                <th class="text-right" style="width: 25%;">Total Cashback</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksiSampah as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->translatedFormat('d/m/Y H:i') }}</td>
                    <td>{{ $item->kategoriSampah->nama_kategori ?? 'Sampah' }}</td>
                    <td class="text-right">{{ number_format($item->berat, 1) }} kg</td>
                    <td class="text-right text-bold" style="color: #059669;">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada transaksi setor sampah pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($transaksiSampah->count() > 0)
        <tfoot>
            <tr style="background-color: #f3f4f6; font-weight: bold;">
                <td colspan="3" class="text-right">TOTAL:</td>
                <td class="text-right">{{ number_format($totalBeratSampah, 1) }} kg</td>
                <td class="text-right" style="color: #059669;">Rp {{ number_format($totalCashbackSampah, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- 2. Riwayat Belanja Koperasi -->
    <div class="section-heading">2. Riwayat Belanja Koperasi ({{ $transaksiBelanja->count() }} Transaksi)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal</th>
                <th style="width: 45%;">Rincian Item</th>
                <th style="width: 15%;">Metode</th>
                <th class="text-right" style="width: 15%;">Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksiBelanja as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->translatedFormat('d/m/Y H:i') }}</td>
                    <td>
                        {{ $item->details->map(fn($d) => ($d->kategoriProduk->nama_produk ?? 'Item') . ' (x' . $d->jumlah . ')')->implode(', ') }}
                    </td>
                    <td>{{ $item->bayar_saldo > 0 ? 'Potong Saldo' : 'Tunai' }}</td>
                    <td class="text-right text-bold" style="color: #2563eb;">Rp {{ number_format($item->total_belanja, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada transaksi belanja pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($transaksiBelanja->count() > 0)
        <tfoot>
            <tr style="background-color: #f3f4f6; font-weight: bold;">
                <td colspan="4" class="text-right">TOTAL BELANJA:</td>
                <td class="text-right" style="color: #2563eb;">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- 3. Riwayat Mutasi Tabungan -->
    <div class="section-heading">3. Riwayat Mutasi Tabungan ({{ $riwayatTabungan->count() }} Transaksi)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal</th>
                <th style="width: 15%;">Jenis Transaksi</th>
                <th style="width: 35%;">Keterangan</th>
                <th class="text-right" style="width: 25%;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayatTabungan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->translatedFormat('d/m/Y H:i') }}</td>
                    <td class="text-bold" style="color: {{ $item->jenis === 'setor' ? '#059669' : '#dc2626' }};">
                        {{ $item->jenis === 'setor' ? 'Setor Tunai' : 'Tarik Tunai' }}
                    </td>
                    <td>{{ $item->keterangan ?: ($item->admin ? 'Diproses Admin ' . $item->admin->name : '-') }}</td>
                    <td class="text-right text-bold" style="color: {{ $item->jenis === 'setor' ? '#059669' : '#dc2626' }};">
                        {{ $item->jenis === 'setor' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada transaksi tabungan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signatures -->
    <table class="sign-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Petugas / Pengelola SIBAS</strong>
                <br><br><br><br>
                ( .................................................. )
            </td>
            <td>
                Dicetak pada {{ $printedAt->translatedFormat('d F Y, H:i') }}<br>
                <strong>Anggota Nasabah</strong>
                <br><br><br><br>
                ( <strong>{{ $user->name }}</strong> )
            </td>
        </tr>
    </table>

    <!-- Footer Note -->
    <div class="footer-note">
        Dokumen ini dibuat otomatis oleh Sistem Informasi Bank Sampah (SIBAS). Tanggal Cetak: {{ $printedAt->translatedFormat('d/m/Y H:i:s') }} WIB.
    </div>

</body>
</html>

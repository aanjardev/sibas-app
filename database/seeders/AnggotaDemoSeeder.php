<?php

namespace Database\Seeders;

use App\Models\DetailTransaksiBelanja;
use App\Models\KategoriProduk;
use App\Models\KategoriSampah;
use App\Models\RiwayatSaldo;
use App\Models\RiwayatTabungan;
use App\Models\TransaksiBelanja;
use App\Models\TransaksiSampah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AnggotaDemoSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Buat User Anggota Demo ────────────────────────────────
        $anggota = User::create([
            'name'           => 'Budi Santoso',
            'email'          => 'demo@sibas.com',
            'password'       => 'password',
            'role'           => 'anggota',
            'nomor_anggota'  => 'AGT-DEMO1',
            'no_hp'          => '081234567890',
            'alamat'         => 'Jl. Melati No. 45, Sukamaju',
            'saldo'          => 1250000,
            'saldo_tabungan' => 750000,
            'is_active'      => true,
        ]);

        // Buat admin dummy (untuk reference di riwayat_tabungan)
        $admin = User::firstOrCreate(
            ['email' => 'admin@sibas.com'],
            [
                'name'           => 'Siti Admin',
                'password'       => 'password',
                'role'           => 'admin',
                'nomor_anggota'  => null,
                'no_hp'          => '089876543210',
                'alamat'         => 'Kantor Bank Sampah',
                'saldo'          => 0,
                'saldo_tabungan' => 0,
                'is_active'      => true,
            ]
        );

        // ── 2. Kategori Sampah ───────────────────────────────────────
        $kategoriSampah = [];
        $dataKategoriSampah = [
            ['nama' => 'Botol Plastik', 'satuan' => 'kg', 'harga_beli' => 3000],
            ['nama' => 'Kardus Bekas',  'satuan' => 'kg', 'harga_beli' => 2500],
            ['nama' => 'Besi/Logam',    'satuan' => 'kg', 'harga_beli' => 4000],
            ['nama' => 'Kertas Campur', 'satuan' => 'kg', 'harga_beli' => 1500],
        ];

        foreach ($dataKategoriSampah as $data) {
            $kategoriSampah[] = KategoriSampah::create($data);
        }

        // ── 3. Kategori Produk ───────────────────────────────────────
        $kategoriProduk = [];
        $dataKategoriProduk = [
            ['nama' => 'Beras Premium 5kg', 'satuan' => 'pcs', 'harga_jual' => 65000, 'stok' => 12],
            ['nama' => 'Minyak Goreng 2L',  'satuan' => 'pcs', 'harga_jual' => 32000, 'stok' => 5],
            ['nama' => 'Gula Pasir 1kg',    'satuan' => 'pcs', 'harga_jual' => 16500, 'stok' => 20],
            ['nama' => 'Kopi Bubuk 165g',   'satuan' => 'pcs', 'harga_jual' => 14000, 'stok' => 8],
            ['nama' => 'Biskuit Malkist',   'satuan' => 'pcs', 'harga_jual' => 12500, 'stok' => 15],
        ];

        foreach ($dataKategoriProduk as $data) {
            $kategoriProduk[] = KategoriProduk::create($data);
        }

        // ── 4. Transaksi Sampah ──────────────────────────────────────
        $now = Carbon::now();

        // Transaksi 1: Botol Plastik — hari ini
        $trxSampah1 = TransaksiSampah::create([
            'user_id'            => $anggota->id,
            'kategori_sampah_id' => $kategoriSampah[0]->id,
            'berat'              => 5,
            'harga_satuan'       => 3000,
            'total'              => 15000,
            'keterangan'         => 'Botol plastik bekas minuman',
            'created_at'         => $now->copy()->subHours(2),
            'updated_at'         => $now->copy()->subHours(2),
        ]);

        // Transaksi 2: Kardus Bekas — 4 hari lalu
        $trxSampah2 = TransaksiSampah::create([
            'user_id'            => $anggota->id,
            'kategori_sampah_id' => $kategoriSampah[1]->id,
            'berat'              => 10,
            'harga_satuan'       => 2500,
            'total'              => 25000,
            'keterangan'         => 'Kardus bekas paket',
            'created_at'         => $now->copy()->subDays(4),
            'updated_at'         => $now->copy()->subDays(4),
        ]);

        // Transaksi 3: Kertas Campur — 10 hari lalu
        $trxSampah3 = TransaksiSampah::create([
            'user_id'            => $anggota->id,
            'kategori_sampah_id' => $kategoriSampah[3]->id,
            'berat'              => 8,
            'harga_satuan'       => 1500,
            'total'              => 12000,
            'keterangan'         => 'Kertas koran dan majalah',
            'created_at'         => $now->copy()->subDays(10),
            'updated_at'         => $now->copy()->subDays(10),
        ]);

        // ── 5. Transaksi Belanja ─────────────────────────────────────

        // Belanja 1: Sembako — 1 hari lalu
        $trxBelanja1 = TransaksiBelanja::create([
            'user_id'       => $anggota->id,
            'total_belanja' => 97000,
            'bayar_saldo'   => 97000,
            'bayar_tunai'   => 0,
            'status'        => 'selesai',
            'keterangan'    => 'Pembelian Sembako',
            'created_at'    => $now->copy()->subDays(1)->setTime(16, 30),
            'updated_at'    => $now->copy()->subDays(1)->setTime(16, 30),
        ]);

        DetailTransaksiBelanja::create([
            'transaksi_belanja_id' => $trxBelanja1->id,
            'kategori_produk_id'   => $kategoriProduk[0]->id, // Beras
            'jumlah'               => 1,
            'harga_satuan'         => 65000,
            'subtotal'             => 65000,
        ]);

        DetailTransaksiBelanja::create([
            'transaksi_belanja_id' => $trxBelanja1->id,
            'kategori_produk_id'   => $kategoriProduk[1]->id, // Minyak
            'jumlah'               => 1,
            'harga_satuan'         => 32000,
            'subtotal'             => 32000,
        ]);

        // Belanja 2: Snack — 8 hari lalu
        $trxBelanja2 = TransaksiBelanja::create([
            'user_id'       => $anggota->id,
            'total_belanja' => 12500,
            'bayar_saldo'   => 12500,
            'bayar_tunai'   => 0,
            'status'        => 'selesai',
            'keterangan'    => 'Pembelian Snack',
            'created_at'    => $now->copy()->subDays(8)->setTime(11, 20),
            'updated_at'    => $now->copy()->subDays(8)->setTime(11, 20),
        ]);

        DetailTransaksiBelanja::create([
            'transaksi_belanja_id' => $trxBelanja2->id,
            'kategori_produk_id'   => $kategoriProduk[4]->id, // Biskuit
            'jumlah'               => 1,
            'harga_satuan'         => 12500,
            'subtotal'             => 12500,
        ]);

        // ── 6. Riwayat Saldo ─────────────────────────────────────────

        // Penukaran sampah 1 (hari ini)
        RiwayatSaldo::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'penukaran_sampah',
            'nominal'       => 15000,
            'saldo_sebelum' => 1235000,
            'saldo_sesudah' => 1250000,
            'reference_id'  => $trxSampah1->id,
            'keterangan'    => 'Botol Plastik (5 kg)',
            'created_at'    => $now->copy()->subHours(2),
            'updated_at'    => $now->copy()->subHours(2),
        ]);

        // Belanja koperasi (kemarin)
        RiwayatSaldo::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'belanja',
            'nominal'       => 97000,
            'saldo_sebelum' => 1332000,
            'saldo_sesudah' => 1235000,
            'reference_id'  => $trxBelanja1->id,
            'keterangan'    => 'Pembelian Sembako',
            'created_at'    => $now->copy()->subDays(1)->setTime(16, 30),
            'updated_at'    => $now->copy()->subDays(1)->setTime(16, 30),
        ]);

        // Penukaran sampah 2 (4 hari lalu)
        RiwayatSaldo::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'penukaran_sampah',
            'nominal'       => 25000,
            'saldo_sebelum' => 1307000,
            'saldo_sesudah' => 1332000,
            'reference_id'  => $trxSampah2->id,
            'keterangan'    => 'Kardus Bekas (10 kg)',
            'created_at'    => $now->copy()->subDays(4),
            'updated_at'    => $now->copy()->subDays(4),
        ]);

        // Belanja snack (8 hari lalu)
        RiwayatSaldo::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'belanja',
            'nominal'       => 12500,
            'saldo_sebelum' => 1319500,
            'saldo_sesudah' => 1307000,
            'reference_id'  => $trxBelanja2->id,
            'keterangan'    => 'Pembelian Snack',
            'created_at'    => $now->copy()->subDays(8)->setTime(11, 20),
            'updated_at'    => $now->copy()->subDays(8)->setTime(11, 20),
        ]);

        // Penukaran sampah 3 (10 hari lalu)
        RiwayatSaldo::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'penukaran_sampah',
            'nominal'       => 12000,
            'saldo_sebelum' => 1307500,
            'saldo_sesudah' => 1319500,
            'reference_id'  => $trxSampah3->id,
            'keterangan'    => 'Kertas Campur (8 kg)',
            'created_at'    => $now->copy()->subDays(10),
            'updated_at'    => $now->copy()->subDays(10),
        ]);

        // Deposit tunai (15 hari lalu)
        RiwayatSaldo::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'deposit',
            'nominal'       => 50000,
            'saldo_sebelum' => 1257500,
            'saldo_sesudah' => 1307500,
            'reference_id'  => null,
            'keterangan'    => 'Setor tunai melalui Admin',
            'created_at'    => $now->copy()->subDays(15),
            'updated_at'    => $now->copy()->subDays(15),
        ]);

        // ── 7. Riwayat Tabungan ──────────────────────────────────────

        // Setor tunai — 2 hari lalu
        RiwayatTabungan::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'setor',
            'nominal'       => 50000,
            'saldo_sebelum' => 700000,
            'saldo_sesudah' => 750000,
            'keterangan'    => 'Setor rutin mingguan',
            'admin_id'      => $admin->id,
            'created_at'    => $now->copy()->subDays(2)->setTime(10, 0),
            'updated_at'    => $now->copy()->subDays(2)->setTime(10, 0),
        ]);

        // Setor tunai — 7 hari lalu
        RiwayatTabungan::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'setor',
            'nominal'       => 25000,
            'saldo_sebelum' => 675000,
            'saldo_sesudah' => 700000,
            'keterangan'    => 'Setor sisa belanja',
            'admin_id'      => $admin->id,
            'created_at'    => $now->copy()->subDays(7)->setTime(14, 30),
            'updated_at'    => $now->copy()->subDays(7)->setTime(14, 30),
        ]);

        // Tarik tunai — 12 hari lalu
        RiwayatTabungan::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'tarik',
            'nominal'       => 100000,
            'saldo_sebelum' => 775000,
            'saldo_sesudah' => 675000,
            'keterangan'    => 'Kebutuhan mendadak',
            'admin_id'      => $admin->id,
            'created_at'    => $now->copy()->subDays(12)->setTime(9, 15),
            'updated_at'    => $now->copy()->subDays(12)->setTime(9, 15),
        ]);

        // Setor tunai — 20 hari lalu
        RiwayatTabungan::create([
            'user_id'       => $anggota->id,
            'jenis'         => 'setor',
            'nominal'       => 200000,
            'saldo_sebelum' => 575000,
            'saldo_sesudah' => 775000,
            'keterangan'    => 'Setor bulanan',
            'admin_id'      => $admin->id,
            'created_at'    => $now->copy()->subDays(20)->setTime(8, 0),
            'updated_at'    => $now->copy()->subDays(20)->setTime(8, 0),
        ]);
    }
}

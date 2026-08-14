<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksiBelanja;
use App\Models\KategoriProduk;
use App\Models\RiwayatSaldo;
use App\Models\TransaksiBelanja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBelanjaController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiBelanja::with(['user', 'details.kategoriProduk']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('nomor_anggota', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $transaksiList = $query->latest()->paginate(15)->withQueryString();

        // Summary
        $today = Carbon::today();
        $transaksiHariIni = TransaksiBelanja::whereDate('created_at', $today)->where('status', 'selesai')->count();
        $pendapatanHariIni = TransaksiBelanja::whereDate('created_at', $today)->where('status', 'selesai')->sum('total_belanja');
        $bayarSaldoHariIni = TransaksiBelanja::whereDate('created_at', $today)->where('status', 'selesai')->sum('bayar_saldo');
        $bayarTunaiHariIni = TransaksiBelanja::whereDate('created_at', $today)->where('status', 'selesai')->sum('bayar_tunai');

        return view('admin.belanja-koperasi.index', compact(
            'transaksiList', 'transaksiHariIni', 'pendapatanHariIni', 'bayarSaldoHariIni', 'bayarTunaiHariIni'
        ));
    }

    public function pos()
    {
        $produkList = KategoriProduk::where('is_active', true)->where('stok', '>', 0)->get();
        return view('admin.belanja-koperasi.pos', compact('produkList'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'metode_bayar'      => 'required|in:saldo,tunai,campuran',
            'bayar_tunai'       => 'nullable|numeric|min:0',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:kategori_produk,id',
            'items.*.jumlah'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::findOrFail($validated['user_id']);
            $totalBelanja = 0;
            $detailItems = [];

            // Calculate totals & validate stock
            foreach ($validated['items'] as $item) {
                $produk = KategoriProduk::findOrFail($item['produk_id']);
                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$produk->nama} tidak mencukupi (tersedia: {$produk->stok}).");
                }
                $subtotal = $produk->harga_jual * $item['jumlah'];
                $totalBelanja += $subtotal;
                $detailItems[] = [
                    'produk'      => $produk,
                    'jumlah'      => $item['jumlah'],
                    'harga_satuan'=> $produk->harga_jual,
                    'subtotal'    => $subtotal,
                ];
            }

            // Payment logic
            $bayarSaldo = 0;
            $bayarTunai = 0;

            if ($validated['metode_bayar'] === 'saldo') {
                if ($user->saldo < $totalBelanja) {
                    throw new \Exception('Saldo anggota tidak mencukupi.');
                }
                $bayarSaldo = $totalBelanja;
            } elseif ($validated['metode_bayar'] === 'tunai') {
                $bayarTunai = $totalBelanja;
            } else { // campuran
                $bayarTunai = $validated['bayar_tunai'] ?? 0;
                $bayarSaldo = $totalBelanja - $bayarTunai;
                if ($user->saldo < $bayarSaldo) {
                    throw new \Exception('Saldo anggota tidak mencukupi untuk pembayaran campuran.');
                }
            }

            // Create transaction
            $transaksi = TransaksiBelanja::create([
                'user_id'       => $user->id,
                'total_belanja' => $totalBelanja,
                'bayar_saldo'   => $bayarSaldo,
                'bayar_tunai'   => $bayarTunai,
                'status'        => 'selesai',
                'keterangan'    => 'Pembelian koperasi (' . count($detailItems) . ' item)',
            ]);

            // Create details & reduce stock
            foreach ($detailItems as $detail) {
                DetailTransaksiBelanja::create([
                    'transaksi_belanja_id' => $transaksi->id,
                    'kategori_produk_id'   => $detail['produk']->id,
                    'jumlah'               => $detail['jumlah'],
                    'harga_satuan'         => $detail['harga_satuan'],
                    'subtotal'             => $detail['subtotal'],
                ]);

                // Reduce stock
                $detail['produk']->decrement('stok', $detail['jumlah']);
            }

            // Deduct saldo if paying with saldo
            if ($bayarSaldo > 0) {
                $saldoSebelum = $user->saldo;
                $user->decrement('saldo', $bayarSaldo);

                RiwayatSaldo::create([
                    'user_id'       => $user->id,
                    'jenis'         => 'belanja',
                    'nominal'       => $bayarSaldo,
                    'saldo_sebelum' => $saldoSebelum,
                    'saldo_sesudah' => $saldoSebelum - $bayarSaldo,
                    'reference_id'  => $transaksi->id,
                    'keterangan'    => 'Pembelian koperasi',
                ]);
            }
        });

        return redirect()->route('admin.belanja-koperasi.index')->with('success', 'Transaksi belanja berhasil disimpan!');
    }

    public function show($id)
    {
        $transaksi = TransaksiBelanja::with(['user', 'details.kategoriProduk'])->findOrFail($id);
        return view('admin.belanja-koperasi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = TransaksiBelanja::with(['user', 'details.kategoriProduk'])->findOrFail($id);
        return view('admin.belanja-koperasi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiBelanja::findOrFail($id);

        $validated = $request->validate([
            'status'     => 'required|in:pending,selesai,batal',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // If cancelling, rollback saldo & stok
        if ($validated['status'] === 'batal' && $transaksi->status !== 'batal') {
            DB::transaction(function () use ($transaksi) {
                $user = User::findOrFail($transaksi->user_id);

                // Restore saldo
                if ($transaksi->bayar_saldo > 0) {
                    $user->increment('saldo', $transaksi->bayar_saldo);
                }

                // Restore stok
                foreach ($transaksi->details as $detail) {
                    KategoriProduk::where('id', $detail->kategori_produk_id)
                        ->increment('stok', $detail->jumlah);
                }
            });
        }

        $transaksi->update($validated);

        return redirect()->route('admin.belanja-koperasi.show', $id)->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiBelanja::with('details')->findOrFail($id);

        DB::transaction(function () use ($transaksi) {
            $user = User::findOrFail($transaksi->user_id);

            // Restore saldo if paid with saldo
            if ($transaksi->bayar_saldo > 0 && $transaksi->status === 'selesai') {
                $user->increment('saldo', $transaksi->bayar_saldo);
            }

            // Restore stok if completed
            if ($transaksi->status === 'selesai') {
                foreach ($transaksi->details as $detail) {
                    KategoriProduk::where('id', $detail->kategori_produk_id)
                        ->increment('stok', $detail->jumlah);
                }
            }

            $transaksi->delete();
        });

        return redirect()->route('admin.belanja-koperasi.index')->with('success', 'Transaksi belanja berhasil dihapus.');
    }
}

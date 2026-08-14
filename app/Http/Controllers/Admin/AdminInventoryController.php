<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriProduk::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($stokFilter = $request->input('stok_filter')) {
            if ($stokFilter === 'aman') {
                $query->where('stok', '>', 5);
            } elseif ($stokFilter === 'menipis') {
                $query->whereBetween('stok', [1, 5]);
            } elseif ($stokFilter === 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        $produkList = $query->latest()->paginate(15)->withQueryString();

        // Summary
        $totalProduk    = KategoriProduk::count();
        $produkMenipis  = KategoriProduk::whereBetween('stok', [1, 5])->count();
        $nilaiInventaris = KategoriProduk::selectRaw('SUM(harga_jual * stok) as total')->value('total') ?? 0;

        return view('admin.inventory.index', compact('produkList', 'totalProduk', 'produkMenipis', 'nilaiInventaris'));
    }

    public function create()
    {
        // Auto-generate SKU
        $lastProduk = KategoriProduk::orderBy('id', 'desc')->first();
        $nextNumber = $lastProduk ? $lastProduk->id + 1 : 1;
        $sku = 'PRD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('admin.inventory.create', compact('sku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'satuan'     => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0',
            'stok'       => 'required|numeric|min:0',
            'is_active'  => 'required|boolean',
            'foto'       => 'nullable|image|max:2048',
        ]);

        KategoriProduk::create([
            'nama'       => $validated['nama'],
            'satuan'     => $validated['satuan'],
            'harga_jual' => $validated['harga_jual'],
            'stok'       => $validated['stok'],
            'is_active'  => $validated['is_active'],
        ]);

        return redirect()->route('admin.inventory.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = KategoriProduk::findOrFail($id);
        $sku = 'PRD-' . str_pad($produk->id, 4, '0', STR_PAD_LEFT);

        return view('admin.inventory.edit', compact('produk', 'sku'));
    }

    public function update(Request $request, $id)
    {
        $produk = KategoriProduk::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'satuan'     => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0',
            'stok'       => 'required|numeric|min:0',
            'is_active'  => 'required|boolean',
            'foto'       => 'nullable|image|max:2048',
        ]);

        $produk->update([
            'nama'       => $validated['nama'],
            'satuan'     => $validated['satuan'],
            'harga_jual' => $validated['harga_jual'],
            'stok'       => $validated['stok'],
            'is_active'  => $validated['is_active'],
        ]);

        return redirect()->route('admin.inventory.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = KategoriProduk::findOrFail($id);

        if ($produk->detailTransaksiBelanja()->exists()) {
            return redirect()->route('admin.inventory.index')
                ->with('error', 'Tidak bisa menghapus produk yang sudah memiliki riwayat transaksi belanja.');
        }

        $produk->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function restock(Request $request, $id)
    {
        $produk = KategoriProduk::findOrFail($id);

        $validated = $request->validate([
            'stok_tambahan' => 'required|integer|min:1',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        $produk->increment('stok', $validated['stok_tambahan']);

        return redirect()->route('admin.inventory.index')->with('success', "Stok {$produk->nama} berhasil ditambahkan sebanyak {$validated['stok_tambahan']}.");
    }
}

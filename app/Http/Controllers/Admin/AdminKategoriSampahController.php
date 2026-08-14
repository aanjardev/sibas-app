<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class AdminKategoriSampahController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriSampah::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $kategoriList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.kategori-sampah.index', compact('kategoriList'));
    }

    public function create()
    {
        // Auto-generate kode
        $lastKategori = KategoriSampah::orderBy('id', 'desc')->first();
        $nextNumber = $lastKategori ? $lastKategori->id + 1 : 1;
        $kode = 'SMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.kategori-sampah.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'is_active'  => 'required|boolean',
            'deskripsi'  => 'nullable|string',
        ]);

        KategoriSampah::create([
            'nama'       => $validated['nama'],
            'satuan'     => 'kg',
            'harga_beli' => $validated['harga_beli'],
            'is_active'  => $validated['is_active'],
        ]);

        return redirect()->route('admin.kategori-sampah.index')->with('success', 'Jenis sampah baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = KategoriSampah::findOrFail($id);
        $kode = 'SMP-' . str_pad($kategori->id, 3, '0', STR_PAD_LEFT);

        return view('admin.kategori-sampah.edit', compact('kategori', 'kode'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriSampah::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'is_active'  => 'required|boolean',
            'deskripsi'  => 'nullable|string',
        ]);

        $kategori->update([
            'nama'       => $validated['nama'],
            'harga_beli' => $validated['harga_beli'],
            'is_active'  => $validated['is_active'],
        ]);

        return redirect()->route('admin.kategori-sampah.index')->with('success', 'Data jenis sampah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriSampah::findOrFail($id);

        // Check if kategori has transactions
        if ($kategori->transaksiSampah()->exists()) {
            return redirect()->route('admin.kategori-sampah.index')
                ->with('error', 'Tidak bisa menghapus jenis sampah yang sudah memiliki riwayat transaksi.');
        }

        $kategori->delete();
        return redirect()->route('admin.kategori-sampah.index')->with('success', 'Jenis sampah berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use App\Models\RiwayatSaldo;
use App\Models\TransaksiSampah;
use App\Models\User;
use App\Notifications\TransaksiBaruNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSetorSampahController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiSampah::with(['user', 'kategoriSampah']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('nomor_anggota', 'like', "%{$search}%"));
            });
        }

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori_sampah_id', $kategori);
        }

        $transaksiList = $query->latest()->paginate(15)->withQueryString();
        $kategoriOptions = KategoriSampah::where('is_active', true)->get();

        return view('admin.setor-sampah.index', compact('transaksiList', 'kategoriOptions'));
    }

    public function create()
    {
        $kategoriList = KategoriSampah::where('is_active', true)->get();
        return view('admin.setor-sampah.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'              => 'required|exists:users,id',
            'tanggal'              => 'required|date',
            'items'                => 'required|array|min:1',
            'items.*.kategori_id'  => 'required|exists:kategori_sampah,id',
            'items.*.berat'        => 'required|numeric|min:0.1',
        ]);

        $totalNilai = 0;

        DB::transaction(function () use ($validated, &$totalNilai) {
            $user = User::findOrFail($validated['user_id']);

            foreach ($validated['items'] as $item) {
                $kategori = KategoriSampah::findOrFail($item['kategori_id']);
                $subtotal = $kategori->harga_beli * $item['berat'];
                $totalNilai += $subtotal;

                TransaksiSampah::create([
                    'user_id'            => $user->id,
                    'kategori_sampah_id' => $kategori->id,
                    'berat'              => $item['berat'],
                    'harga_satuan'       => $kategori->harga_beli,
                    'total'              => $subtotal,
                    'keterangan'         => $kategori->nama . ' (' . $item['berat'] . ' kg)',
                    'created_at'         => $validated['tanggal'],
                    'updated_at'         => $validated['tanggal'],
                ]);
            }

            // Update saldo user
            $saldoSebelum = $user->saldo;
            $user->increment('saldo', $totalNilai);

            // Catat riwayat saldo
            RiwayatSaldo::create([
                'user_id'       => $user->id,
                'jenis'         => 'penukaran_sampah',
                'nominal'       => $totalNilai,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSebelum + $totalNilai,
                'keterangan'    => 'Setor sampah (' . count($validated['items']) . ' item)',
                'created_at'    => $validated['tanggal'],
                'updated_at'    => $validated['tanggal'],
            ]);
        });

        $user = User::find($validated['user_id']);
        if ($user && $totalNilai > 0) {
            $judul = 'Setoran Sampah Berhasil';
            $pesan = 'Setoran sampah Anda sebanyak ' . count($validated['items']) . ' item senilai Rp ' . number_format($totalNilai, 0, ',', '.') . ' telah ditambahkan ke saldo utama.';
            $user->notify(new TransaksiBaruNotification($judul, $pesan, 'setor_sampah'));
        }

        return redirect()->route('admin.setor-sampah.index')->with('success', 'Transaksi setor sampah berhasil disimpan!');
    }

    public function edit($id)
    {
        $transaksi = TransaksiSampah::with(['user', 'kategoriSampah'])->findOrFail($id);
        $kategoriList = KategoriSampah::where('is_active', true)->get();

        // Get all transaksi with same user and same created_at (grouped transaction)
        $relatedItems = TransaksiSampah::with('kategoriSampah')
            ->where('user_id', $transaksi->user_id)
            ->where('created_at', $transaksi->created_at)
            ->get();

        return view('admin.setor-sampah.edit', compact('transaksi', 'kategoriList', 'relatedItems'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiSampah::findOrFail($id);

        $validated = $request->validate([
            'tanggal'              => 'required|date',
            'items'                => 'required|array|min:1',
            'items.*.kategori_id'  => 'required|exists:kategori_sampah,id',
            'items.*.berat'        => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($transaksi, $validated) {
            $user = User::findOrFail($transaksi->user_id);

            // Rollback old saldo: remove the old total from saldo
            $oldRelated = TransaksiSampah::where('user_id', $transaksi->user_id)
                ->where('created_at', $transaksi->created_at)
                ->get();
            $oldTotal = $oldRelated->sum('total');
            $user->decrement('saldo', $oldTotal);

            // Delete old related transactions
            TransaksiSampah::where('user_id', $transaksi->user_id)
                ->where('created_at', $transaksi->created_at)
                ->delete();

            // Create new items
            $newTotal = 0;
            foreach ($validated['items'] as $item) {
                $kategori = KategoriSampah::findOrFail($item['kategori_id']);
                $subtotal = $kategori->harga_beli * $item['berat'];
                $newTotal += $subtotal;

                TransaksiSampah::create([
                    'user_id'            => $user->id,
                    'kategori_sampah_id' => $kategori->id,
                    'berat'              => $item['berat'],
                    'harga_satuan'       => $kategori->harga_beli,
                    'total'              => $subtotal,
                    'keterangan'         => $kategori->nama . ' (' . $item['berat'] . ' kg)',
                    'created_at'         => $validated['tanggal'],
                    'updated_at'         => $validated['tanggal'],
                ]);
            }

            // Re-add new total to saldo
            $user->increment('saldo', $newTotal);
        });

        return redirect()->route('admin.setor-sampah.index')->with('success', 'Transaksi setor sampah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiSampah::findOrFail($id);

        DB::transaction(function () use ($transaksi) {
            $user = User::findOrFail($transaksi->user_id);

            // Rollback saldo
            $user->decrement('saldo', $transaksi->total);

            $transaksi->delete();
        });

        return redirect()->route('admin.setor-sampah.index')->with('success', 'Transaksi setor sampah berhasil dihapus.');
    }

    /**
     * API search anggota (JSON) for live search
     */
    public function searchAnggota(Request $request)
    {
        $search = $request->input('q', '');
        $results = User::where('role', 'anggota')
            ->where('is_active', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nomor_anggota', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            })
            ->take(10)
            ->get(['id', 'name', 'nomor_anggota', 'no_hp', 'saldo', 'saldo_tabungan']);

        return response()->json($results);
    }
}

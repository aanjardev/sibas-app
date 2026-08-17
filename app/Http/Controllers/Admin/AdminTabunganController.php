<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatTabungan;
use App\Models\User;
use App\Notifications\TransaksiBaruNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminTabunganController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatTabungan::with(['user', 'admin']);

        if ($search = $request->input('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('nomor_anggota', 'like', "%{$search}%"));
        }

        if ($jenis = $request->input('jenis')) {
            $query->where('jenis', $jenis);
        }

        $transaksiList = $query->latest()->paginate(15)->withQueryString();

        // Summary stats
        $today = Carbon::today();
        $totalTabungan     = User::where('role', 'anggota')->sum('saldo_tabungan');
        $setorHariIni      = RiwayatTabungan::where('jenis', 'setor')->whereDate('created_at', $today)->sum('nominal');
        $tarikHariIni      = RiwayatTabungan::where('jenis', 'tarik')->whereDate('created_at', $today)->sum('nominal');

        return view('admin.tabungan.index', compact('transaksiList', 'totalTabungan', 'setorHariIni', 'tarikHariIni'));
    }

    public function create()
    {
        return view('admin.tabungan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'jenis_transaksi'  => 'required|in:setor,tarik',
            'nominal'          => 'required|numeric|min:1000',
            'keterangan'       => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::findOrFail($validated['user_id']);
            $jenis = $validated['jenis_transaksi'];
            $nominal = $validated['nominal'];

            // Validate sufficient balance for tarik
            if ($jenis === 'tarik' && $user->saldo_tabungan < $nominal) {
                throw new \Exception('Saldo tabungan tidak mencukupi untuk penarikan.');
            }

            $saldoSebelum = $user->saldo_tabungan;

            if ($jenis === 'setor') {
                $user->increment('saldo_tabungan', $nominal);
                $saldoSesudah = $saldoSebelum + $nominal;
            } else {
                $user->decrement('saldo_tabungan', $nominal);
                $saldoSesudah = $saldoSebelum - $nominal;
            }

            RiwayatTabungan::create([
                'user_id'       => $user->id,
                'jenis'         => $jenis,
                'nominal'       => $nominal,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'keterangan'    => $validated['keterangan'] ?? ($jenis === 'setor' ? 'Setor tunai' : 'Tarik tunai'),
                'admin_id'      => Auth::id(),
            ]);
        });

        $user = User::find($validated['user_id']);
        if ($user) {
            $judul = $validated['jenis_transaksi'] === 'setor' ? 'Setoran Tabungan' : 'Penarikan Tabungan';
            $pesan = ($validated['jenis_transaksi'] === 'setor' ? 'Setoran' : 'Penarikan') . ' tabungan Anda sebesar Rp ' . number_format($validated['nominal'], 0, ',', '.') . ' berhasil diproses.';
            $user->notify(new TransaksiBaruNotification($judul, $pesan, 'tabungan'));
        }

        return redirect()->route('admin.tabungan.index')->with('success', 'Transaksi tabungan berhasil disimpan!');
    }

    public function edit($id)
    {
        $transaksi = RiwayatTabungan::with('user')->findOrFail($id);
        return view('admin.tabungan.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = RiwayatTabungan::findOrFail($id);

        $validated = $request->validate([
            'nominal'    => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($transaksi, $validated) {
            $user = User::findOrFail($transaksi->user_id);

            // Rollback old transaction
            if ($transaksi->jenis === 'setor') {
                $user->decrement('saldo_tabungan', $transaksi->nominal);
            } else {
                $user->increment('saldo_tabungan', $transaksi->nominal);
            }

            // Apply new nominal
            $saldoSebelum = $user->fresh()->saldo_tabungan;
            if ($transaksi->jenis === 'setor') {
                $user->increment('saldo_tabungan', $validated['nominal']);
                $saldoSesudah = $saldoSebelum + $validated['nominal'];
            } else {
                $user->decrement('saldo_tabungan', $validated['nominal']);
                $saldoSesudah = $saldoSebelum - $validated['nominal'];
            }

            $transaksi->update([
                'nominal'       => $validated['nominal'],
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'keterangan'    => $validated['keterangan'] ?? $transaksi->keterangan,
            ]);
        });

        return redirect()->route('admin.tabungan.index')->with('success', 'Transaksi tabungan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = RiwayatTabungan::find($id);

        if (!$transaksi) {
            return redirect()->route('admin.tabungan.index')->with('error', 'Data tabungan tidak ditemukan atau sudah dihapus.');
        }

        DB::transaction(function () use ($transaksi) {
            $user = User::find($transaksi->user_id);

            if ($user) {
                // Rollback saldo
                if ($transaksi->jenis === 'setor') {
                    $user->decrement('saldo_tabungan', $transaksi->nominal);
                } else {
                    $user->increment('saldo_tabungan', $transaksi->nominal);
                }
            }

            $transaksi->delete();
        });

        return redirect()->route('admin.tabungan.index')->with('success', 'Transaksi tabungan berhasil dihapus.');
    }
}

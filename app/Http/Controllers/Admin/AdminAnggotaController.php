<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TransaksiSampah;
use App\Models\TransaksiBelanja;
use App\Models\RiwayatTabungan;
use Illuminate\Http\Request;

class AdminAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nomor_anggota', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->input('status') === 'aktif') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'nonaktif') {
            $query->where('is_active', false);
        }

        $anggotaList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.anggota.index', compact('anggotaList'));
    }

    public function create()
    {
        // Auto-generate nomor anggota
        $lastAnggota = User::where('role', 'anggota')
            ->whereNotNull('nomor_anggota')
            ->orderByRaw("CAST(SUBSTRING(nomor_anggota, 5) AS UNSIGNED) DESC")
            ->first();

        $nextNumber = 1;
        if ($lastAnggota && preg_match('/AGT-(\d+)/', $lastAnggota->nomor_anggota, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }
        $nomorAnggota = 'AGT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.anggota.create', compact('nomorAnggota'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|unique:users,email',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Auto-generate nomor anggota
        $lastAnggota = User::where('role', 'anggota')
            ->whereNotNull('nomor_anggota')
            ->orderByRaw("CAST(SUBSTRING(nomor_anggota, 5) AS UNSIGNED) DESC")
            ->first();

        $nextNumber = 1;
        if ($lastAnggota && preg_match('/AGT-(\d+)/', $lastAnggota->nomor_anggota, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'no_hp'         => $validated['no_hp'],
            'alamat'        => $validated['alamat'],
            'password'      => $validated['password'],
            'role'          => 'anggota',
            'nomor_anggota' => 'AGT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT),
            'saldo'         => 0,
            'saldo_tabungan'=> 0,
            'is_active'     => true,
        ]);

        $user->notify(new \App\Notifications\WelcomeNotification());

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);

        $riwayatTabungan = RiwayatTabungan::with('admin')
            ->where('user_id', $id)
            ->latest()
            ->take(20)
            ->get();

        $riwayatSampah = TransaksiSampah::with('kategoriSampah')
            ->where('user_id', $id)
            ->latest()
            ->take(20)
            ->get();

        $riwayatBelanja = TransaksiBelanja::with('details.kategoriProduk')
            ->where('user_id', $id)
            ->latest()
            ->take(20)
            ->get();

        return view('admin.anggota.show', compact('anggota', 'riwayatTabungan', 'riwayatSampah', 'riwayatBelanja'));
    }

    public function edit($id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|unique:users,email,' . $id,
            'no_hp'     => 'required|string|max:20',
            'alamat'    => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $anggota->update($validated);

        // Optional password change
        if ($request->filled('new_password')) {
            $request->validate([
                'new_password' => 'string|min:8|confirmed',
            ]);
            $anggota->update(['password' => $request->input('new_password')]);
        }

        return redirect()->route('admin.anggota.show', $id)->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        $anggota->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}

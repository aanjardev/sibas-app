<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\RiwayatSaldo;
use App\Models\TransaksiSampah;
use App\Models\TransaksiBelanja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->startOfMonth();

        $totalAnggota = User::where('role', 'anggota')->count();

        $sampahMasukBulanIni = TransaksiSampah::where('created_at', '>=', $bulanIni)->sum('berat');

        $penjualanKoperasiBulanIni = TransaksiBelanja::where('created_at', '>=', $bulanIni)
            ->where('status', 'selesai')
            ->sum('total_belanja');

        $totalSaldoTabungan = User::where('role', 'anggota')->sum('saldo_tabungan');

        $aktivitasTerbaru = RiwayatSaldo::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalAnggota',
            'sampahMasukBulanIni',
            'penjualanKoperasiBulanIni',
            'totalSaldoTabungan',
            'aktivitasTerbaru'
        ));
    }

    public function profil()
    {
        $admin = auth()->user();
        return view('admin.profil', compact('admin'));
    }

    public function updateProfil(Request $request)
    {
        $admin = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'string', 'min:8', 'max:50', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 50 karakter.',
            'current_password.required_with' => 'Password lama wajib diisi jika ingin mengubah password.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.max' => 'Password baru maksimal 50 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check current password if user is trying to change password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
            }
            $admin->password = Hash::make($request->password);
        }

        $admin->name = $request->name;
        $admin->save();

        return redirect()->route('admin.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}

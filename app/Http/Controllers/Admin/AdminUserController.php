<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($request->input('status') === 'aktif') {
            $query->whereNotNull('password');
        } elseif ($request->input('status') === 'belum_aktif') {
            $query->whereNull('password');
        }

        $adminList = $query->latest()->paginate(15)->withQueryString();

        return view('admin.kelola-admin.index', compact('adminList'));
    }

    public function create()
    {
        return view('admin.kelola-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah terdaftar di sistem.',
        ]);

        User::create([
            'name'      => explode('@', $validated['email'])[0],
            'email'     => strtolower(trim($validated['email'])),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Undangan admin baru berhasil dibuat! Admin tersebut dapat mengaktifkan akunnya melalui halaman registrasi admin.');
    }

    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // Prevent self-deletion
        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.kelola-admin.index')
                ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }

    public function resetPassword($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.kelola-admin.index')
                ->with('error', 'Untuk mengubah password Anda sendiri, silakan gunakan menu Profil.');
        }

        // Reset password to null so admin must re-register
        $admin->update(['password' => null]);

        return redirect()->route('admin.kelola-admin.index')
            ->with('success', "Password {$admin->name} berhasil di-reset. Admin tersebut perlu melakukan registrasi ulang.");
    }
}

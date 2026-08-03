<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // ─── Login ───────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ─── Register ────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp'    => ['required', 'string', 'max:20'],
            'alamat'   => ['required', 'string', 'max:500'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar, silakan gunakan email lain.',
            'no_hp.required'     => 'Nomor HP wajib diisi.',
            'alamat.required'    => 'Alamat wajib diisi.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                // password tetap ada, password_confirmation di-clear
                ->withInput($request->except('password_confirmation'));
        }

        $validated = $validator->validated();

        // Generate nomor anggota unik: AGT-XXXXX
        $nomorAnggota = 'AGT-' . strtoupper(substr(md5(uniqid()), 0, 5));
        while (User::where('nomor_anggota', $nomorAnggota)->exists()) {
            $nomorAnggota = 'AGT-' . strtoupper(substr(md5(uniqid()), 0, 5));
        }

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'no_hp'         => $validated['no_hp'],
            'alamat'        => $validated['alamat'],
            'password'      => $validated['password'],
            'role'          => 'anggota',
            'nomor_anggota' => $nomorAnggota,
            'saldo'         => 0,
            'is_active'     => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    // ─── Logout ──────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

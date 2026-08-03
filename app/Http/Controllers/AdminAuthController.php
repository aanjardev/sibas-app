<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
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

        // Cari user yang ber-role admin
        $user = User::where('email', $credentials['email'])->where('role', 'admin')->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar sebagai Admin.'])->onlyInput('email');
        }

        if (is_null($user->password)) {
            return back()->withErrors(['email' => 'Akun Anda belum diaktivasi. Silakan lakukan registrasi dahulu.'])->onlyInput('email');
        }

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'admin'], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function checkInvitation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid. Gunakan format seperti nama@contoh.com.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->where('role', 'admin')->first();

        if (!$user) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Email belum didaftarkan oleh Administrator. Silakan hubungi Administrator.',
            ]);
        }

        if (!is_null($user->password)) {
            return response()->json([
                'status'  => 'already_registered',
                'message' => 'Akun dengan email ini sudah aktif. Silakan login ke sistem.',
                'redirect_url' => route('admin.login'),
            ]);
        }

        return response()->json([
            'status'  => 'valid',
            'message' => 'Email terdaftar dalam undangan. Silakan lanjutkan data diri.',
            'data'    => [
                'email' => $user->email,
                'name'  => $user->name ?? '',
                'no_hp' => $user->no_hp ?? '',
                'alamat'=> $user->alamat ?? '',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'email'],
            'name'     => ['required', 'string', 'max:255'],
            'no_hp'    => ['required', 'string', 'max:20'],
            'alamat'   => ['required', 'string', 'max:500'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'no_hp.required'     => 'Nomor HP wajib diisi.',
            'alamat.required'    => 'Alamat wajib diisi.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password_confirmation'));
        }

        $user = User::where('email', strtolower(trim($request->email)))->where('role', 'admin')->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak valid atau tidak terdaftar.']);
        }

        if (!is_null($user->password)) {
            return redirect()->route('admin.login')->with('error', 'Akun sudah terdaftar sebelumnya.');
        }

        $user->update([
            'name'      => $request->name,
            'no_hp'     => $request->no_hp,
            'alamat'    => $request->alamat,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

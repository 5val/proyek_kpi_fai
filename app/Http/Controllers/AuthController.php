<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // pastikan view login.blade.php di resources/views/
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Login manual (gunakan Auth::login)
            Auth::login($user);
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('status', 'Selamat datang, Admin!');
                case 'dosen':
                    return redirect()->route('dosen.dashboard')->with('status', 'Selamat datang, Dosen!');
                case 'mahasiswa':
                    return redirect()->route('mahasiswa.dashboard')->with('status', 'Selamat datang, Mahasiswa!');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['role' => 'Role pengguna tidak dikenal.']);
            }
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah logout.');
    }
}

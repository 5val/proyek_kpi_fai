<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Proses login pengguna
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate(); // Hindari session fixation

            // Redirect sesuai role
            return match ($user->role) {
                'admin'     => redirect()->route('admin.dashboard')->with('status', 'Selamat datang, Admin!'),
                'dosen'     => redirect()->route('dosen.dashboard')->with('status', 'Selamat datang, Dosen!'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard')->with('status', 'Selamat datang, Mahasiswa!'),
                default     => tap(Auth::logout(), fn() => session()->invalidate()) 
                                ?? redirect()->route('login')->withErrors(['role' => 'Role tidak dikenali.']),
            };
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah logout.');
    }
}

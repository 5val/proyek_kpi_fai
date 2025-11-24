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
      $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect("/");
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function redirectPathFor()
    {
        if(Auth::check()) {
           if (Auth::user()->role == 'admin') {
               return redirect()->route('admin.dashboard');
           } elseif (Auth::user()->role == 'dosen') {
               return redirect()->route('dosen.dashboard');
           } elseif (Auth::user()->role == 'mahasiswa') {
               return redirect()->route('mahasiswa.dashboard');
           }
        }
        return redirect('/login'); 
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

    public function redirectProfiles() {
      if(Auth::check()) {
           if (Auth::user()->role == 'admin') {
               return redirect()->route('admin.profile');
           } elseif (Auth::user()->role == 'dosen') {
               return redirect()->route('dosen.profile');
           } elseif (Auth::user()->role == 'mahasiswa') {
               return redirect()->route('mahasiswa.profile');
           }
        }
        return back(); 
    }
}

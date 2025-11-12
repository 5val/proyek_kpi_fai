<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Enrollment;
use App\Models\Fasilitas;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Periode;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;


class DosenController extends Controller
{
    public function dashboard() {
    return view('dosen.dashboard');
    }

    // PROFILE 

    public function profile()
    {
        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();

        return view('dosen.profile', [
            'user' => $user,
            'dosen' => $dosen,
        ]);
    }
    
     public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,'. $user->id,
            'phone' => 'required|string|max:13|unique:users,phone_number,'. $user->id,
        ]);

        $user->update([
            'email' => $request->email,
            'phone_number' => $request->phone,
        ]);

        return redirect()->route('dosen.profile')->with('success', 'Profil berhasil diperbarui.');
    }   
    
    public function changePassword(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama yang Anda masukkan salah.');
        }
    
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return back()->with('success', 'Password berhasil diubah.');
    }

    // KPI SAYA
    
    public function kpi()
    {

        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();
        
        return view('dosen.kpi', [
            'user' => $user,
            'dosen' => $dosen,
        ]);
    }

    // KELAS 
    public function uploadProfpic(Request $request, $id)
    {
      $request->validate([
         'file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $dosen = Dosen::where('user_id', $id)->firstOrFail();
      $user = $mahasiswa->user;
      if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
         Storage::disk('public')->delete($user->photo_profile);
      }
      $file = $request->file('file');
      $path = $file->store('profiles', 'public');
      $user->update([
         'photo_profile' => $path,
      ]);
      return redirect()
         ->route('dosen.profile')
         ->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function kelas()
    {
        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();

        // Ambil semua kelas yang diajar oleh dosen ini (via relasi)
        $kelasList = $dosen->kelas()->get();

        return view('dosen.kelas', [
            'user' => $user,
            'kelasList' => $kelasList,
        ]);
    }

    // PENILAIAN MAHASISWA 

    public function penilaianMahasiswa()
    {
        $user = Auth::user();

        $dosen = Dosen::where('user_id', $user->id)->first();
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        // eager-load user dan penilaian
        $mahasiswaList = Mahasiswa::with(['user', 'penilaian'])
            ->get();

        return view('dosen.penilaian_mahasiswa', [
            'user' => $user,
            'dosen' => $dosen,
            'mahasiswaList' => $mahasiswaList,
        ]);
    }
}

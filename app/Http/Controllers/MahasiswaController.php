<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Fasilitas;
use App\Models\Mahasiswa;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;



class MahasiswaController extends Controller
{
   public function dashboard()
   {
      $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
      return view('mahasiswa.dashboard', compact('mahasiswa'));
   }

   public function profile(){
      $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
      return view('mahasiswa.profile', compact('mahasiswa'));
   }
   public function changePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $mahasiswa = Mahasiswa::findOrFail($id);
         $user = $mahasiswa->user;
         $user->update([
            'password' => Hash::make($validated['password']),
         ]);
        return redirect()
            ->route('mahasiswa.profile')
            ->with('success', 'Password berhasil diubah!');
    }

   public function uploadProfpic(Request $request, $id)
   {
      $request->validate([
         'file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $mahasiswa = Mahasiswa::where('user_id', $id)->firstOrFail();
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
         ->route('mahasiswa.profile')
         ->with('success', 'Foto profil berhasil diperbarui!');
   }


   public function kpi(){
      return view('mahasiswa.kpi');
   }
   public function kelas(){
      return view('mahasiswa.kelas');
   }

   public function penilaian_dosen() {
      return view('mahasiswa.penilaian_dosen');
   }
   public function penilaian_fasilitas() {
      return view('mahasiswa.penilaian_fasilitas');
   }
   public function penilaian_unit() {
      return view('mahasiswa.penilaian_unit');
   }
   public function penilaian_praktikum() {
      return view('mahasiswa.penilaian_praktikum');
   }

   public function laporan() {
      return view('mahasiswa.laporan');
   }

   public function feedback() {
      return view('mahasiswa.feedback');
   }
}

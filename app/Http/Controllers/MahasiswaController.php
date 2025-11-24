<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Fasilitas;
use App\Models\Feedback;
use App\Models\Kategori;
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
      $mahasiswa = Mahasiswa::with('program_studi')->where('user_id', Auth::id())->firstOrFail();
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
      $fasilitas = Fasilitas::paginate(10);
      return view('mahasiswa.penilaian_fasilitas', ['fasilitas' => $fasilitas]);
   }
   public function penilaian_unit() {
      $units = Unit::with('penanggungJawab')->paginate(10);
      return view('mahasiswa.penilaian_unit', ['units' => $units]);
   }
   public function penilaian_praktikum() {
      return view('mahasiswa.penilaian_praktikum');
   }

   public function laporan() {
      return view('mahasiswa.laporan');
   }

   public function feedback() {
      $kategori = Kategori::where('id', '!=', 2)->get();
      return view('mahasiswa.feedback', ['kategori' => $kategori]);
   }
   public function insertFeedback(Request $request) 
   {
      $validated = $request->validate([
         'subjek' => 'required|string|max:255',
         'kategori' => 'required|exists:kategori,id',
         'deskripsi' => 'required|string|max:255',
         'file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $isAnonim = $request->has('anonim') ? 1 : 0;
      $path = null;
      if ($request->hasFile('file')) {
         $path = $request->file('file')->store('foto', 'public');
      }
      $user = auth()->user();
      $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();
      Feedback::create([
         'pengirim_id' => $user->id, 
         'kategori_id' => $validated['kategori'],
         'isi' => $validated['deskripsi'],
         'foto' => $path,
         'is_anonymous' => $isAnonim,
      ]);
      return redirect()
         ->route('mahasiswa.feedback')
         ->with('success', 'Feedback berhasil dikirim!');
   }

}

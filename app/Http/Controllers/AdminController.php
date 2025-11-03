<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Fasilitas;
use App\Models\Mahasiswa;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
   public function dashboard() {
      return view('admin.dashboard');
   }

   public function user() {
      $users = User::all();

      return view('admin.user', ['users' => $users]);
   }

   public function form_user() {
      return view('admin.form_user');
   }

   public function delete_user($id) {
      $user = User::findOrFail($id);
      if($user->role == 'mahasiswa') {
         Mahasiswa::where('user_Id', $id)->delete();
      } elseif($user->role == 'dosen') {
         Dosen::where('user_Id', $id)->delete();
      }
      $user->delete();

      return redirect()->route('admin.user')->with('success', 'User deleted successfully!');
   }

   public function insert_user(Request $request)
{
      // --- Validate basic user data ---
      $validated = $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email|max:255|unique:users,email',
         'password' => 'required|string|min:6',
         'role' => 'required|in:mahasiswa,dosen,admin'
      ]);

      // --- Add role-specific validation ---
      if ($request->role === 'mahasiswa') {
         $roleData = $request->validate([
               'nrp' => 'required|unique:mahasiswa,nrp',
               'program_studi' => 'required|in:Informatika,SIB,DKV,Industri,Elektro,Desain Produk,MBD',
               'angkatan' => 'required|integer|min:1970|max:' . date('Y'),
               'ipk' => 'required|numeric|between:0,4',
         ]);
      } elseif ($request->role === 'dosen') {
         $roleData = $request->validate([
               'nidn' => 'required|unique:dosen,nidn',
         ]);
      } else {
         $roleData = [];
      }

      // --- Create user ---
      $user = User::create([
         'name' => $validated['name'],
         'email' => $validated['email'],
         'password' => Hash::make($validated['password']),
         'role' => $validated['role'],
      ]);

      // --- Create related record based on role ---
      if ($validated['role'] === 'mahasiswa') {
         Mahasiswa::create([
               'user_id' => $user->id,
               'nrp' => $roleData['nrp'],
               'program_studi' => $roleData['program_studi'],
               'angkatan' => $roleData['angkatan'],
               'ipk' => $roleData['ipk'],
         ]);
      } elseif ($validated['role'] === 'dosen') {
         Dosen::create([
               'user_id' => $user->id,
               'nidn' => $roleData['nidn'],
         ]);
      }

      return redirect()->route('admin.user')
         ->with('success', 'User added successfully!');
   }

   public function update_user(Request $request, $id) {
      $user = User::findOrFail($id);

      $validated = $request->validate([
         'name' => 'required|string|max:255',
         'email' => [
               'required',
               'email',
               'max:255',
               Rule::unique('users', 'email')->ignore($id),
         ],
         'role' => 'required|in:mahasiswa,dosen,admin',
      ]);

      $roleData = [];

      if ($validated['role'] === 'mahasiswa') {
         $roleData = $request->validate([
               'nrp' => [
                  'required',
                  Rule::unique('mahasiswa', 'nrp')->ignore(optional($user->mahasiswa)->id),
               ],
               'program_studi' => 'required|in:Informatika,SIB,DKV,Industri,Elektro,Desain Produk,MBD',
               'angkatan' => 'required|integer|min:1970|max:' . date('Y'),
               'ipk' => 'required|numeric|between:0,4',
         ]);
      } elseif ($validated['role'] === 'dosen') {
         $roleData = $request->validate([
               'nidn' => [
                  'required',
                  Rule::unique('dosen', 'nidn')->ignore(optional($user->dosen)->id),
               ],
         ]);
      }

      // --- If role changed, clean up old related data ---
      if ($user->role !== $validated['role']) {
         if ($user->role === 'mahasiswa' && $user->mahasiswa) {
               $user->mahasiswa->delete();
         } elseif ($user->role === 'dosen' && $user->dosen) {
               $user->dosen->delete();
         }
      }

      // --- Update user ---
      $user->update([
         'name' => $validated['name'],
         'email' => $validated['email'],
         'role' => $validated['role'],
      ]);

      // --- Maintain role-related data ---
      if ($validated['role'] === 'mahasiswa') {
         Mahasiswa::updateOrCreate(
               ['user_id' => $user->id],
               [
                  'nrp' => $roleData['nrp'],
                  'program_studi' => $roleData['program_studi'],
                  'angkatan' => $roleData['angkatan'],
                  'ipk' => $roleData['ipk'],
               ]
         );
      } elseif ($validated['role'] === 'dosen') {
         Dosen::updateOrCreate(
               ['user_id' => $user->id],
               ['nidn' => $roleData['nidn']]
         );
      }

      return redirect()->route('admin.user')->with('success', 'User updated successfully!');
   }

   public function form_user_edit($id) {
      $user = User::findOrFail($id);
      if($user->role == 'mahasiswa') {
         $user = User::with('mahasiswa')->findOrFail($id);
      } elseif ($user->role == 'dosen') {
         $user = User::with('dosen')->findOrFail($id);
      }

      return view('admin.form_user', ['user' => $user]);
   }

   public function fasilitas() {
      $fasilitas = Fasilitas::all();

      return view('admin.fasilitas', ['fasilitas' => $fasilitas]);
   }

   public function form_fasilitas() {
      return view('admin.form_fasilitas');
   }

   public function delete_fasilitas($id) {
      Fasilitas::findOrFail($id)->delete();
      return redirect()->route('admin.fasilitas')->with('success', 'Fasilitas deleted successfully!');
   }

   public function insert_fasilitas(Request $request) {
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'kategori' => 'required|in:Umum,Akademik,Laboratorium,Olahraga,Kesehatan,Administrasi',
         'lokasi' => 'required|string|max:255',
         'kondisi' => 'required|in:baik,perbaikan'
      ]);

      $nameFound = Fasilitas::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
      if($nameFound) {
         return back()->withErrors(['name' => 'Fasilitas with this name already exists!'])->withInput();
      }

      Fasilitas::create($data);
      return redirect()->route('admin.fasilitas')->with('success', 'Fasilitas added successfully!');
   }

   public function update_fasilitas(Request $request, $id) {
      $fasilitas = Fasilitas::findOrFail($id);
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'kategori' => 'required|in:Umum,Akademik,Laboratorium,Olahraga,Kesehatan,Administrasi',
         'lokasi' => 'required|string|max:255',
         'kondisi' => 'required|in:baik,perbaikan'
      ]);

      $nameFound = Fasilitas::where('id', '!=', $id)->whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
      if($nameFound) {
         return back()->withErrors(['name' => 'Fasilitas with this name already exists!'])->withInput();
      }

      $fasilitas->update($data);
      return redirect()->route('admin.fasilitas')->with('success', 'Fasilitas updated successfully!');
   }

   public function form_fasilitas_edit($id) {
      $editing = Fasilitas::findOrFail($id);

      return view('admin.form_fasilitas', ['editing' => $editing]);
   }

   public function unit() {
      $units = Unit::with('penanggungJawab')->get();

      return view('admin.unit', ['units' => $units]);
   }

   public function form_unit() {
      $users = User::all();

      return view('admin.form_unit', ['users' => $users]);
   }

   public function delete_unit($id) {
      Unit::findOrFail($id)->delete();
      return redirect()->route('admin.unit')->with('success', 'Unit deleted successfully!');
   }

   public function insert_unit(Request $request) {
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'type' => 'required|in:Layanan,Akademik,UKM,UKK,Organisasi',
         'penanggung_jawab_id' => 'required|exists:users,id'
      ]);

      $nameFound = Unit::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
      if($nameFound) {
         return back()->withErrors(['name' => 'Unit with this name already exists!'])->withInput();
      }

      Unit::create($data);
      return redirect()->route('admin.unit')->with('success', 'Unit added successfully!');
   }

   public function update_unit(Request $request, $id) {
      $unit = Unit::findOrFail($id);
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'type' => 'required|in:Layanan,Akademik,UKM,UKK,Organisasi',
         'penanggung_jawab_id' => 'required|exists:users,id'
      ]);

      $nameFound = Unit::where('id', '!=', $id)->whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
      if($nameFound) {
         return back()->withErrors(['name' => 'Unit with this name already exists!'])->withInput();
      }

      $unit->update($data);
      return redirect()->route('admin.unit')->with('success', 'Unit updated successfully!');
   }

   public function form_unit_edit($id) {
      $unit = Unit::findOrFail($id);
      $users = User::all();

      return view('admin.form_unit', ['users' => $users, 'unit' => $unit]);
   }

   public function periode() {
      return view('admin.periode');
   }

   public function mata_kuliah() {
      return view('admin.mata_kuliah');
   }

   public function form_mata_kuliah() {
      return view('admin.form_mata_kuliah');
   }

   public function kelas() {
      return view('admin.kelas');
   }

   public function form_kelas() {
      return view('admin.form_kelas');
   }

   public function enrollment() {
      return view('admin.enrollment');
   }

   public function form_enrollment() {
      return view('admin.form_enrollment');
   }

   public function kategori_kpi() {
      return view('admin.kategori_kpi');
   }

   public function list_indikator() {
      return view('admin.list_indikator');
   }

   public function form_indikator() {
      return view('admin.form_indikator');
   }

   public function penilaian() {
      return view('admin.penilaian');
   }

   public function detail_penilaian() {
      return view('admin.detail_penilaian');
   }

   public function laporan() {
      return view('admin.laporan');
   }

   public function feedback() {
      return view('admin.feedback');
   }
}

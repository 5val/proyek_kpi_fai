<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Enrollment;
use App\Models\Fasilitas;
use App\Models\Indikator;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Periode;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
   public function dashboard() {
      return view('admin.dashboard');
   }

   public function user() {
      $users = User::orderBy("is_active", "desc")->get();

      return view('admin.user', ['users' => $users]);
   }

   
   public function form_user() {
      return view('admin.form_user');
   }

   public function delete_user($id) {
      $user = User::findOrFail($id);
      // if($user->role == 'mahasiswa') {
      //    Mahasiswa::where('user_Id', $id)->delete();
      // } elseif($user->role == 'dosen') {
      //    Dosen::where('user_Id', $id)->delete();
      // }
      // $user->delete();
      $success_msg = "";
      if($user->is_active == 0) {
         $user->is_active = 1;
         $success_msg = "User activated successfully!";
      } else {
         $user->is_active = 0;
         $success_msg = "User inactivated successfully!";
      }
      $user->save();

      return redirect()->route('admin.user')->with('success', $success_msg);
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
      $fasilitas = Fasilitas::paginate(10);
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
      $units = Unit::with('penanggungJawab')->paginate(10);

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
      $periode = Periode::paginate(10);
      return view('admin.periode', ['periode' => $periode]);
   }

   public function new_periode() {
      $last_periode = Periode::orderBy('id', 'desc')->first();
      
      if($last_periode->semester == "gasal") {
         $next_semester = "genap";
         $next_tahun = $last_periode->tahun + 1;
         $next_periode = "Genap " . $last_periode->tahun . "/" . $next_tahun;
      } else if($last_periode->semester == "genap") {
         $next_semester = "pendek";
         $next_tahun = $last_periode->tahun;
         $next_periode = "Pendek " . $last_periode->tahun - 1 . "/" . $next_tahun;
      } else {
         $next_semester = "gasal";
         $next_tahun = $last_periode->tahun;
         $next_periode = "Gasal " . $last_periode->tahun . "/" . $next_tahun + 1;
      }

      Periode::create(['nama_periode' => $next_periode, 'tahun' => $next_tahun, 'semester' => $next_semester]);

      return back()->with('success', 'New periode successfully opened!');
   }

   public function delete_periode($id) {
      Periode::findOrFail($id)->delete();
      return redirect()->route('admin.periode')->with('success', 'Periode deleted successfully!');
   }

   public function mata_kuliah() {
      $matkul = MataKuliah::paginate(10);
      return view('admin.mata_kuliah', ["matkul" => $matkul]);
   }

   public function form_mata_kuliah() {
      return view('admin.form_mata_kuliah');
   }

   public function delete_mata_kuliah($id) {
      MataKuliah::findOrFail($id)->delete();
      return redirect()->route('admin.mata_kuliah')->with('success', 'Mata Kuliah deleted successfully!');
   }

   public function insert_mata_kuliah(Request $request) {
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'program_studi' => 'required|in:Informatika,SIB,DKV,Industri,Elektro,Desain Produk,MBD',
         'sks' => 'required|integer|min:2|max:4'
      ]);

      $matkulFound = MataKuliah::where('name', $request->name)->where('program_studi', $request->program_studi)->first();
      if($matkulFound) {
         return back()->withErrors(['program_studi' => 'Mata Kuliah with this name already exists in this program studi!'])->withInput();
      }

      MataKuliah::create($data);
      return redirect()->route('admin.mata_kuliah')->with('success', 'Mata Kuliah added successfully!');
   }

   public function update_mata_kuliah(Request $request, $id) {
      $matkul = MataKuliah::findOrFail($id);
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'program_studi' => 'required|in:Informatika,SIB,DKV,Industri,Elektro,Desain Produk,MBD',
         'sks' => 'required|integer|min:2|max:4'
      ]);

      $matkulFound = MataKuliah::where('id', '!=', $id)->where('name', $request->name)->where('program_studi', $request->program_studi)->first();
      if($matkulFound) {
         return back()->withErrors(['program_studi' => 'Mata Kuliah with this name already exists in this program studi!'])->withInput();
      }

      $matkul->update($data);
      return redirect()->route('admin.mata_kuliah')->with('success', 'Mata Kuliah updated successfully!');
   }

   public function form_mata_kuliah_edit($id) {
      $matkul = MataKuliah::findOrFail($id);

      return view('admin.form_mata_kuliah', ['matkul' => $matkul]);
   }

   public function kelas() {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode')->withCount('enrollment')->paginate(10);
      return view('admin.kelas', ['kelas' => $kelas]);
   }

   public function form_kelas() {
      $matkul = MataKuliah::all();
      $periode = Periode::all();
      $dosen = Dosen::with('user')->get();

      return view('admin.form_kelas', ['matkul' => $matkul, 'periode' => $periode, 'dosen' => $dosen]);
   }

   public function delete_kelas($id) {
      Kelas::findOrFail($id)->delete();
      return redirect()->route('admin.kelas')->with('success', 'Kelas deleted successfully!');
   }

   public function insert_kelas(Request $request) {
      $data = $request->validate([
         'mata_kuliah' => 'required',
         'periode' => 'required',
         'dosen' => 'required'
      ]);

      $kelasFound = Kelas::where('mata_kuliah_id', $request->mata_kuliah)->where('periode_id', $request->periode)->first();
      if($kelasFound) {
         return back()->withErrors(['mata_kuliah' => 'Kelas with this mata kuliah already exists in this periode!'])->withInput();
      }

      Kelas::create(['mata_kuliah_id' => $request->mata_kuliah, 'periode_id' => $request->periode, 'dosen_nidn' => $request->dosen]);
      return redirect()->route('admin.kelas')->with('success', 'Kelas added successfully!');
   }

   public function update_kelas(Request $request, $id) {
      $kelas = Kelas::findOrFail($id);
      $data = $request->validate([
         'mata_kuliah' => 'required',
         'periode' => 'required',
         'dosen' => 'required'
      ]);

      $kelasFound = Kelas::where('id', '!=', $id)->where('mata_kuliah_id', $request->mata_kuliah)->where('periode_id', $request->periode)->first();
      if($kelasFound) {
         return back()->withErrors(['mata_kuliah' => 'Kelas with this mata kuliah already exists in this periode!'])->withInput();
      }

      $kelas->mata_kuliah_id = $request->mata_kuliah;
      $kelas->periode_id = $request->periode;
      $kelas->dosen_nidn = $request->dosen;
      $kelas->save();
      return redirect()->route('admin.kelas')->with('success', 'Kelas updated successfully!');
   }

   public function form_kelas_edit($id) {
      $kelas = Kelas::findOrFail($id);
      $matkul = MataKuliah::all();
      $periode = Periode::all();
      $dosen = Dosen::with('user')->get();
      return view('admin.form_kelas', ['kelas' => $kelas, 'matkul' => $matkul, 'periode' => $periode, 'dosen' => $dosen]);
   }

   public function enrollment($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode')->where('id', $id)->first();
      $enrollments = Enrollment::with('mahasiswa.user')->where('kelas_id', $id)->paginate(10);

      return view('admin.enrollment', ['kelas' => $kelas, 'enrollments' => $enrollments]);
   }

   public function delete_enrollment($kelas_id, $id) {
      $kelas = Kelas::findOrFail($kelas_id);
      Enrollment::findOrFail($id)->delete();
      return redirect()->route('admin.enrollment', $kelas->id)->with('success', 'Enrollment deleted successfully!');
   }

   public function form_enrollment($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode')->where('id', $id)->first();
      return view('admin.form_enrollment', ['kelas' => $kelas]);
   }

   public function download_enrollment($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode')->where('id', $id)->first();
      $filePath = storage_path('app/template_excel/template_enrollment.xlsx'); //  path to your file
      if (file_exists($filePath)) {
         return response()->download($filePath, 'template_enrollment.xlsx', ['kelas' => $kelas]); //  filename for the user
      } else {
         abort(404, 'Template file not found.'); //  handle file not found error
      }
   }

   public function upload_enrollment(Request $request, $id) {
      $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Skip header row (row 0)
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            // Skip completely empty rows
            if (empty(array_filter($row))) {
               continue;
            }

            Enrollment::create([
               'kelas_id'       => $id,
               'mahasiswa_nrp'  => $row[0] ?? null,
            ]);
         }

        return redirect()->route('admin.enrollment', $id)->with('success', 'Enrollments uploaded successfully.');
   }

   public function kategori_kpi() {
      $kategori = Kategori::withCount('indikator')->get();
      return view('admin.kategori_kpi', ['kategori' => $kategori]);
   }

   public function list_indikator($id) {
      $indikator = Indikator::where('kategori_id', $id)->get();
      return view('admin.list_indikator', ['indikator' => $indikator, 'kategori_id' => $id]);
   }

   public function form_indikator($id) {
      return view('admin.form_indikator', ['kategori_id' => $id]);
   }

   public function delete_indikator($kategori_id, $id) {
      Indikator::findOrFail($id)->delete();
      return redirect()->route('admin.list_indikator', $kategori_id)->with('success', 'Indikator deleted successfully!');
   }

   public function insert_indikator(Request $request, $kategori_id) {
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'bobot' => 'required|integer|min:1|max:100'
      ]);

      $nameFound = Indikator::where('kategori_id', $kategori_id)->whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
      if($nameFound) {
         return back()->withErrors(['name' => 'Indikator with this name already exists in this kategori!'])->withInput();
      }

      Indikator::create(['kategori_id' => $kategori_id, 'name' => $request->name, 'bobot' => $request->bobot]);
      return redirect()->route('admin.list_indikator', $kategori_id)->with('success', 'Indikator added successfully!');
   }

   public function update_indikator(Request $request, $kategori_id, $id) {
      $indikator = Indikator::findOrFail($id);
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'bobot' => 'required|integer|min:1|max:100'
      ]);

      $nameFound = Indikator::where('id', '!=', $id)->where('kategori_id', $kategori_id)->whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
      if($nameFound) {
         return back()->withErrors(['name' => 'Indikator with this name already exists in this kategori!'])->withInput();
      }

      $indikator->update($data);
      return redirect()->route('admin.list_indikator', $kategori_id)->with('success', 'Indikator updated successfully!');
   }

   public function form_indikator_edit($kategori_id, $id) {
      $indikator = Indikator::findOrFail($id);

      return view('admin.form_indikator', ['indikator' => $indikator, 'kategori_id' => $kategori_id]);
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

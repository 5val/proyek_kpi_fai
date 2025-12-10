<?php

namespace App\Http\Controllers;

use App\Models\DetailPenilaian;
use App\Models\Dosen;
use App\Models\Enrollment;
use App\Models\Fasilitas;
use App\Models\Feedback;
use App\Models\Indikator;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Praktikum;
use App\Models\ProgramStudi;
use App\Models\Unit;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
// Excel Export (PhpSpreadsheet)
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// PDF Export (Dompdf)
use Dompdf\Dompdf;

class AdminController extends Controller
{
   public function dashboard() {
      $periode = Periode::latest('id')->first();

      $belum_dinilai_count = [
         'dosen' => Dosen::whereDoesntHave('penilaian', function($q) use ($periode) {
            $q->where('periode_id', $periode->id);
         })->count(),
         'fasilitas' => Fasilitas::whereDoesntHave('penilaian')->count(),
         'unit' => Unit::whereDoesntHave('penilaian')->count(),
         'praktikum' => Praktikum::whereDoesntHave('penilaian', function($q) use ($periode) {
            $q->where('periode_id', $periode->id);
         })->count(),
      ];

      $feedbacks = Feedback::select('kategori_id', 'target_type', 'target_id', DB::raw('count(*) as total'))
         ->where('status', 0)
         ->groupBy('kategori_id', 'target_type', 'target_id')
         ->orderByDesc('total')
         ->take(3)
         ->get()
         ->map(function ($item) {
               // Mengambil nama objek asli dari relasi polimorfik manual
               $modelClass = $item->target_type; // misal: App\Models\Fasilitas
               // if($modelClass) {
                  $object = $modelClass::find($item->target_id);
                  // Bersihkan nama tipe untuk tampilan (ambil nama class saja)
                  $typeDisplay = class_basename($item->target_type); 
               // } else {
               //    $object = ['name' => "Manajemen Kampus"];
               //    $typeDisplay = "Kampus";
               // }
               

               return (object) [
                  'type' => $typeDisplay,
                  'name' => $object->name ?? $object->nama_mk ?? $object->user->name ?? 'Unknown',
                  'kategori_id' => $item->kategori_id,
                  'count' => $item->total,
                  'target_id' => $item->target_id
               ];
         });

      $low_kpi = [
         'dosen' => Dosen::whereHas('penilaian', fn($q) => $q->where('periode_id', $periode->id))
               ->withAvg(['penilaian' => fn($q) => $q->where('periode_id', $periode->id)], 'avg_score')
               ->orderBy('penilaian_avg_avg_score', 'asc')
               ->with('user')
               ->take(3)->get()->map(function($item) { $item->avg_kpi = $item->penilaian_avg_avg_score; return $item; }),
         'fasilitas' => Fasilitas::whereHas('penilaian')
               ->withAvg('penilaian', 'avg_score')
               ->orderBy('penilaian_avg_avg_score', 'asc')
               ->take(3)->get()->map(function($item) { $item->avg_kpi = $item->penilaian_avg_avg_score; return $item; }),
         'unit' => Unit::whereHas('penilaian')
               ->withAvg('penilaian', 'avg_score')
               ->orderBy('penilaian_avg_avg_score', 'asc')
               ->take(3)->get()->map(function($item) { $item->avg_kpi = $item->penilaian_avg_avg_score; return $item; }),
         'praktikum' => Praktikum::whereHas('penilaian', fn($q) => $q->where('periode_id', $periode->id))
               ->withAvg(['penilaian' => fn($q) => $q->where('periode_id', $periode->id)], 'avg_score')
               ->orderBy('penilaian_avg_avg_score', 'asc')
               ->with(['kelas.mataKuliah', 'kelas.program_studi']) // Eager load relasi praktikum
               ->take(3)->get()->map(function($item) { $item->avg_kpi = $item->penilaian_avg_avg_score; return $item; }),
      ];

      $last6Months = collect();
      for ($i = 5; $i >= 0; $i--) {
         $month = Carbon::now()->subMonths($i);
         $last6Months->push($month->format('Y-m'));
      }

      // 2. Ambil rata-rata skor per bulan
      $chart_bulan_data = Penilaian::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as ym'),
            DB::raw('AVG(avg_score) as rata_rata_skor')
         )
         ->where('periode_id', $periode->id)
         ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
         ->groupBy('ym')
         ->orderBy('ym', 'asc')
         ->get()
         ->keyBy('ym'); // supaya bisa diakses per 'Y-m'

      // 3. Merge dengan list bulan untuk fill missing 0
      $chart_bulan = $last6Months->map(function($ym) use ($chart_bulan_data) {
         $item = $chart_bulan_data->get($ym);
         return (object)[
            'ym' => $ym,
            'rata_rata_skor' => $item ? (float)$item->rata_rata_skor : 0,
            'bulan' => Carbon::createFromFormat('Y-m', $ym)
                              ->locale('id')
                              ->translatedFormat('F Y')
         ];
      });

      $allKategori = Kategori::all()->keyBy('id');

      // 2. Ambil rata-rata skor per kategori
      $kategoriData = Penilaian::select(
        'kategori_id',
        DB::raw('AVG(avg_score) as rata_rata_skor')
    )
    ->where(function ($q) use ($periode) {
         $q->whereNotIn('dinilai_type', [
               'App\Models\Fasilitas',
               'App\Models\Unit'
         ])->where('periode_id', $periode->id);

      })
      ->orWhereIn('dinilai_type', [
         'App\Models\Fasilitas',
         'App\Models\Unit'
      ])
      ->groupBy('kategori_id')
      ->get()
      ->keyBy('kategori_id');

      // 3. Merge untuk fill missing 0
      $chart_kategori = $allKategori->map(function($kategori) use ($kategoriData) {
         $data = $kategoriData->get($kategori->id);
         return (object)[
            'nama_kategori' => $kategori->name,
            'rata_rata_skor' => $data ? (float)$data->rata_rata_skor : 0
         ];
      });

      // dd($chart_bulan);
      // dd($chart_kategori);

      return view('admin.dashboard', [
         'belum_dinilai_count' => $belum_dinilai_count,
         'feedbacks' => $feedbacks,
         'low_kpi' => $low_kpi,
         'chart_bulan' => $chart_bulan,
         'chart_kategori' => $chart_kategori,
      ]);
   }

   public function detail_dashboard_card($type) {
      $periode = Periode::latest('id')->first();
      if($type == 'belum_dinilai_dosen') {
         $data = [
            'pageTitle' => 'Dosen Belum Dinilai',
            'pageSubtitle' => 'Daftar dosen yang belum memiliki data penilaian masuk',
            'tableTitle' => 'List Dosen',
            'headers' => ['Nama Dosen', 'NIDN'],
            'keys' => ['name', 'nidn'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Dosen::whereDoesntHave('penilaian', fn($q) => $q->where('periode_id', $periode->id))->with('user')->get()->map(function($dosen) {
                    return [
                        'id' => $dosen->id,
                        'name' => $dosen->user->name ?? 'User Tidak Ditemukan', // Ambil nama dari user
                        'nidn' => $dosen->nidn,
                    ];
                })
         ];
      } elseif($type == 'belum_dinilai_fasilitas') {
         $data = [
            'pageTitle' => 'Fasilitas Belum Dinilai',
            'pageSubtitle' => 'Daftar fasilitas yang belum memiliki data penilaian masuk',
            'tableTitle' => 'List Fasilitas',
            'headers' => ['Nama Fasilitas'],
            'keys' => ['name'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Fasilitas::whereDoesntHave('penilaian', fn($q) => $q->where('periode_id', $periode->id))->get()
         ];
      } elseif($type == 'belum_dinilai_unit') {
         $data = [
            'pageTitle' => 'Unit Belum Dinilai',
            'pageSubtitle' => 'Daftar unit yang belum memiliki data penilaian masuk',
            'tableTitle' => 'List Unit',
            'headers' => ['Nama Unit'],
            'keys' => ['name'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Unit::whereDoesntHave('penilaian', fn($q) => $q->where('periode_id', $periode->id))->get()
         ];
      } elseif($type == 'belum_dinilai_praktikum') {
         $data = [
            'pageTitle' => 'Praktikum Belum Dinilai',
            'pageSubtitle' => 'Daftar praktikum yang belum memiliki data penilaian masuk',
            'tableTitle' => 'List Praktikum',
            'headers' => ['Nama Praktikum', 'Program Studi'],
            'keys' => ['name', 'program_studi'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Praktikum::whereDoesntHave('penilaian', fn($q) => $q->where('periode_id', $periode->id))->with('kelas.mataKuliah', 'kelas.program_studi')->get()->map(function($prak) {
                    return [
                        'id' => $prak->id,
                        'name' => $prak->kelas->mataKuliah->name ?? 'Praktikum Tidak Ditemukan',
                        'program_studi' => $prak->kelas->program_studi->name ?? '-',
                    ];
                })
         ];
      } 
      return view('admin.detail_dashboard', ['data' => $data]);
   }

   public function detail_dashboard_list($type, $id) {
      $periode = Periode::latest('id')->first();
      if($type == 'dosen') {
         $data = [
            'pageTitle' => 'Dosen Performa Rendah',
            'pageSubtitle' => 'Daftar penilaian dosen dengan skor rata-rata KPI rendah',
            'tableTitle' => 'List Penilaian',
            'headers' => ['Tanggal', 'Skor Rata-rata', 'Komentar', 'Aksi'],
            'keys' => ['created_at', 'avg_score', 'komentar'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Penilaian::where('dinilai_type', 'App\Models\Dosen')->where('dinilai_id', $id)->where('periode_id', $periode->id)->orderBy('avg_score', 'asc')->get(), 
            'actionType' => 'detail'
         ];
      } elseif($type == 'fasilitas') {
         $data = [
            'pageTitle' => 'Fasilitas Performa Rendah',
            'pageSubtitle' => 'Daftar penilaian fasilitas dengan skor rata-rata KPI rendah',
            'tableTitle' => 'List Penilaian',
            'headers' => ['Tanggal', 'Skor Rata-rata', 'Komentar', 'Aksi'],
            'keys' => ['created_at', 'avg_score', 'komentar'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Penilaian::where('dinilai_type', 'App\Models\Fasilitas')->where('dinilai_id', $id)->where('periode_id', $periode->id)->orderBy('avg_score', 'asc')->get(), 
            'actionType' => 'detail'
         ];
      } elseif($type == 'unit') {
         $data = [
            'pageTitle' => 'Unit Performa Rendah',
            'pageSubtitle' => 'Daftar penilaian unit dengan skor rata-rata KPI rendah',
            'tableTitle' => 'List Penilaian',
            'headers' => ['Tanggal', 'Skor Rata-rata', 'Komentar', 'Aksi'],
            'keys' => ['created_at', 'avg_score', 'komentar'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Penilaian::where('dinilai_type', 'App\Models\Unit')->where('dinilai_id', $id)->where('periode_id', $periode->id)->orderBy('avg_score', 'asc')->get(), 
            'actionType' => 'detail'
         ];
      } else {
         $data = [
            'pageTitle' => 'Praktikum Performa Rendah',
            'pageSubtitle' => 'Daftar penilaian praktikum dengan skor rata-rata KPI rendah',
            'tableTitle' => 'List Penilaian',
            'headers' => ['Tanggal', 'Skor Rata-rata', 'Komentar', 'Aksi'],
            'keys' => ['created_at', 'avg_score', 'komentar'], // Sesuaikan dengan nama kolom/atribut model
            'items' => Penilaian::where('dinilai_type', 'App\Models\Praktikum')->where('dinilai_id', operator: $id)->where('periode_id', $periode->id)->orderBy('avg_score', 'asc')->get(), 
            'actionType' => 'detail'
         ];
      }
      return view('admin.detail_dashboard', ['data' => $data]);
   }

   public function detail_dashboard_feedback($kategori_id, $target_id) {
      $data = [
         'pageTitle' => 'Daftar Feedback',
         'pageSubtitle' => 'Daftar feedback untuk objek terbanyak',
         'tableTitle' => 'Semua Feedback',
         'headers' => ['Pengirim', 'Isi', 'Status', 'Aksi'],
         'keys' => ['pengirim', 'isi', 'status'],
         'items' => Feedback::with(['pengirim', 'kategori'])->where('kategori_id', $kategori_id)->where('target_id', $target_id)->where('status', 0)->get()->map(function($fb) {
            return [
               'id' => $fb->id,
               'pengirim' => $fb->is_anonymous ? 'Anonim' : ($fb->pengirim->name ?? '-'),
               'isi' => \Str::limit($fb->isi, 50),
               'status' => $fb->status == 1 ? 'Sudah Ditanggapi' : 'Belum Ditanggapi',
            ];
         }),
         'actionType' => 'feedback'
      ];

      return view('admin.detail_dashboard', ['data' => $data]);
   }

   public function user(Request $request) {
      if($request->role) {
         $users = User::where('role', $request->role)->orderBy("is_active", "desc")->get();
      } else {
         $users = User::orderBy("is_active", "desc")->get();
      }

      return view('admin.user', ['users' => $users]);
   }

   
   public function form_user() {
      $program_studi = ProgramStudi::all();
      return view('admin.form_user', ['program_studi' => $program_studi]);
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
      // is_certified: null / "on"
      // --- Validate basic user data ---
      $validated = $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email|max:255|unique:users,email',
         'password' => 'required|string|min:6',
         'phone_number' => 'required|numeric|min_digits:12|max_digits:13',
         'role' => 'required|in:mahasiswa,dosen,admin'
      ]);

      // --- Add role-specific validation ---
      if ($request->role === 'mahasiswa') {
         $roleData = $request->validate([
               'nrp' => 'required|unique:mahasiswa,nrp',
               'program_studi' => 'required',
               'points' => 'required|integer|min:0',
               'ipk' => 'required|numeric|between:0,4',
         ]);
      } elseif ($request->role === 'dosen') {
         $roleData = $request->validate([
               'nidn' => 'required|unique:dosen,nidn',
               'start_date' => 'required|date|after_or_equal:today',
               'end_date' => 'required|date|after_or_equal:today',
         ]);
      } else {
         $roleData = [];
      }

      // --- Create user ---
      $user = User::create([
         'name' => $validated['name'],
         'email' => $validated['email'],
         'password' => Hash::make($validated['password']),
         'phone_number' => $validated['phone_number'],
         'role' => $validated['role'],
      ]);

      // --- Create related record based on role ---
      if ($validated['role'] === 'mahasiswa') {
         Mahasiswa::create([
               'user_id' => $user->id,
               'nrp' => $roleData['nrp'],
               'program_studi_id' => $roleData['program_studi'],
               'points_balance' => $roleData['points'],
               'ipk' => $roleData['ipk'],
         ]);
      } elseif ($validated['role'] === 'dosen') {
         $is_certified = 0;
         if($request->is_certified) {
            $is_certified = 1;
         }
         Dosen::create([
               'user_id' => $user->id,
               'nidn' => $roleData['nidn'],
               'start_date' => $roleData['start_date'],
               'end_date' => $roleData['end_date'],
               'is_certified' => $is_certified,
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
         'phone_number' => 'required|numeric|min_digits:12|max_digits:13',
         'role' => 'required|in:mahasiswa,dosen,admin',
      ]);

      $roleData = [];

      if ($validated['role'] === 'mahasiswa') {
         $roleData = $request->validate([
               'nrp' => [
                  'required',
                  Rule::unique('mahasiswa', 'nrp')
                     ->ignore($user->mahasiswa->nrp, 'nrp'),
               ],
               'program_studi' => 'required',
               'points' => 'required|integer|min:0',
               'ipk' => 'required|numeric|between:0,4',
         ]);
      } elseif ($validated['role'] === 'dosen') {
         $roleData = $request->validate([
               'nidn' => [
                  'required',
                  Rule::unique('dosen', 'nidn')->ignore(optional($user->dosen)->id),
               ],
               'start_date' => 'required|date',
               'end_date' => 'required|date',
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
         'phone_number' => $validated['phone_number'],
         'role' => $validated['role'],
      ]);

      // --- Maintain role-related data ---
      if ($validated['role'] === 'mahasiswa') {
         Mahasiswa::updateOrCreate(
               ['user_id' => $user->id],
               [
                  'nrp' => $roleData['nrp'],
                  'program_studi' => $roleData['program_studi'],
                  'points' => $roleData['points'],
                  'ipk' => $roleData['ipk'],
               ]
         );
      } elseif ($validated['role'] === 'dosen') {
         $is_certified = 0;
         if($request->is_certified) {
            $is_certified = 1;
         }
         Dosen::updateOrCreate(
               ['user_id' => $user->id],
               [
                  'nidn' => $roleData['nidn'],
                  'start_date' => $roleData['start_date'],
                  'end_date' => $roleData['end_date'],
                  'is_certified' => $is_certified,
               ],
         );
      }

      return redirect()->route('admin.user')->with('success', 'User updated successfully!');
   }

   public function form_user_edit($id) {
      $user = User::findOrFail($id);
      if($user->role == 'mahasiswa') {
         $user = User::with('mahasiswa.program_studi')->findOrFail($id);
      } elseif ($user->role == 'dosen') {
         $user = User::with('dosen')->findOrFail($id);
      }
      $program_studi = ProgramStudi::all();

      return view('admin.form_user', ['user' => $user, 'program_studi' => $program_studi]);
   }

   public function fasilitas() {
      $fasilitas = Fasilitas::orderBy('is_active', 'desc')->get();
      return view('admin.fasilitas', ['fasilitas' => $fasilitas]);
   }

   public function form_fasilitas() {
      return view('admin.form_fasilitas');
   }

   public function delete_fasilitas($id) {
      $fasilitas = Fasilitas::findOrFail($id);
      $success_msg = "";
      if($fasilitas->is_active == 0) {
         $fasilitas->is_active = 1;
         $success_msg = "Fasilitas activated successfully!";
      } else {
         $fasilitas->is_active = 0;
         $success_msg = "Fasilitas inactivated successfully!";
      }
      $fasilitas->save();
      return redirect()->route('admin.fasilitas')->with('success', $success_msg);
   }

   public function insert_fasilitas(Request $request) {
      $data = $request->validate([
         'name' => 'required|string|max:255',
         'kategori' => 'required|in:Umum,Akademik,Laboratorium,Olahraga,Kesehatan,Administrasi',
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
      $units = Unit::with('penanggungJawab')->orderBy('is_active', 'desc')->get();

      return view('admin.unit', ['units' => $units]);
   }

   public function form_unit() {
      $users = User::all();

      return view('admin.form_unit', ['users' => $users]);
   }

   public function delete_unit($id) {
      $unit = Unit::findOrFail($id);
      $success_msg = "";
      if($unit->is_active == 0) {
         $unit->is_active = 1;
         $success_msg = "Unit activated successfully!";
      } else {
         $unit->is_active = 0;
         $success_msg = "Unit inactivated successfully!";
      }
      $unit->save();
      return redirect()->route('admin.unit')->with('success', $success_msg);
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
      $periode = Periode::all();
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
      $matkul = MataKuliah::orderBy('is_active', 'desc')->get();
      return view('admin.mata_kuliah', ["matkul" => $matkul]);
   }

   public function form_mata_kuliah() {
      return view('admin.form_mata_kuliah');
   }

   public function delete_mata_kuliah($id) {
      $matkul = MataKuliah::findOrFail($id);
      $success_msg = "";
      if($matkul->is_active == 0) {
         $matkul->is_active = 1;
         $success_msg = "Mata Kuliah activated successfully!";
      } else {
         $matkul->is_active = 0;
         $success_msg = "Mata Kuliah inactivated successfully!";
      }
      $matkul->save();
      return redirect()->route('admin.mata_kuliah')->with('success', $success_msg);
   }

   public function insert_mata_kuliah(Request $request) {
      $data = $request->validate([
         'name' => 'required|string|max:255|unique:mata_kuliah,name'
      ]);

      MataKuliah::create($data);
      return redirect()->route('admin.mata_kuliah')->with('success', 'Mata Kuliah added successfully!');
   }

   public function update_mata_kuliah(Request $request, $id) {
      $matkul = MataKuliah::findOrFail($id);
      $data = $request->validate([
         'name' => 'required|string|max:255|unique:mata_kuliah,name,' . $matkul->id
      ]);

      $matkul->update($data);
      return redirect()->route('admin.mata_kuliah')->with('success', 'Mata Kuliah updated successfully!');
   }

   public function form_mata_kuliah_edit($id) {
      $matkul = MataKuliah::findOrFail($id);

      return view('admin.form_mata_kuliah', ['matkul' => $matkul]);
   }

   public function kelas(Request $request) {
      $all_periode = Periode::orderBy('id', 'desc')->get();
      if ($request->periode_id) {
         $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode', 'program_studi')->withCount('enrollment')->where('periode_id', $request->periode_id)->orderBy('is_active', 'desc')->get();
      } else {
         $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode', 'program_studi')->withCount('enrollment')->orderBy('is_active', 'desc')->get();
      }
      return view('admin.kelas', ['all_periode' => $all_periode, 'kelas' => $kelas]);
   }

   public function form_kelas() {
      $matkul = MataKuliah::all();
      $periode = Periode::all();
      $program_studi = ProgramStudi::all();
      $dosen = Dosen::with('user')->get();

      return view('admin.form_kelas', ['matkul' => $matkul, 'periode' => $periode, 'dosen' => $dosen, 'program_studi' => $program_studi]);
   }

   public function delete_kelas($id) {
      $kelas = Kelas::findOrFail($id);
      $success_msg = "";
      if($kelas->is_active == 0) {
         $kelas->is_active = 1;
         $success_msg = "Kelas activated successfully!";
      } else {
         $kelas->is_active = 0;
         $success_msg = "Kelas inactivated successfully!";
      }
      $kelas->save();
      return redirect()->route('admin.kelas')->with('success', $success_msg);
   }

   public function insert_kelas(Request $request) {
      $data = $request->validate([
         'mata_kuliah' => 'required',
         'periode' => 'required',
         'dosen' => 'required',
         'program_studi' => 'required',
         'sks' => 'required|integer|min:2'
      ]);

      $kelasFound = Kelas::where('mata_kuliah_id', $request->mata_kuliah)->where('periode_id', $request->periode)->where('program_studi_id', $request->program_studi)->first();
      if($kelasFound) {
         return back()->withErrors(['mata_kuliah' => 'Kelas already exists in this periode!'])->withInput();
      }

      $has_praktikum = 0;
      if($request->has_praktikum) {
         $has_praktikum = 1;
      }
      $kelas = Kelas::create(['mata_kuliah_id' => $request->mata_kuliah, 'periode_id' => $request->periode, 'dosen_nidn' => $request->dosen, 'program_studi_id' => $request->program_studi, 'sks' => $request->sks, 'has_praktikum' => $has_praktikum]);
      if($has_praktikum == 1) {
         Praktikum::create(['kelas_id' => $kelas->id]);
      }
      return redirect()->route('admin.kelas')->with('success', 'Kelas added successfully!');
   }

   public function update_kelas(Request $request, $id) {
      $kelas = Kelas::findOrFail($id);
      $data = $request->validate([
         'mata_kuliah' => 'required',
         'periode' => 'required',
         'dosen' => 'required',
         'program_studi' => 'required',
         'sks' => 'required|integer|min:2'
      ]);

      $kelasFound = Kelas::where('id', '!=', $id)->where('mata_kuliah_id', $request->mata_kuliah)->where('periode_id', $request->periode)->where('program_studi_id', $request->program_studi)->first();
      if($kelasFound) {
         return back()->withErrors(['mata_kuliah' => 'Kelas already exists in this periode!'])->withInput();
      }

      $has_praktikum = 0;
      if($request->has_praktikum) {
         $has_praktikum = 1;
      }

      $kelas->mata_kuliah_id = $request->mata_kuliah;
      $kelas->periode_id = $request->periode;
      $kelas->dosen_nidn = $request->dosen;
      $kelas->program_studi_id = $request->program_studi;
      $kelas->sks = $request->sks;
      $kelas->has_praktikum = $has_praktikum;
      $kelas->save();
      return redirect()->route('admin.kelas')->with('success', 'Kelas updated successfully!');
   }

   public function form_kelas_edit($id) {
      $kelas = Kelas::findOrFail($id);
      $matkul = MataKuliah::all();
      $periode = Periode::all();
      $program_studi = ProgramStudi::all();
      $dosen = Dosen::with('user')->get();
      return view('admin.form_kelas', ['kelas' => $kelas, 'matkul' => $matkul, 'periode' => $periode, 'dosen' => $dosen, 'program_studi' => $program_studi]);
   }

   public function enrollment($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode', 'program_studi')->where('id', $id)->first();
      $enrollments = Enrollment::with(['mahasiswa.user', 'mahasiswa.program_studi'])->where('kelas_id', $id)->get();

      return view('admin.enrollment', ['kelas' => $kelas, 'enrollments' => $enrollments]);
   }

   public function delete_enrollment($kelas_id, $id) {
      $kelas = Kelas::findOrFail($kelas_id);
      Enrollment::findOrFail($id)->delete();
      return redirect()->route('admin.enrollment', $kelas->id)->with('success', 'Enrollment deleted successfully!');
   }

   public function form_enrollment($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode', 'program_studi')->where('id', $id)->first();
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
      $kategori = Kategori::findOrFail($id);
      $indikator = Indikator::where('kategori_id', $id)->get();
      return view('admin.list_indikator', ['indikator' => $indikator, 'kategori' => $kategori]);
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

   public function penilaian(Request $request) {
      $all_kategori = Kategori::all();
      $all_periode = Periode::orderBy('id', 'desc')->get();
      $all_prodi = ProgramStudi::all();
      $penilaian = Penilaian::with('penilai', 'kategori', 'periode', 'dinilai');
      if($request->kategori_id) {
         $penilaian = $penilaian->where('kategori_id', $request->kategori_id);
      }
      if($request->periode_id) {
         $penilaian = $penilaian
         ->where(function ($q) use ($request) {
               $q->whereNotIn('dinilai_type', [
                  'App\Models\Fasilitas',
                  'App\Models\Unit'
               ])->where('periode_id', $request->periode_id);
         })
         ->orWhereIn('dinilai_type', [
               'App\Models\Fasilitas',
               'App\Models\Unit'
         ]);
      }
      if($request->prodi_id) {
         $penilaian->whereHas('penilai', function($query) use ($request) {
            $query->whereHas('mahasiswa', function($qMhs) use ($request) {
               $qMhs->where('program_studi_id', $request->prodi_id);
            });
         });
      }
      $penilaian = $penilaian->get();
      return view('admin.penilaian', ['all_kategori' => $all_kategori, 'all_periode' => $all_periode, 'all_prodi' => $all_prodi, 'penilaian' => $penilaian]);
   }

   public function detail_penilaian($id) {
      $penilaian = Penilaian::with('penilai', 'kategori', 'periode', 'dinilai')->where('id', $id)->first();
      $details = DetailPenilaian::with('indikator')->where('penilaian_id', $id)->get();
      return view('admin.detail_penilaian', ['penilaian' => $penilaian, 'details' => $details]);
   }

   public function laporan(Request $request) {
      $all_kategori = Kategori::all();
      $all_periode = Periode::orderBy('id', 'desc')->get();

      $curKategori = Kategori::findOrFail($request->kategori_id ?? 1);
      $periode_id = $request->periode_id ?? Periode::max('id');

      if($curKategori->id == 6) {
         $penilaian = $this->getPenilaianKampus($periode_id);
      } else {
         $penilaian = $this->getPenilaian($curKategori->id, $periode_id);
      }

      return view('admin.laporan', [
         'all_kategori' => $all_kategori,
         'all_periode' => $all_periode,
         'penilaian' => $penilaian,
         'curKategori' => $curKategori,
         'periode_id' => $periode_id
      ]);
   }

   public function laporan_export_excel($kategori_id, $periode_id) {
      if($kategori_id == 6) {
         $penilaian = $this->getPenilaianKampus($periode_id);
      } else {
         $penilaian = $this->getPenilaian($kategori_id, $periode_id);
      }

      $curKategori = Kategori::findOrFail($kategori_id);

      // Prepare Spreadsheet
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      // Header
      if ($kategori_id == 6) {
         $sheet->setCellValue('A1', 'Nama Indikator');
         $sheet->setCellValue('B1', 'Skor Rata-rata');

         // Isi baris
         $row = 2;
         foreach ($penilaian as $p) {
            $sheet->setCellValue("A{$row}", $p->indikator->name);
            $sheet->setCellValue("B{$row}", $p->avg_score ?? 'Belum Ada Penilaian');
            $row++;
         }
      } else {
         $sheet->setCellValue('A1', 'Nama ' . ucfirst($curKategori->target_role));
         $sheet->setCellValue('B1', 'Skor Rata-rata');
         $sheet->setCellValue('C1', 'Jumlah Penilai');
         
         // Isi baris
         $row = 2;
         foreach ($penilaian as $p) {
   
            if (in_array($curKategori->id, [1, 2])) {
                  $nama = $p->user->name ?? '';
            } elseif (in_array($curKategori->id, [3, 4])) {
                  $nama = $p->name ?? '';
            } else {
                  $nama = $p->kelas->mataKuliah->name ?? '';
            }
   
            $sheet->setCellValue("A{$row}", $nama);
            $sheet->setCellValue("B{$row}", $p->penilaian_avg_avg_score ?? 'Belum Ada Penilaian');
            $sheet->setCellValue("C{$row}", $p->penilaian_count);
            $row++;
         }
      }

      // Filename
      $filename = "laporan_kpi_{$curKategori->name}.xlsx";

      // Output file ke browser
      $writer = new Xlsx($spreadsheet);

      return response()->streamDownload(function () use ($writer) {
         $writer->save('php://output');
      }, $filename);
   }

   public function laporan_export_pdf($kategori_id, $periode_id) {
      if($kategori_id == 6) {
         $penilaian = $this->getPenilaianKampus($periode_id);
      } else {
         $penilaian = $this->getPenilaian($kategori_id, $periode_id);
      }

      $curKategori = Kategori::findOrFail($kategori_id);
      $curPeriode = Periode::findOrFail($periode_id);

      // Generate HTML untuk PDF
      $html = view('admin.laporan_pdf', [
         'penilaian' => $penilaian,
         'curKategori' => $curKategori,
         'curPeriode' => $curPeriode,
      ])->render();

      // Load Dompdf
      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      return $dompdf->stream("laporan_kpi_{$curKategori->name}.pdf");
   }

   public function feedback(Request $request) {
      $all_kategori = Kategori::all();
      $feedbacks = Feedback::with('pengirim', 'kategori', 'target');
      if($request->kategori_id) {
         $feedbacks = $feedbacks->where('kategori_id', $request->kategori_id);
      }
      if($request->has('status') && $request->status != '') {
         $feedbacks = $feedbacks->where('status', intval($request->status));
      }
      $feedbacks = $feedbacks->get();
      return view('admin.feedback', ['all_kategori' => $all_kategori, 'feedbacks' => $feedbacks]);
   }

   public function update_feedback($id) {
      $feedback = Feedback::findOrFail($id);
      if($feedback->status == 1) {
         $feedback->status = 0;
      } else {
         $feedback->status = 1;
      }
      $feedback->save();
      return redirect()->route('admin.feedback')->with('success', 'Feedback updated successfully!');
   }

   public function detail_feedback($id) {
      $feedback = Feedback::with('pengirim.mahasiswa.program_studi', 'kategori', 'target')->findOrFail($id);
      return view('admin.detail_feedback', ['feedback' => $feedback]);
   }

   public function profile() {
      $user = User::where('id', Auth::user()->id)->firstOrFail();
      return view('admin.profile', ['user' => $user]);
   }

   public function update_profile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,'. $user->id,
            'phone_number' => 'required|numeric|min_digits:12|max_digits:13|unique:users,phone_number,'. $user->id,
        ]);

        $user->update([
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }   
    
    public function change_password(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
        }
    
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return back()->with('success', 'Password updated successfully!');
    }

   public function upload_prof_pic(Request $request, $id) {
      $request->validate([
         'file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $user = Auth::user();
      if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
         Storage::disk('public')->delete($user->photo_profile);
      }
      $file = $request->file('file');
      $path = $file->store('profiles', 'public');
      $user->update([
         'photo_profile' => $path,
      ]);
      return redirect()
         ->route('admin.profile')
         ->with('success', 'Photo Profile updated successfully!');
   }

   private function getPenilaian($kategori_id, $periode_id){
      // Mapping kategori to models
      $kategoriModels = [
         1 => Dosen::class,
         3 => Fasilitas::class,
         4 => Unit::class,
         5 => Praktikum::class
      ];

      $modelClass = $kategoriModels[$kategori_id] ?? Dosen::class;
      $penilaian = $modelClass::with('penilaian');

      if ($kategori_id == 1) {
         $penilaian = $penilaian->with('user');
      }

      if ($kategori_id == 5) {
         $penilaian = $penilaian->with('kelas.mataKuliah', 'kelas.program_studi');
      }

      if (!in_array($kategori_id, [3, 4])) {
         $penilaian->withAvg(['penilaian' => function ($q) use ($periode_id) {
            $q->where('periode_id', $periode_id);
         }], 'avg_score');
      } else {
         $penilaian->withAvg('penilaian', 'avg_score');
      }

      $penilaian = $penilaian->withCount('penilaian')->get();

      return $penilaian;
   }

   private function getPenilaianKampus($periode_id) {
      $penilaian = DetailPenilaian::query()
         ->select('indikator_id', DB::raw('AVG(score) as avg_score'))
         ->whereHas('indikator', function ($q) {
               $q->where('kategori_id', 6);
         })
         ->when($periode_id, function ($q) use ($periode_id) {
               // filter berdasarkan periode dari tabel penilaian
               $q->whereHas('penilaian', function ($p) use ($periode_id) {
                  $p->where('periode_id', $periode_id);
               });
         })
         ->groupBy('indikator_id')
         ->with('indikator') // ikutkan data indikatornya
         ->get();

         return $penilaian;
   }
}

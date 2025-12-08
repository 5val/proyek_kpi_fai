<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Kategori;
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
use App\Models\Feedback;
use App\Models\Indikator;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB;


class DosenController extends Controller
{
    // DASHBOARD

    public function dashboard() {
    return view('dosen.dashboard');
    }

//     public function dashboard()
// {
//     $user = Auth::user();

//     // Ambil data dosen berdasarkan user_id
//     $dosen = Dosen::where('user_id', $user->id)->first();

//     if (!$dosen) {
//         return back()->with('error', 'Data dosen tidak ditemukan.');
//     }

//     /*
//     |--------------------------------------------------------------------------
//     | 1. SKOR KINERJA DOSEN (Kategori: dosen)
//     |--------------------------------------------------------------------------
//     | dari tabel: penilaian + detail_penilaian
//     */
//     $kategoriDosen = Kategori::where('name', 'dosen')->first();

//     $skorKinerja = DetailPenilaian::whereHas('penilaian', function ($q) use ($dosen, $kategoriDosen) {
//         $q->where('dinilai_id', $dosen->nidn)
//           ->where('kategori_id', $kategoriDosen->id); 
//     })->avg('score') ?? 0;


//     /*
//     |--------------------------------------------------------------------------
//     | 2. MAHASISWA BIMBINGAN
//     |--------------------------------------------------------------------------
//     | dari tabel mahasiswa (FK: mahasiswa.dosen_nidn)
//     */
//     $bimbingan = Mahasiswa::where('dosen_nidn', $dosen->nidn)->get();
//     $jumlahBimbingan = $bimbingan->count();


//     /*
//     |--------------------------------------------------------------------------
//     | 3. MAHASISWA BELUM DINILAI (Kategori: mahasiswa)
//     |--------------------------------------------------------------------------
//     | dinilai_id = mahasiswa.nrp
//     */
//     $kategoriMhs = Kategori::where('name', 'mahasiswa')->first();

//     $pendingMahasiswa = Mahasiswa::where('dosen_nidn', $dosen->nidn)
//         ->whereDoesntHave('penilaian', function ($q) use ($kategoriMhs, $dosen) {
//             $q->where('kategori_id', $kategoriMhs->id)
//               ->where('penilai_id', $dosen->nidn);
//         })
//         ->get();


//     /*
//     |--------------------------------------------------------------------------
//     | 4. TREND SKOR KINERJA PER PERIODE / SEMESTER
//     |--------------------------------------------------------------------------
//     | ambil rata-rata score dari detail_penilaian grouped by periode
//     */
//     $trend = DetailPenilaian::select(
//             'penilaian.periode_id',
//             DB::raw('AVG(detail_penilaian.score) as avg_skor')
//         )
//         ->join('penilaian', 'penilaian.id', '=', 'detail_penilaian.penilaian_id')
//         ->where('penilaian.dinilai_id', $dosen->nidn)
//         ->where('penilaian.kategori_id', $kategoriDosen->id)
//         ->groupBy('penilaian.periode_id')
//         ->join('periode', 'periode.id', '=', 'penilaian.periode_id')
//         ->orderBy('periode.tahun')
//         ->orderBy('periode.semester')
//         ->get();


//     /*
//     |--------------------------------------------------------------------------
//     | 5. RATING PER INDIKATOR (Kategori: dosen)
//     |--------------------------------------------------------------------------
//     */
//     $ratingIndikator = DetailPenilaian::select(
//             'indikator_id',
//             DB::raw('AVG(score) as avg_score')
//         )
//         ->whereHas('penilaian', function ($q) use ($dosen, $kategoriDosen) {
//             $q->where('dinilai_id', $dosen->nidn)
//               ->where('kategori_id', $kategoriDosen->id);
//         })
//         ->with('indikator')
//         ->groupBy('indikator_id')
//         ->get();


//     /*
//     |--------------------------------------------------------------------------
//     | RETURN KE DASHBOARD VIEW
//     |--------------------------------------------------------------------------
//     */
//     return view('dosen.dashboard', [
//         'user'              => $user,
//         'dosen'             => $dosen,
//         'skorKinerja'       => $skorKinerja,
//         'jumlahBimbingan'   => $jumlahBimbingan,
//         'pendingMahasiswa'  => $pendingMahasiswa,
//         'trend'             => $trend,
//         'ratingIndikator'   => $ratingIndikator,
//     ]);
// }


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
    public function uploadProfpicDosen(Request $request, $id)
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

    // public function kelas()
    // {
    //     $all_periode = Periode::orderBy('id', 'desc')->get();
    //     $periode_id = $request->periode_id ?? Periode::max('id');
    //     // Ambil semua kelas yang diajar oleh dosen ini (via relasi)
    //     $kelasList = Kelas::with('mataKuliah', 'program_studi', 'periode')->withCount('enrollment')->where('dosen_nidn', $dosen->nidn)->where('is_active', 1)->get();

    //     return view('dosen.kelas', [
    //         'kelasList' => $kelasList,
    //         'all_periode' => $all_periode,
    //         'periode_id' => $periode_id,
    //     ]);
    // }
    public function kelas(Request $request)
    {
        // 1. Ambil data User yang sedang login, lalu cari data Dosen-nya
        $userId = Auth::id();
        $dosen = Dosen::where('user_id', $userId)->firstOrFail();

        // 2. Ambil semua data periode untuk dropdown (urutkan dari yang terbaru)
        $all_periode = Periode::orderBy('id', 'desc')->get();

        // 3. Tentukan periode yang dipilih
        // Jika user memilih dari dropdown ($request->periode_id), pakai itu.
        // Jika tidak (baru buka halaman), pakai periode ID terbesar (terbaru).
        $periode_id = $request->periode_id ?? $all_periode->first()->id ?? null;

        // 4. Query Kelas dengan Filter Periode
        $kelasList = Kelas::with(['mataKuliah', 'program_studi', 'periode']) // Eager Load relasi
            ->withCount('enrollment') // Hitung jumlah mahasiswa
            ->where('dosen_nidn', $dosen->nidn) // Filter berdasarkan NIDN dosen yang login
            ->where('is_active', 1) // Hanya kelas aktif
            ->where('periode_id', $periode_id) // <--- PENTING: Filter sesuai periode
            ->get();

        return view('dosen.kelas', [
            'kelasList'   => $kelasList,
            'all_periode' => $all_periode,
            'periode_id'  => $periode_id,
        ]);
    }

    public function insert_kehadiran($id) {
      $kelas = Kelas::with('mataKuliah', 'program_studi', 'periode', 'dosen.user')->findOrFail($id);
      return view('dosen.form_kehadiran', ['kelas' => $kelas]);
    }

    public function download_kehadiran($id) {
      $kelas = Kelas::with('mataKuliah', 'dosen.user', 'periode')->where('id', $id)->first();
      $filePath = storage_path('app/template_excel/template_kehadiran.xlsx');

      if (!file_exists($filePath)) {
         abort(404, 'Template file not found.');
      }

      // Load Excel template
      $spreadsheet = IOFactory::load($filePath);
      $sheet = $spreadsheet->getActiveSheet();

      $mahasiswas = Enrollment::where('kelas_id', $id)->pluck('mahasiswa_nrp')->toArray() ?? []; // adjust relation name

      $row = 2;
      foreach ($mahasiswas as $mhs) {
         $sheet->setCellValue("A{$row}", $mhs);
         $sheet->setCellValue("B{$row}", 1);
         $row++;
      }

      /*
      |-----------------------------------------------------------
      | Return the modified XLSX file as a download
    |-----------------------------------------------------------
    */
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
    $writer->save($tempFile);

    return response()->download($tempFile, 'template_enrollment_filled.xlsx');
   }

   public function upload_kehadiran(Request $request, $id) {
      $request->validate([
            'pertemuan' => 'required',
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

            Kehadiran::create([
               'kelas_id' => $id,
               'pertemuan_ke' => $request->pertemuan,
               'mahasiswa_nrp' => $row[0] ?? null,
               'is_present' => $row[1] ?? null,
            ]);
         }

        return redirect()->route('dosen.kelas')->with('success', 'Kehadiran uploaded successfully.');
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

    // public function penilaianManajemen()
    // {
    //     $user = Auth::user();

    //     $dosen = Dosen::where('user_id', $user->id)->first();
    //     if (!$dosen) {
    //         return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
    //     }

    //     // eager-load user dan penilaian
    //     $mahasiswaList = Mahasiswa::with(['user', 'penilaian'])
    //         ->get();

    //     return view('dosen.penilaian_manajemen', [
    //         'user' => $user,
    //         'dosen' => $dosen,
    //         'mahasiswaList' => $mahasiswaList,
    //     ]);
    // }

    public function penilaianManajemen() {
          return redirect()->route('penilaian.form', ['tipe' => 'manajemen', 'id' => 1]);
    }
// public function penilaianMahasiswa()
// {
//     $user = Auth::user();
//     $dosen = Dosen::where('user_id', $user->id)->first();

//     // Ambil mahasiswa melalui relasi: Dosen → Kelas → Enrollment → Mahasiswa → User
//     $mahasiswaList = Mahasiswa::whereHas('enrollments.kelas', function ($q) use ($dosen) {
//         $q->where('dosen_nidn', $dosen->nidn);
//     })
//     ->with(['user', 'enrollments.kelas'])
//     ->get();

//     return view('dosen.penilaian_mahasiswa', [
//         'user' => $user,
//         'dosen' => $dosen,
//         'mahasiswaList' => $mahasiswaList,
//     ]);
// }
    // PENILAIAN FASILITAS

       public function penilaianFasilitas() {
      $fasilitas = Fasilitas::paginate(10);
      return view('dosen.penilaian_fasilitas', ['fasilitas' => $fasilitas]);
   }

    // PENILAIAN UNIT 
       public function penilaianUnit() {
      $units = Unit::with('penanggungJawab')->paginate(10);
      return view('dosen.penilaian_unit', ['units' => $units]);
   }

    // LAPORAN KERJA 
//     public function laporanKinerja()
//     {
//         $user = Auth::user();
    
//         // CEGAH ERROR: Jika user belum punya data dosen
//         $dosen = Dosen::where('user_id', $user->id)->first();
    
//         // Ambil semua indikator
//         $indikator = Indikator::all();
    
//         // Ambil nilai KPI untuk dosen ini
//         $nilai = Penilaian::where('dosen_id', $dosen->id)
//             ->select('indikator_id', DB::raw('AVG(skor) as skor'))
//             ->groupBy('indikator_id')
//             ->get()
//             ->keyBy('indikator_id');
    
//         // Hitung skor akhir
//         $skorAkhir = $nilai->avg('skor') ?? 0;
    
//         // Tentukan kategori
//         $kategori = 'Buruk';
//         if ($skorAkhir >= 3.5) $kategori = 'Sangat Baik';
//         elseif ($skorAkhir >= 3.0) $kategori = 'Baik';
//         elseif ($skorAkhir >= 2.0) $kategori = 'Cukup';
    
//     return view('dosen.laporan', [
//         'user' => $user,
//         'dosen' => $dosen,
//         'indikator' => $indikator,
//         'nilai' => $nilai,
//         'skorAkhir' => $skorAkhir,
//         'kategori' => $kategori
//     ]);
// }

   
    public function laporanKinerja()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        $indikator = Indikator::where('kategori_id', 1)->get();
        $all_periode = Periode::orderBy('id', 'desc')->get();
        $periode_id = $request->periode_id ?? Periode::max('id');
        return view('dosen.laporan', compact('user', 'dosen', 'indikator', 'all_periode', 'periode_id' ));
    }

    public function laporan(Request $request)
    {
    $userId = auth()->id();

    // Ambil data mahasiswa
    $mahasiswa = Mahasiswa::with('user', 'program_studi')
        ->where('user_id', $userId)
        ->firstOrFail();

    // Semua periode
    $all_periode = Periode::orderBy('id', 'desc')->get();
    $periode_id = $request->periode_id ?? Periode::max('id');

    // Ambil kelas yang diikuti mahasiswa pada periode tersebut
    $kelasDiambil = Kelas::with(['mata_kuliah', 'dosen'])
        ->where('periode_id', $periode_id)
        ->whereHas('enrollment.mahasiswa', function ($q) use ($mahasiswa) {
            $q->where('mahasiswa_nrp', $mahasiswa->id);
        })
        ->get();

    $hasil = [];

    foreach ($kelasDiambil as $k) {

        // Total Pertemuan
        $totalPertemuan = Kehadiran::where('kelas_id', $k->id)->count();

        // Kehadiran mahasiswa
        $hadir = Kehadiran::where('kelas_id', $k->id)
            ->where('mahasiswa_nrp', $mahasiswa->id)
            ->where('status', 'hadir')
            ->count();

        $persenHadir = $totalPertemuan > 0
            ? round(($hadir / $totalPertemuan) * 100, 2)
            : 0;

        $hasil[] = [
            'kelas'      => $k->mata_kuliah->nama,
            'dosen'      => $k->dosen->name,
            'sks'        => $k->sks ?? 0,
            'kehadiran'  => $persenHadir
        ];
    }

    
    // Ambil feedback dosen
    $feedback = Feedback::where('kategori_id', 2)
        ->where('target_id', $userId)
        ->with('pengirim')
        ->get();

    return view('mahasiswa.laporan', [
        'all_periode' => $all_periode,
        'periode_id' => $periode_id,
        'mahasiswa' => $mahasiswa,
        'hasil' => $hasil,
        'feedback' => $feedback
    ]);
}

    public function laporan_export_pdf($kategori_id, $periode_id) {
      $penilaian = $this->getPenilaian($kategori_id, $periode_id);

      $curKategori = Kategori::findOrFail($kategori_id);

      // Generate HTML untuk PDF
      $html = view('admin.laporan_pdf', [
         'penilaian' => $penilaian,
         'curKategori' => $curKategori
      ])->render();

      // Load Dompdf
      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      return $dompdf->stream("laporan_kpi_{$curKategori->name}.pdf");
   }

    // public function feedback() {
    //   $kategori = Kategori::whereIn('id', [3, 6])->get();
    //   return view('dosen.feedback', ['kategori' => $kategori]);
    // }

public function feedback() {
    // 1. Ambil Kategori
    $kategori = Kategori::whereIn('id', [3, 6])->get(); // Atau sesuaikan filter jika perlu

    // 2. Ambil Riwayat Feedback
    $riwayat = Feedback::with(['kategori', 'target']) // Eager load
                ->where('pengirim_id', Auth::id()) // Sesuai kolom DB: pengirim_id
                ->latest()
                ->limit(10)
                ->get();

    return view('dosen.feedback', [ // Sesuaikan nama view folder Anda
        'kategori' => $kategori,
        'riwayat' => $riwayat
    ]);
}

    public function insertFeedback(Request $request) 
   {
      $validated = $request->validate([
         'kategori' => 'required|exists:kategori,id',
         'target' => 'required',
         'deskripsi' => 'required|string|max:255',
         'file' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
      ]);
      $isAnonim = $request->has('anonim') ? 1 : 0;
      $path = null;
      if ($request->hasFile('file')) {
         $path = $request->file('file')->store('foto', 'public');
      }
      $user = auth()->user();
      if($request->kategori == 3) {
         $target_type = 'App\Models\Fasilitas';
      } else {
         nullable();
      }
      $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
      Feedback::create([
         'pengirim_id' => $user->id, 
         'kategori_id' => $validated['kategori'],
         'target_id' => $validated['target'],
         'target_type' => $target_type,
         'isi' => $validated['deskripsi'],
         'foto' => $path,
         'is_anonymous' => $isAnonim,
      ]);
      return redirect()
         ->route('dosen.feedback')
         ->with('success', 'Feedback berhasil dikirim!');
   }

   // DASHBOARD

//    public function index()
//     {
//         $user = Auth::user();
        
//         // Pastikan user adalah dosen
//         if ($user->role !== 'dosen' || !$user->dosen) {
//             abort(403, 'Akses khusus Dosen');
//         }

//         $dosen = $user->dosen;

//         // --- 1. Statistik Skor Kinerja (KPI) ---
//         // Ambil periode terakhir yang aktif atau paling baru
//         $currentPeriode = Periode::latest('id')->first();
        
//         // Ambil rata-rata skor penilaian kategori Dosen (id=1) untuk dosen ini di periode ini
//         $currentScore = Penilaian::where('dinilai_type', 'App\Models\Dosen')
//                         ->where('dinilai_id', $dosen->id)
//                         ->where('kategori_id', 1) // 1 = Kinerja Dosen (sesuai SQL dump)
//                         ->where('periode_id', $currentPeriode->id ?? 0)
//                         ->avg('avg_score'); // Kolom avg_score ada di tabel penilaian

//         // Skor periode sebelumnya untuk perbandingan
//         $prevPeriode = Periode::where('id', '<', $currentPeriode->id ?? 0)->latest('id')->first();
//         $prevScore = 0;
//         if($prevPeriode) {
//             $prevScore = Penilaian::where('dinilai_type', 'App\Models\Dosen')
//                         ->where('dinilai_id', $dosen->id)
//                         ->where('kategori_id', 1)
//                         ->where('periode_id', $prevPeriode->id)
//                         ->avg('avg_score');
//         }

//         $scoreDiff = $currentScore - $prevScore;

//         // --- 2. Statistik Mahasiswa (Berdasarkan Enrollment Kelas) ---
//         // Mencari ID kelas yang diajar dosen ini
//         $kelasIds = Kelas::where('dosen_nidn', $dosen->nidn)
//                     ->where('is_active', 1)
//                     ->pluck('id');
        
//         // Menghitung total mahasiswa unik yang diajar
//         $totalStudents = Enrollment::whereIn('kelas_id', $kelasIds)
//                         ->distinct('mahasiswa_nrp')
//                         ->count('mahasiswa_nrp');

//         // --- 3. Data Grafik Tren (Line Chart) ---
//         // Mengambil rata-rata skor per periode
//         $historyData = Penilaian::select('periode_id', DB::raw('AVG(avg_score) as score'))
//                         ->where('dinilai_type', 'App\Models\Dosen')
//                         ->where('dinilai_id', $dosen->id)
//                         ->where('kategori_id', 1)
//                         ->groupBy('periode_id')
//                         ->with('periode') // Eager load nama periode
//                         ->orderBy('periode_id', 'asc')
//                         ->limit(5)
//                         ->get();

//         $chartLabels = $historyData->map(fn($item) => $item->periode->nama_periode)->toArray();
//         $chartScores = $historyData->pluck('score')->toArray();

//         // --- 4. Data Mahasiswa di Kelas (Pengganti Pending Assessment) ---
//         // Karena di database tidak ada tabel 'tugas_pending', kita tampilkan mahasiswa di kelas aktif
//         $studentList = Enrollment::with(['mahasiswa.user', 'mahasiswa', 'kelas.mataKuliah']) // Load relasi
//                         ->whereIn('kelas_id', $kelasIds)
//                         ->limit(5) // Batasi 5 baris saja
//                         ->get();

//         return view('dosen.dashboard', compact(
//             'user',
//             'dosen',
//             'currentScore',
//             'scoreDiff',
//             'totalStudents',
//             'chartLabels',
//             'chartScores',
//             'studentList'
//         ));
//     }

public function index()
    {
        $userId = Auth::id();
        
        // 1. Ambil Data Dosen yang sedang login
        $dosen = Dosen::where('user_id', $userId)->firstOrFail();

        // 2. Tentukan Periode
        // Periode Aktif (Terbaru)
        $currentPeriode = Periode::orderBy('id', 'desc')->first();
        $currentPeriodeId = $currentPeriode ? $currentPeriode->id : 0;

        // Periode Sebelumnya (Untuk perbandingan)
        $prevPeriode = Periode::where('id', '<', $currentPeriodeId)
                        ->orderBy('id', 'desc')
                        ->first();
        $prevPeriodeId = $prevPeriode ? $prevPeriode->id : 0;


        // 3. Statistik: Skor Kinerja Mengajar (Real-time dari tabel Penilaian)
        // Kategori ID 1 = Kinerja Dosen (Sesuai database Anda)
        $currentScore = Penilaian::where('dinilai_id', $dosen->id)
                        ->where('dinilai_type', 'App\Models\Dosen')
                        ->where('kategori_id', 1) 
                        ->where('periode_id', $currentPeriodeId)
                        ->avg('avg_score');
        
        // Jika null (belum ada nilai), set ke 0
        $currentScore = $currentScore ? round($currentScore, 2) : 0;

        // Ambil Skor Periode Lalu
        $prevScore = Penilaian::where('dinilai_id', $dosen->id)
                        ->where('dinilai_type', 'App\Models\Dosen')
                        ->where('kategori_id', 1) 
                        ->where('periode_id', $prevPeriodeId)
                        ->avg('avg_score');
        
        $prevScore = $prevScore ? round($prevScore, 2) : 0;
        
        // Hitung Selisih
        $scoreDiff = $currentScore - $prevScore;


        // 4. Statistik: Jumlah Mahasiswa (Total mahasiswa unik di kelas aktif semester ini)
        $studentCount = DB::table('enrollment')
            ->join('kelas', 'enrollment.kelas_id', '=', 'kelas.id')
            ->where('kelas.dosen_nidn', $dosen->nidn)
            ->where('kelas.periode_id', $currentPeriodeId) // Hanya periode aktif
            ->distinct('enrollment.mahasiswa_nrp')
            ->count('enrollment.mahasiswa_nrp');


        // 5. Chart 1: Tren Skor Kinerja (Line Chart)
        // Ambil rata-rata skor per periode, khusus kategori dosen
        $trendData = DB::table('penilaian')
            ->join('periode', 'penilaian.periode_id', '=', 'periode.id')
            ->where('penilaian.dinilai_id', $dosen->id)
            ->where('penilaian.dinilai_type', 'App\Models\Dosen')
            ->where('penilaian.kategori_id', 1) // PENTING: Filter hanya kinerja dosen
            ->select('periode.nama_periode', DB::raw('AVG(penilaian.avg_score) as avg_score'))
            ->groupBy('periode.id', 'periode.nama_periode')
            ->orderBy('periode.id', 'asc')
            ->limit(5) // Ambil 5 periode terakhir
            ->get();

        $chartLabels = $trendData->pluck('nama_periode');
        // Format angka desimal chart
        $chartValues = $trendData->pluck('avg_score')->map(fn($val) => round($val, 2));


        // 6. Chart 2: Rating per Indikator (Doughnut Chart)
        // Fokus pada indikator penilaian di periode ini agar relevan
        $ratingData = DB::table('detail_penilaian')
            ->join('penilaian', 'detail_penilaian.penilaian_id', '=', 'penilaian.id')
            ->join('indikator', 'detail_penilaian.indikator_id', '=', 'indikator.id')
            ->where('penilaian.dinilai_id', $dosen->id)
            ->where('penilaian.dinilai_type', 'App\Models\Dosen')
            ->where('penilaian.kategori_id', 1)
            ->where('penilaian.periode_id', $currentPeriodeId) // Data periode ini saja
            ->select('indikator.name', DB::raw('AVG(detail_penilaian.score) as avg_score'))
            ->groupBy('indikator.id', 'indikator.name')
            ->orderBy('avg_score', 'desc')
            ->limit(5)
            ->get();

        $ratingLabels = $ratingData->pluck('name');
        $ratingValues = $ratingData->pluck('avg_score')->map(function($val) {
            return number_format($val, 1);
        });


        // 7. Table: Mahasiswa
        // Mengambil daftar mahasiswa dari kelas aktif dosen tersebut
        $studentsList = DB::table('enrollment')
            ->join('kelas', 'enrollment.kelas_id', '=', 'kelas.id')
            ->join('periode', 'kelas.periode_id', '=', 'periode.id') // <--- TAMBAHKAN JOIN INI
            ->join('mahasiswa', 'enrollment.mahasiswa_nrp', '=', 'mahasiswa.nrp')
            ->join('users', 'mahasiswa.user_id', '=', 'users.id')
            ->where('kelas.dosen_nidn', $dosen->nidn)
            ->where('kelas.periode_id', $currentPeriodeId) 
            ->select(
                'users.name', 
                'mahasiswa.nrp', 
                'periode.semester', // Ambil kolom semester (gasal/genap)
                'periode.tahun'     // Ambil kolom tahun (2025)
            )
            ->distinct()
            ->limit(5)
            ->get();

        return view('dosen.dashboard', compact(
            'currentScore', 
            'scoreDiff', 
            'studentCount', 
            'chartLabels', 
            'chartValues', 
            'ratingLabels', 
            'ratingValues',
            'studentsList'
        ));
    }

}
